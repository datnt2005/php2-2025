<?php
require_once "Database.php";

class OrderItemModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllOrderItems() {
        $query = "SELECT * FROM order_items";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderItemByIdOrder($idOrder) {
        $query = "SELECT oi.*, prd.*, pvra.*, cl.*, sz.*,
         (SELECT PI.imagePath FROM pic_products PI WHERE PI.idProduct = prd.id ORDER BY PI.id ASC LIMIT 1) AS productImage
                  FROM order_items oi
                  INNER JOIN products prd ON oi.idProduct = prd.id
                  INNER JOIN product_variants pvra ON oi.idProductItem = pvra.idVariant
                  INNER JOIN colors cl ON pvra.idColor = cl.idColor
                  INNER JOIN sizes sz ON pvra.idSize = sz.idSize
                  WHERE oi.idOrder = :idOrder";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idOrder', $idOrder);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getOrderItemById($id) {
        $query = "SELECT * FROM order_items WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    
    public function createOrderItem($idOrder, $idProduct, $idProductItem, $quantity, $price ){
        $query = 'INSERT INTO order_items (idOrder, idProduct, idProductItem, quantity, price) VALUES (:idOrder, :idProduct, :idProductItem, :quantity, :price)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idOrder', $idOrder);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idProductItem', $idProductItem);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function updateOrderItem($id, $idOrder, $idProduct, $idProductItem, $quantity, $price) {
        $query = 'UPDATE order_items SET idOrder = :idOrder, idProduct = :idProduct, idProductItem = :idProductItem, quantity = :quantity, price = :price WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idOrder', $idOrder);
        $stmt->bindParam(':idOrder', $idProduct);
        $stmt->bindParam(':idProductItem', $idProductItem);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }


    public function deleteOrderItem($id) {
        $query = "DELETE FROM order_items WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();    
    }

}
?>