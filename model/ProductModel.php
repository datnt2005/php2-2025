<?php
require_once "Database.php";

class ProductModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getAllProducts() {
        $query = "SELECT 
                    prd.id AS productId, 
                    prd.name AS productName, 
                    prd.description AS productDescription, 
                    MIN(pvra.price) AS productPrice, -- Giá thấp nhất
                    prd.created_at AS productCreatedAt, 
                    prd.updated_at AS productUpdatedAt,
                    SUM(pvra.quantityProduct) AS totalQuantity, -- Tổng số lượng tất cả biến thể
                    pvra.sku AS productSku, -- SKU của biến thể (có thể lấy 1 SKU đầu tiên)
                    ctgr.name AS categoryName,
                    GROUP_CONCAT(DISTINCT sz.nameSize ORDER BY sz.nameSize ASC) AS sizeName, -- Danh sách kích thước
                    GROUP_CONCAT(DISTINCT cl.nameColor ORDER BY cl.nameColor ASC) AS colorName, -- Danh sách màu
                    (SELECT PI.imagePath 
                     FROM pic_products PI 
                     WHERE PI.idProduct = prd.id 
                     ORDER BY PI.id ASC LIMIT 1) AS productImage -- Hình ảnh mặc định
                  FROM products prd
                  LEFT JOIN categories ctgr ON prd.category_id = ctgr.id
                  LEFT JOIN product_variants pvra ON prd.id = pvra.idProduct
                  LEFT JOIN sizes sz ON pvra.idSize = sz.idSize
                  LEFT JOIN colors cl ON pvra.idColor = cl.idColor
                  GROUP BY prd.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    

    public function getProductById($id) {
        $query = "SELECT 
                    prd.id AS productId, 
                    prd.name AS productName, 
                    prd.description AS productDescription, 
                    MIN(pvra.price) AS productPrice, -- Giá thấp nhất
                    prd.created_at AS productCreatedAt, 
                    prd.updated_at AS productUpdatedAt,
                    SUM(pvra.quantityProduct) AS totalQuantity, -- Tổng số lượng tất cả biến thể
                    pvra.sku AS productSku, -- SKU của biến thể (có thể lấy 1 SKU đầu tiên)
                    ctgr.name AS categoryName,
                    ctgr.id AS categoryId,
                    GROUP_CONCAT(DISTINCT sz.nameSize ORDER BY sz.nameSize ASC) AS sizeName, -- Danh sách kích thước
                    GROUP_CONCAT(DISTINCT cl.nameColor ORDER BY cl.nameColor ASC) AS colorName, -- Danh sách màu
                    (SELECT PI.imagePath 
                     FROM pic_products PI 
                     WHERE PI.idProduct = prd.id 
                     ORDER BY PI.id ASC LIMIT 1) AS productImage -- Hình ảnh mặc định
                  FROM products prd
                  LEFT JOIN categories ctgr ON prd.category_id = ctgr.id
                  LEFT JOIN product_variants pvra ON prd.id = pvra.idProduct
                  LEFT JOIN sizes sz ON pvra.idSize = sz.idSize
                  LEFT JOIN colors cl ON pvra.idColor = cl.idColor
                  WHERE prd.id = :id
                  GROUP BY prd.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createProduct($name, $description, $category_id) {
        $query = "INSERT INTO products (name, category_id, description) VALUES (:name, :category_id, :description)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    
    public function updateProduct($id, $name, $description, $category_id) {
        $query = "UPDATE products SET name = :name, category_id = :category_id, description = :description WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':category_id', $category_id);
        $stmt->bindParam(':description', $description);
        return $stmt->execute();
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function relateProduct($idCategory){
        $query = "SELECT * FROM products prd 
                 LEFT JOIN categories ctgr ON prd.category_id = ctgr.id
                 LEFT JOIN product_variants pvra ON prd.id = pvra.idProduct
                 LEFT JOIN sizes sz ON pvra.idSize = sz.idSize
                 LEFT JOIN colors cl ON pvra.idColor = cl.idColor
                 LEFT JOIN pic_products pp ON prd.id = pp.idProduct
                 WHERE category_id = :idCategory
                 GROUP BY prd.id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCategory', $idCategory);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }


}


?>