<?php
require_once "Database.php";

class CartItemModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCartItems() {
        $query = "SELECT * FROM cart_items";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartItemByIdCart($idCart) {
        $query = "SELECT ci.*, prd.*, pvra.*, cl.*, sz.*, 
                  (SELECT PI.imagePath FROM pic_products PI WHERE PI.idProduct = prd.id ORDER BY PI.id ASC LIMIT 1) AS productImage
                  FROM cart_items ci
                  INNER JOIN products prd ON ci.idProduct = prd.id
                  INNER JOIN product_variants pvra ON ci.idProductItem = pvra.idVariant
                  INNER JOIN colors cl ON pvra.idColor = cl.idColor
                  INNER JOIN sizes sz ON pvra.idSize = sz.idSize
                  WHERE ci.idCart = :idCart";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCart', $idCart);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getCartItemById($idCartItem) {
        $query = "SELECT * FROM cart_items WHERE idCartItem = :idCartItem";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCartItem', $idCartItem);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCartItem($idCart, $idProduct, $idProductItem, $sku, $quantity, $price ){
        $query = 'INSERT INTO cart_items (idCart, idProduct, idProductItem, sku, quantity, price) VALUES (:idCart, :idProduct, :idProductItem, :sku, :quantity, :price)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCart', $idCart);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idProductItem', $idProductItem);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function updateCartItem($idCartItem, $idCart, $idProduct, $idProductItem, $sku, $quantity, $price) {
        $query = 'UPDATE cart_items SET idCart = :idCart, idProduct = :idProduct, idProductItem = :idProductItem, sku = :sku, quantity = :quantity, price = :price WHERE idCartItem = :idCartItem';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCartItem', $idCartItem);
        $stmt->bindParam(':idCart', $idCart);
        $stmt->bindParam(':idCart', $idProduct);
        $stmt->bindParam(':idProductItem', $idProductItem);
        $stmt->bindParam(':sku', $sku);
        $stmt->bindParam(':quantity', $quantity);
        $stmt->bindParam(':price', $price);
        return $stmt->execute();
    }


    public function deleteCartItem($idCartItem) {
        $query = "DELETE FROM cart_items WHERE idCartItem = :idCartItem";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCartItem', $idCartItem);
        return $stmt->execute();    
    }

    public function getCartItemByProductAndCart($idProduct, $idCart, $idProductItem) {
        $query = "SELECT * FROM cart_items WHERE idProduct = :idProduct AND idCart = :idCart AND idProductItem = :idProductItem";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idCart', $idCart);
        $stmt->bindParam(':idProductItem', $idProductItem);
        $stmt->execute();
        return $stmt-> fetch(PDO::FETCH_ASSOC);
    }
    
    public function updateQuantityCartItem($cartItemId, $quantityUpdate) {
        $query = 'UPDATE cart_items SET quantity = :quantity WHERE idCartItem = :idCartItem';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCartItem', $cartItemId);
        $stmt->bindParam(':quantity', $quantityUpdate);
        return $stmt->execute();
    }


}
?>