<?php
require_once "Database.php";

class UserModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllUsers() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserById($id) {
        $query = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createUser($name, $email, $password, $role, $status) {
        $query = "INSERT INTO users (name, email, password, role, status) VALUES (:name, :email, :password, :role, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function updateUser($id, $name, $email, $password, $role, $status) {
        $query = "UPDATE users SET name = :name, email = :email, password = :password, role = :role, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':role', $role);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();

    }

    public function deleteUser($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function login($email, $password) {
        $query = "SELECT * FROM users WHERE email = :email AND password = :password";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
          $_SESSION['user'] = [
                'id' => $user['id'],
                'name' => $user['name'],
                'email' => $user['email'],
            ];
            return true;
        }
        return false;
    }

    public function register($name, $email, $password) {
        $query = "INSERT INTO users (name, email, password) VALUES (:name, :email, :password)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);
        return $stmt->execute();
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user) {
            $_SESSION['email'] = $user['email'];
            return true;
        }
        return false;
    }

    public function updatePassword($email, $hashedPassword) {
        $query = "UPDATE users SET password = :password WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $hashedPassword);
        return $stmt->execute();
    }

    public function getOTP($email) {
        $query = "SELECT otp FROM users WHERE email = :email";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function saveOTP($email, $otp) {
        $otpExpiration = date('Y-m-d H:i:s', strtotime('+10 minutes')); // OTP có hiệu lực 10 phút
        $sql = "UPDATE users SET otp = ?, otp_expired_at = ? WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$otp, $otpExpiration, $email]);
    }

    // Kiểm tra tính hợp lệ của OTP
    public function validateOTP($email, $otp) {
        $sql = "SELECT otp, otp_expired_at FROM users WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
        $result = $stmt->fetch();

        if ($result && $result['otp'] == $otp && strtotime($result['otp_expired_at']) > time()) {
            return true;
        }

        return false;
    }

    public function deleteOTP($email) {
        $sql = "UPDATE users SET otp = NULL, otp_expired_at = NULL WHERE email = ?";
        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$email]);
    }
}
?>