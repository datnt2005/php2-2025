<?php
require_once "Database.php";

class BannerModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllBanners() {
        $query = "SELECT * FROM banners";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getBannerById($id) {
        $query = "SELECT * FROM banners WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createBanner($title, $imagePath, $status) {
        $query = "INSERT INTO banners (title, image, status) VALUES (:title, :image, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":title", $title);
        $stmt->bindParam(":image", $imagePath);
        $stmt->bindParam(":status", $status);
        return $stmt->execute();
    }

    public function updateBanner($id, $title, $imagePath, $status) {
        $query = "UPDATE banners SET title = :title, image = :image, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':title', $title);
        $stmt->bindParam(':image', $imagePath);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function deleteBanner($id) {
        $query = "DELETE FROM banners WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>