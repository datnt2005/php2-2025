<?php
require_once "Database.php";

class ColorModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllColors() {
        $query = "SELECT * FROM colors";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getColorById($id) {
        $query = "SELECT * FROM colors WHERE idColor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createColor($nameColor) {
        $query = "INSERT INTO colors (nameColor) VALUES (:nameColor)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':nameColor', $nameColor);
        return $stmt->execute();
    }

    public function updateColor($id, $nameColor) {
        $query = "UPDATE colors SET nameColor = :nameColor WHERE idColor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nameColor', $nameColor);
        return $stmt->execute();
    }

    public function deleteColor($id) {
        $query = "DELETE FROM colors WHERE idColor = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>