<?php
require_once "Database.php";

class CartModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCarts() {
        $query = "SELECT * FROM carts";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCartsByUserId($idUser) {
        $query = "SELECT * FROM carts WHERE idUser = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdCartByIdUser($idUser){
        $query = "SELECT * FROM carts WHERE idUser = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCartById($id) {
        $query = "SELECT * FROM carts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createCart($idUser, $status) {
        $query = "INSERT INTO carts (idUser, status) VALUES (:idUser, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updateCart($id, $idUser, $status) {
        $query = 'UPDATE carts SET idUser = :idUser, status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function deleteCart($id) {
        $query = "DELETE FROM carts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getCartSummary(){
        $query = 'SELECT ci.*, prd.*, pvra.*, cl.*, sz.* FROM cart_items ci
        INNER JOIN products prd ON ci.idProduct = prd.id
        INNER JOIN product_variants pvra ON ci.idProductItem = pvra.idVariant
        INNER JOIN colors cl ON pvra.idColor = cl.idColor
        INNER JOIN sizes sz ON pvra.idSize = sz.idSize'; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearCartByIdUser( $idUser ) {
        $query = "DELETE FROM carts WHERE idUser = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        return $stmt->execute();
    }
}
?>