<?php
require_once "Database.php";

class ProductItemModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }


    public function getAllProductItems() {
        $query = "SELECT * FROM product_variants";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductItemById($id) {
        $query = "SELECT * FROM product_variants WHERE idVariant = :id"; ;
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function createProductItem($productId, $quantityProduct, $price,  $idColor, $idSize, $sku) {
        $query = "INSERT INTO product_variants (quantityProduct, price, idProduct, idColor, idSize, sku) VALUES (:quantityProduct, :price, :idProduct, :idColor, :idSize, :sku)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':quantityProduct', $quantityProduct);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':idProduct', $productId);
        $stmt->bindParam(':idColor', $idColor);
        $stmt->bindParam(':idSize', $idSize);
        $stmt->bindParam(':sku', $sku);
        return $stmt->execute();
    }

    public function updateProductItem($id, $quantityProduct, $price, $idProduct, $idColor, $idSize) {
        $query = "UPDATE product_variants SET quantityProduct = :quantityProduct, price = :price, idProduct = :idProduct, idColor = :idColor, idSize = :idSize WHERE idVariant = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':quantityProduct', $quantityProduct);
        $stmt->bindParam(':price', $price);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idColor', $idColor);
        $stmt->bindParam(':idSize', $idSize);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
    }
    }

    public function deleteProductItem($id) {
        $query = "DELETE FROM product_variants WHERE idVariant = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getProductItemByIdProduct($idProduct) {
        $query = "SELECT * FROM products prd
                    INNER JOIN product_variants pvra ON prd.id = pvra.idProduct
                    INNER JOIN colors cl ON pvra.idColor = cl.idColor
                    INNER JOIN sizes sz ON pvra.idSize = sz.idSize
         WHERE prd.id = :idProduct";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct , PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteProductItemByIdProduct($idProduct) {
        $query = "DELETE FROM product_variants WHERE idProduct = :idProduct";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        return $stmt->execute();
    }   
}
?>