<?php
require_once "Database.php";

class DiscountModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllDiscounts() {
        $query = "SELECT * FROM discounts";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getDiscountById($id) {
        $query = "SELECT * FROM discounts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createDiscount($nameDiscount, $description, $code, $discount_type, $discount_value, $min_order_value, $start_date, $end_date, $usage_limit) {
        $query = 'INSERT INTO discounts (nameDiscount, description, code, discount_type, discount_value, min_order_value, start_date, end_date, usage_limit) 
                  VALUES (:nameDiscount, :description, :code, :discount_type, :discount_value, :min_order_value, :start_date, :end_date, :usage_limit)';
        
        $stmt = $this->conn->prepare($query);
        
        $stmt->bindParam(':nameDiscount', $nameDiscount);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':code', $code);
        $stmt->bindParam(':discount_type', $discount_type);
        $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_INT);
        $stmt->bindParam(':min_order_value', $min_order_value, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':usage_limit', $usage_limit, PDO::PARAM_INT);
    
        $stmt->execute();
        
        return $stmt->rowCount();
    }
    
   public function updateDiscount($id, $nameDiscount, $description, $code, $discount_type, $discount_value, $min_order_value, $start_date, $end_date, $usage_limit, $status): bool {
        $query = 'UPDATE discounts SET 
                    nameDiscount = :nameDiscount,
                    description = :description,
                    code = :code,
                    discount_type = :discount_type,
                    discount_value = :discount_value,
                    min_order_value = :min_order_value,
                    start_date = :start_date,
                    end_date = :end_date,
                    usage_limit = :usage_limit,
                    status = :status
                  WHERE id = :id';
                  
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->bindParam(':nameDiscount', $nameDiscount, PDO::PARAM_STR);
        $stmt->bindParam(':description', $description, PDO::PARAM_STR);
        $stmt->bindParam(':code', $code, PDO::PARAM_STR);
        $stmt->bindParam(':discount_type', $discount_type, PDO::PARAM_STR);
        $stmt->bindParam(':discount_value', $discount_value, PDO::PARAM_INT);
        $stmt->bindParam(':min_order_value', $min_order_value, PDO::PARAM_INT);
        $stmt->bindParam(':start_date', $start_date, PDO::PARAM_STR);
        $stmt->bindParam(':end_date', $end_date, PDO::PARAM_STR);
        $stmt->bindParam(':usage_limit', $usage_limit, PDO::PARAM_INT);
        $stmt->bindParam(':status', $status, PDO::PARAM_STR);
        
        return $stmt->execute();
    }
    public function deleteDiscount($id) {
        $query = "DELETE FROM discounts WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getDiscountByCode($code) {
        $query = "SELECT * FROM discounts WHERE code = :code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
    public function applyDiscount() {
        $query = 'UPDATE discounts SET status = "used" WHERE code = :code';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);    
        return $stmt->execute();
        
    }
    public function getIdDiscountByCode($code) {
        $query = "SELECT id FROM discounts WHERE code = :code";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':code', $code);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateDiscountUsage($discount_id) {
        $query = "UPDATE discounts SET usage_limit = usage_limit - 1, used_count = used_count + 1 WHERE id = :discount_id";      
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':discount_id', $discount_id, PDO::PARAM_INT);
        return $stmt->execute(); 
    } 
}
?>