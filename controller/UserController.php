<?php
require_once "model/UserModel.php";
require_once "view/helpers.php";
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

class UserController {
    private $userModel;
    private $googleClient;
    public function __construct() {
        $this->userModel = new UserModel();
        
        $this->googleClient = new Google_Client();
        $this->googleClient->setClientId('284544138294-js7c7nrmu14e6a34dlmer48r384vcvh2.apps.googleusercontent.com');
        $this->googleClient->setClientSecret('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');
        $this->googleClient->setRedirectUri('http://localhost:8000/google/callback'); // Thay bằng URL callback của bạn
        $this->googleClient->addScope('email');
        $this->googleClient->addScope('profile');
    }

    public function index() {
        $users = $this->userModel->getAllUsers();
        renderView("view/users/user_list.php", compact('users'), "User List");
    }

    public function show($id) {
        $user = $this->userModel->getUserById($id);
        renderView("view/users/user_detail.php", compact('user'), "User Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $status = $_POST['status'];

            $this->userModel->createUser($name, $email, $password, $role, $status);
            header("Location: /users");
        } else {
            renderView("view/users/user_create.php", [], "Create User");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $email = $_POST['email'];
            $password = $_POST['password'];
            $role = $_POST['role'];
            $status = $_POST['status'];

            $this->userModel->updateUser($id, $name, $email, $password, $role, $status);
            header("Location: /users");
        } else {
            $user = $this->userModel->getUserById($id);
            renderView("view/users/user_edit.php", compact('user'), "Edit User");
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
            $password = $_POST['password'];

            if ($this->userModel->register($name, $email, $password)) {
                header("Location: /login");
                exit;
            } else {
                $error = "Registration failed. Email may already be in use.";
            }
        }
        renderView("view/auth/register.php", compact('error'), "Register");
    }

    public function login() {
        $error = null;
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];
            $password = $_POST['password'];

            $user = $this->userModel->login($email, $password);
            if ($user) {
                // $_SESSION['user'] = $user;
                header("Location: /products");
                exit;
            } else {
                $error = "Invalid email or password.";
            }
        }
        renderView("view/auth/login.php", compact('error'), "Login");
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
        renderView("view/auth/dashboard.php", compact('user'), "Dashboard");
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
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'ntdad2005@gmail.com';
                    $mail->Password = 'neoqrbrvqtuonfnv';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    $mail->setFrom('ntdad2005@gmail.com', 'tdajtshop');
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

        renderView("view/auth/forgotPassword.php", compact('error', 'success'), "Forgot Password");
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

        renderView("view/auth/resetPassword.php", compact('error', 'success'), "Reset Password");
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
                
                if (empty($googleUser->email) || empty($googleUser->name)) {
                    throw new Exception('Incomplete user information retrieved from Google.');
                }
    
                $email = $googleUser->email;
                $name = $googleUser->name;
    
                // Kiểm tra người dùng trong cơ sở dữ liệu
                $user = $this->userModel->getUserByEmail($email);
                if (!$user) {
                    // Nếu người dùng chưa tồn tại, tạo mới tài khoản
                    $password = password_hash(uniqid(), PASSWORD_BCRYPT); // Tạo mật khẩu ngẫu nhiên
                    $role = 'user'; // Gán vai trò mặc định
                    $status = 'active';
    
                    $this->userModel->createUser($name, $email, $password, $role, $status);
                    $user = $this->userModel->getUserByEmail($email); // Lấy lại thông tin người dùng
                }
    
                // Lưu thông tin người dùng vào session
                $_SESSION['user'] = $user;
                header("Location: /products");
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
    
    
}
