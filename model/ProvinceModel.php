<?php
require_once "Database.php";

class ProvinceModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllProvinces() {
        $query = "SELECT * FROM province";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProvinceById($id) {
        $query = "SELECT * FROM province WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProvince($name) {
        $query = "INSERT INTO province (name) VALUES (:name)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public function updateProvince($id, $name) {
        $query = "UPDATE province SET name = :name WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        return $stmt->execute();
    }

    public function deleteProvince($id) {
        $query = "DELETE FROM province WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>