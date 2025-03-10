<?php
require_once "Database.php";

class OrderModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllOrders() {
        $query = "SELECT * FROM orders ORDER BY created_at DESC";
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
    public function getAllOrderByIdUser($idUser){  
      $query = 'SELECT * FROM orders WHERE idUser = :idUser ORDER BY created_at DESC';
      $stmt = $this->conn->prepare($query);
      $stmt->bindParam(':idUser', $idUser);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    public function getIdOrderByIdUser($idUser){
        $query = "SELECT id FROM orders WHERE idUser = :idUser ";
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

    public function createOrder($idUser, $status, $noteOrder, $payment, $totalPrice, $name, $phone, $address, $code, $discount_id, $discount_value, $final_amount){
        $query = 'INSERT INTO orders (idUser, status, noteOrder, payment, total_price, name, phone, address, code, discount_id, discount_value, final_amount) VALUES (:idUser, :status, :noteOrder, :payment, :total_price, :name, :phone, :address, :code, :discount_id, :discount_value, :final_amount)';
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
        $stmt->bindParam(':discount_id', $discount_id);
        $stmt->bindParam(':discount_value', $discount_value);
        $stmt->bindParam(':final_amount', $final_amount);
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

    public function getStatusById($id) {
        $query = "SELECT status FROM orders WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getOrderByCode($code) {
        $query = "SELECT * FROM orders WHERE code = :code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function cancelOrder($id) {
        $query = 'UPDATE orders SET status = "cancelled" WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }

    public function getOrderComplete() {
        $query = 'SELECT * FROM orders WHERE status = "completed" ORDER BY created_at DESC';
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
 public function getTotalRevenue() {
    $query = "SELECT SUM(total_price) AS total_revenue FROM orders WHERE status = 'completed' OR status = 'pending'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_COLUMN);
}

public function getTotalRevenueSuccess() {
    $query = "SELECT SUM(final_amount) AS total_revenue FROM orders WHERE status = 'completed'";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_COLUMN);
}

public function getTotalOrder() {
    $query = "SELECT COUNT(id) AS total_orders FROM orders";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_COLUMN);
}

public function getOrderStatusCount() {
    $query = "SELECT status, COUNT(*) as count FROM orders GROUP BY status ORDER BY count DESC";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    
    $statusCounts = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Định nghĩa tên trạng thái (tuỳ vào hệ thống của đại ca)
    $statusLabels = [
        'pending' => 'Chờ xử lý',
        'completed' => 'Hoàn thành',
        'cancelled' => 'Đã huỷ'
    ];

    // Chuẩn hoá dữ liệu trả về
    foreach ($statusCounts as &$row) {
        $row['status'] = $statusLabels[$row['status']] ?? $row['status']; 
    }

    return $statusCounts;
}


public function getOrderDates() {
    $query = "SELECT DISTINCT DATE(created_at) as order_date FROM orders";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
}

public function getDailyRevenues() {
    $query = "SELECT DATE(created_at) as order_date, SUM(final_amount) as revenue FROM orders GROUP BY order_date";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

public function getMonthlyRevenues() {
    $query = "SELECT DATE_FORMAT(created_at, '%Y-%m') as month, SUM(final_amount) as revenue FROM orders GROUP BY month";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_KEY_PAIR);
}

public function getMonths() {
    $query = "SELECT DISTINCT DATE_FORMAT(created_at, '%Y-%m') as month FROM orders";
    $stmt = $this->conn->prepare($query);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_COLUMN);
    
}
    
public function checkPurchased($idProduct, $idUser) {
    $query = "SELECT * FROM orders ord
             JOIN order_items od ON ord.id = od.idOrder
             WHERE od.idProduct = :idProduct AND ord.idUser = :idUser";
    $stmt = $this->conn->prepare($query);
    $stmt->bindParam(':idProduct', $idProduct);
    $stmt->bindParam(':idUser', $idUser);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    return $result; 
}
}
?>