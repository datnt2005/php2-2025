<?php
require_once "Database.php";

class StoreModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllStores() {
        $query = "SELECT s.*, p.name as province_name, d.name as district_name, w.name as ward_name 
                FROM stores s
                JOIN province p ON s.province_id = p.province_id
                JOIN district d ON s.district_id = d.district_id
                JOIN wards w ON s.ward_id = w.wards_id";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getStoreById($id) {
        $query = "SELECT * FROM stores WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createStore($name, $description, $address, $open_time, $close_time, $phone_number, $province_id, $district_id, $ward_id) {
        $query = "INSERT INTO stores (name, description, address, open_time, close_time, phone_number, province_id, district_id, ward_id, created_at) 
                VALUES (:name, :description, :address, :open_time, :close_time, :phone_number, :province_id, :district_id, :ward_id, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':open_time', $open_time);
        $stmt->bindParam(':close_time', $close_time);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':province_id', $province_id);
        $stmt->bindParam(':district_id', $district_id);
        $stmt->bindParam(':ward_id', $ward_id);
        $stmt->execute();
        return $stmt->execute();
    }

    public function updateStore($id, $name, $description,$address, $open_time, $close_time, $phone_number, $province_id, $district_id, $ward_id) {
        $query = "UPDATE stores SET name = :name, description = :description, address = :address, open_time = :open_time, close_time = :close_time, phone_number = :phone_number, province_id = :province_id, district_id = :district_id, ward_id = :ward_id WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':open_time', $open_time);
        $stmt->bindParam(':close_time', $close_time);
        $stmt->bindParam(':phone_number', $phone_number);
        $stmt->bindParam(':province_id', $province_id);
        $stmt->bindParam(':district_id', $district_id);
        $stmt->bindParam(':ward_id', $ward_id);
        $stmt->execute();
        return $stmt->execute();
    }

    public function deleteStore($id) {
        $query = "DELETE FROM stores WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
}
?>