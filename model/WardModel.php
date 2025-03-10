<?php
require_once "Database.php";

class WardModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllWards() {
        $query = "SELECT * FROM ward";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getWardById($id) {
        $query = "SELECT * FROM ward WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getWardsByDistrict($district_id) {
        $query = "SELECT * FROM ward WHERE district_id = :district_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':district_id', $district_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createWard($name, $district_id) {
        $query = "INSERT INTO ward (name, district_id) VALUES (:name, :district_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':district_id', $district_id);
        return $stmt->execute();
    }

    public function updateWard($id, $name, $district_id) {
        $query = "UPDATE ward SET name = :name, district_id = :district_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':district_id', $district_id);
        return $stmt->execute();
    }

    public function deleteWard($id) {
        $query = "DELETE FROM ward WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
