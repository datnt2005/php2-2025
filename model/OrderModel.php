<?php
require_once "Database.php";

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllOrders() {
        $query = "SELECT * FROM orders";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderByIdUser($idUser){
        $query = "SELECT * FROM orders WHERE idUser = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        $result =  $stmt->fetch(PDO::FETCH_ASSOC);
        if(!$result){
            return false;
        }
            return $result;
    }

    public function getIdOrderByIdUser($idUser){
        $query = "SELECT id FROM orders WHERE idUser = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();   
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderById($id) {
        $query = "SELECT * FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createOrder($idUser, $status, $noteOrder, $payment, $totalPrice, $name, $phone, $address, $code){
        $query = 'INSERT INTO orders (idUser, status, noteOrder, payment, total_price, name, phone, address, code) VALUES (:idUser, :status, :noteOrder, :payment, :total_price, :name, :phone, :address, :code)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':noteOrder', $noteOrder); 
        $stmt->bindParam(':payment', $payment);
        $stmt->bindParam(':total_price', $totalPrice);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $this->conn->lastInsertId();
        }

    public function updateOrder($id, $status,  $noteOrder, $payment, $total_price, $name, $phone, $address, $code) {
        $query = 'UPDATE orders SET status = :status, noteOrder = :noteOrder, payment = :payment, total_price = :total_price, name = :name, phone = :phone, address = :address, code = :code WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':noteOrder', $noteOrder); 
        $stmt->bindParam(':payment', $payment);
        $stmt->bindParam(':total_price', $total_price);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':code', $code);
        if ($stmt->execute()) {
            return true;
        } else {
            return false;

    } 
    }

    public function deleteOrder($id) {
        $query = "DELETE FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    
    public function updateStatus($id, $status) {
        $query = 'UPDATE orders SET status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }
}
?>