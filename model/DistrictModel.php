<?php
require_once "Database.php";

class DistrictModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllDistricts() {
        $query = "SELECT * FROM district";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDistrictById($id) {
        $query = "SELECT * FROM district WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getDistrictsByProvince($province_id) {
        $query = "SELECT * FROM district WHERE province_id = :province_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':province_id', $province_id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createDistrict($name, $province_id) {
        $query = "INSERT INTO district (name, province_id) VALUES (:name, :province_id)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':province_id', $province_id);
        return $stmt->execute();
    }

    public function updateDistrict($id, $name, $province_id) {
        $query = "UPDATE district SET name = :name, province_id = :province_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':province_id', $province_id);
        return $stmt->execute();
    }

    public function deleteDistrict($id) {
        $query = "DELETE FROM district WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>
