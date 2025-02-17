<?php
require_once "Database.php";

class SizeModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllSizes() {
        $query = "SELECT * FROM sizes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getSizeById($id) {
        $query = "SELECT * FROM sizes WHERE idSize = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createSize($nameSize) {
        $query = "INSERT INTO sizes (nameSize) VALUES (:nameSize)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nameSize', $nameSize);
        return $stmt->execute();
    }

    public function updateSize($id, $nameSize) {
        $query = "UPDATE sizes SET nameSize = :nameSize WHERE idSize = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nameSize', $nameSize);
        return $stmt->execute();
    }

    public function deleteSize($id) {
        $query = "DELETE FROM sizes WHERE idSize = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>