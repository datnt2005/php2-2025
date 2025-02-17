<?php
require_once "Database.php";

class PicProductModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllPicProducts() {
        $query = "SELECT * FROM pic_products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }  


    public function getPicProductById($id) {
        $query = "SELECT * FROM pic_products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createPicProduct($productId, $imagePath) {
        $query = "INSERT INTO pic_products (idProduct, imagePath) VALUES (:idProduct, :imagePath)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $productId);
        $stmt->bindParam(':imagePath', $imagePath);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    
    public function updatePicProduct($id, $productId, $imagePath) {
        $query = "UPDATE pic_products SET idProduct = :idProduct, imagePath = :imagePath WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idProduct', $productId);
        $stmt->bindParam(':imagePath', $imagePath);
        return $stmt->execute();
    }

    public function deletePicProduct($id) {
        $query = "DELETE FROM pic_products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getPicProductByIdProduct($productId) {
        $query = "SELECT * FROM pic_products WHERE idProduct = :idProduct";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $productId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function deletePicProductByIdProduct($productId) {
        $query = "DELETE FROM pic_products WHERE idProduct = :idProduct";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $productId);
        return $stmt->execute();
    }
}
?>