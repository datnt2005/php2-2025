<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
require_once "vendor/autoload.php";
use PHPMailer\PHPMailer\SMTP;

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();
class UserController {
    private $userModel;
    private $googleClient;
    public function __construct() {
        $this->userModel = new UserModel();
        
        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId($_ENV['GOOGLE_CLIENT_ID']);
        $this->googleClient->setClientSecret($_ENV['GOOGLE_CLIENT_SECRET']);
        $this->googleClient->setRedirectUri($_ENV['GOOGLE_CALLBACK_URL']);
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        renderViewAdmin("view/admin/users/user_list.php", compact('users'), "User List");
    }


    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $status = $_POST['status'];

            $this->userModel->createUser($name, $email, $phone, $password, $role, $status);
            header("Location: /users");
        } else {
            renderViewAdmin("view/admin/users/user_create.php", [], "Create User");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $status = $_POST['status'];

            $this->userModel->updateUser($id, $name, $email, $phone, $password, $role, $status);
            header("Location: /users");
        } else {
            $user = $this->userModel->getUserById($id);
            renderViewAdmin("view/admin/users/user_edit.php", compact('user'), "Edit User");
        }
    }

    public function delete($id) {
        $this->userModel->deleteUser($id);
        header("Location: /users");
    }

    public function register() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $phone = $_POST['phone'];
            $password = $_POST['password'];

            if ($this->userModel->register($name, $email, $phone, $password)) {
                header("Location: /login");
                exit;
            } else {
                $error = "Registration failed. Email may already be in use.";
            }
        }
        renderViewUser("view/user/auth/register.php", compact('error'), "Register");
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if ($user) {
                $users = $this->userModel->getUserByEmailUser($email);
                $_SESSION['user'] = $users;
                header("Location: /");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        }
        renderViewUser("view/user/auth/login.php", compact('error'), "Login");
    }

    public function logout() {
        session_destroy();
        header("Location: /login");
        exit;
    }

    public function dashboard() {
        if (!isset($_SESSION['user'])) {
            header("Location: /login");
            exit;
        }

        $user = $_SESSION['user'];
        renderViewUser("view/user/auth/dashboard.php", compact('user'), "Dashboard");
    }

    public function forgotPassword() {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            $user = $this->userModel->getUserByEmail($email);
            if ($user) {
                $otp = rand(100000, 999999);
                $this->userModel->saveOTP($email, $otp);

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = $_ENV['SMTP_HOST'];
                    $mail->SMTPAuth = $_ENV['SMTP_AUTH'];
                    $mail->Username = $_ENV['SMTP_USERNAME'];
                    $mail->Password = $_ENV['SMTP_PASSWORD'];
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom($_ENV['SMTP_USERNAME'], 'tdajtshop');
                    $mail->addAddress($email);

                    $mail->isHTML(true);
                    $mail->Subject = "Reset Password OTP";
                    $mail->Body = "Your OTP code to reset the password is: $otp. This code is valid for 10 minutes.";

                    $mail->send();
                    $success = "An OTP has been sent to your email.";
                } catch (Exception $e) {
                    $error = "Failed to send OTP. Please try again.";
                }

                header("Location: /resetPassword");
            } else {
                $error = "No account found with this email.";
            }
        }

        renderViewUser("view/user/auth/forgotPassword.php", compact('error', 'success'), "Forgot Password");
    }

    public function resetPassword() {
        $error = null;
        $success = null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $otp = $_POST['otp'];
            $password = $_POST['password'];
            $passwordConfirm = $_POST['passwordConfirm'];

            $storedOTP = $this->userModel->getOTP($email);
            if ($storedOTP != $otp) {
                $error = "Invalid OTP. Please try again.";
            } elseif ($password !== $passwordConfirm) {
                $error = "Passwords do not match.";
            } else {
                $this->userModel->updatePassword($email, $password);
                $success = "Password reset successfully.";

                // Clear OTP from the database after successful reset
                $this->userModel->deleteOTP($email);
                session_destroy();
                header("Location: /login");
            }
        }

        renderViewUser("view/user/auth/resetPassword.php", compact('error', 'success'), "Reset Password");
    }

    public function googleLogin() {
        $loginUrl = $this->googleClient->createAuthUrl();
        header("Location: $loginUrl");
        exit;
    }

    public function googleCallback() {
        if (isset($_GET['code'])) {
            try {
                // Lấy mã truy cập từ mã ủy quyền
                $token = $this->googleClient->fetchAccessTokenWithAuthCode($_GET['code']);
                
                // Kiểm tra lỗi khi lấy mã truy cập
                if (isset($token['error'])) {
                    throw new Exception('Error fetching access token: ' . $token['error_description']);
                }
    
                // Thiết lập mã truy cập vào client
                $this->googleClient->setAccessToken($token['access_token']);
                
                // Lấy thông tin người dùng từ Google
                $googleService = new Google_Service_Oauth2($this->googleClient);
                $googleUser = $googleService->userinfo->get();
                
                // Kiểm tra tính đầy đủ của thông tin người dùng
                if (empty($googleUser->email) || empty($googleUser->name)) {
                    throw new Exception('Incomplete user information retrieved from Google.');
                }
    
                // Lấy thông tin cần thiết từ Google
                $userInfo = [
                    'id' => $googleUser->id,         // ID người dùng từ Google
                    'name' => $googleUser->name,     // Tên người dùng
                    'email' => $googleUser->email,   // Email người dùng
                    'avatar' => $googleUser->picture // Hình ảnh người dùng
                ];
    
                // Kiểm tra người dùng trong cơ sở dữ liệu
                $user = $this->userModel->getUserByEmail($userInfo['email']);
                if (!$user) {
                    // Nếu người dùng chưa tồn tại, tạo mới tài khoản
                    $password = password_hash(uniqid(), PASSWORD_BCRYPT); // Tạo mật khẩu ngẫu nhiên
                    $role = 'user'; // Gán vai trò mặc định
                    $status = 'active';
    
                    $this->userModel->createUser($userInfo['name'], $userInfo['email'], $password, $role, $status);
                    $user = $this->userModel->getUserByEmail($userInfo['email']); // Lấy lại thông tin người dùng
                }
    
                // Lưu thông tin người dùng vào session
                $_SESSION['user'] = $userInfo; // Lưu người dùng vào session                
                header("Location: /shop ");
                exit;
            } catch (Exception $e) {
                // Ghi log lỗi để dễ dàng debug
                error_log("Google Login Error: " . $e->getMessage());
                $_SESSION['error_message'] = "An error occurred during Google login. Please try again.";
            }
        }
    
        // Nếu không có mã code hoặc xảy ra lỗi, chuyển hướng về trang đăng nhập
        header("Location: /login");
        exit;
    }   
    
    public function updateAccount() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Kiểm tra người dùng đã đăng nhập
            // if (!isset($_SESSION['user'])) {
            //     $_SESSION['error'] = "Bạn cần đăng nhập để cập nhật tài khoản!";
            //     header("Location: /login");
            //     exit;
            // }
    
            // Lấy ID người dùng từ session
            $idUser = $_SESSION['user']['id'];
            $name = trim($_POST['name']);
            $email = trim($_POST['email']);
            $phone = trim($_POST['phone']);
            $avatar = $_FILES['avatar'];
    
            // Kiểm tra dữ liệu nhập vào (không được rỗng)
            if (empty($name) || empty($email) || empty($phone)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
                header("Location: /account");
                exit;
            }
    
            // Kiểm tra định dạng email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error'] = "Email không hợp lệ!";
                header("Location: /account");
                exit;
            }
    
            // Kiểm tra định dạng số điện thoại (chỉ cho phép số)
            if (!preg_match('/^[0-9]{10,11}$/', $phone)) {
                $_SESSION['error'] = "Số điện thoại không hợp lệ!";
                header("Location: /account");
                exit;
            }
    
            // Xử lý upload avatar (nếu có)
            $avatarPath = $_SESSION['user']['avatar'] ?? null; // Giữ nguyên avatar cũ nếu không có ảnh mới
            if ($avatar['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($avatar['tmp_name']);
    
                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['error'] = "Chỉ chấp nhận tệp JPG, PNG, GIF!";
                    header("Location: /account");
                    exit;
                }
    
                // Tạo tên file mới để tránh trùng lặp
                $fileExt = pathinfo($avatar['name'], PATHINFO_EXTENSION);
                $fileName = time() . '_' . uniqid() . '.' . $fileExt;
                $uploadFile = $uploadDir . $fileName;
    
                // Di chuyển file upload vào thư mục
                if (move_uploaded_file($avatar['tmp_name'], $uploadFile)) {
                    $avatarPath = $uploadFile;
                } else {
                    $_SESSION['error'] = "Lỗi khi tải ảnh đại diện!";
                    header("Location: /account");
                    exit;
                }
            }
    
            // Cập nhật thông tin người dùng trong database
            $updated = $this->userModel->updateAccount($idUser, $name, $email, $phone, $avatarPath);
    
            if ($updated) {
                $_SESSION['success'] = "Cập nhật tài khoản thành công!";
                $_SESSION['user']['name'] = $name;
                $_SESSION['user']['email'] = $email;
                $_SESSION['user']['phone'] = $phone;
                $_SESSION['user']['avatar'] = $avatarPath;
                header("Location: /account");
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật tài khoản!";
                header("Location: /account");
            }
        } else {
            // Lấy thông tin user hiện tại
            $idUser = $_SESSION['user']['id'];
            $user = $this->userModel->getUserById($idUser);
            renderViewUser("view/admin/users/user_detail.php", compact('user'), "Edit User");
        }
    }

    public function updateAccountPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy ID người dùng từ session
            $idUser = $_SESSION['user']['id'];
            $password = $_POST['password'];
            $newPassword = $_POST['newPassword'];
            $confirmPassword = $_POST['confirmPassword'];
    
            // Kiểm tra dữ liệu nhập vào (không được rỗng)
            if (empty($password) || empty($newPassword) || empty($confirmPassword)) {
                $_SESSION['error'] = "Vui lòng nhập đầy đủ thông tin!";
                header("Location: /users/updateAccountPassword");
                exit;
            }
    
           $user = $this->userModel->getUserById($idUser);
           $hashedPassword = $user['password'];
           if($password !== $hashedPassword){
                $_SESSION['error'] = 'Sai mật khẩu';
                header("Location: /users/updateAccountPassword");
                exit;
           }
    
           if ($newPassword !== $confirmPassword){
            $_SESSION['error'] = 'Mật khẩu không khớp nhau';
            header("Location: /users/updateAccountPassword");
                exit;
           }

           
            // Cập nhật thông tin người dùng trong database
            $updated = $this->userModel->updateAccountPassword($idUser, $newPassword);
    
            if ($updated) {
                $_SESSION['success'] = "Cập nhật mật khẩu thành công!";
                header("Location: /account");
            } else {
                $_SESSION['error'] = "Có lỗi xảy ra khi cập nhật mật khẩu!";
                header("Location: /account");
            }
        } else {
            // Lấy thông tin user hiện tại
            $idUser = $_SESSION['user']['id'];
            $user = $this->userModel->getUserById($idUser);
            renderViewUser("view/admin/users/account_password.php", compact('user'), "Edit User");
        }
    }
    
}
