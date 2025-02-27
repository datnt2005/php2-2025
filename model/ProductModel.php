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
    public function getProductByIdCategory($idCategory) {
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
                  WHERE prd.category_id = :idCategory
                  GROUP BY prd.id";
        
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idCategory', $idCategory);
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

    public function relativeProduct($id) {
        $query = "SELECT p.*, 
                    (SELECT pp.imagePath FROM pic_products pp 
                     WHERE pp.idProduct = p.id 
                     ORDER BY pp.id ASC LIMIT 1) AS productImage
                     FROM products p
                     WHERE p.category_id = (SELECT category_id FROM products WHERE id = :id) 
                     AND p.id <> :id 
                     LIMIT 4;
        ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductByFilters($categoryIds = [], $minPrice = null, $maxPrice = null, $name = '', $sortBy = 'newest', $selectedColors = [], $selectedSizes = []) {
        $query = "SELECT 
                    prd.id AS productId, 
                    prd.name AS productName, 
                    prd.description AS productDescription, 
                    MIN(pvra.price) AS productPrice, 
                    prd.created_at AS productCreatedAt, 
                    prd.updated_at AS productUpdatedAt,
                    SUM(pvra.quantityProduct) AS totalQuantity,
                    pvra.sku AS productSku,
                    ctgr.name AS categoryName,
                    ctgr.id AS categoryId,
                    COALESCE(GROUP_CONCAT(DISTINCT sz.nameSize ORDER BY sz.nameSize ASC SEPARATOR ', '), '') AS sizeName,
                    COALESCE(GROUP_CONCAT(DISTINCT cl.nameColor ORDER BY cl.nameColor ASC SEPARATOR ', '), '') AS colorName,
                    (SELECT PI.imagePath FROM pic_products PI WHERE PI.idProduct = prd.id ORDER BY PI.id ASC LIMIT 1) AS productImage
                  FROM products prd
                  LEFT JOIN categories ctgr ON prd.category_id = ctgr.id
                  LEFT JOIN product_variants pvra ON prd.id = pvra.idProduct
                  LEFT JOIN sizes sz ON pvra.idSize = sz.idSize
                  LEFT JOIN colors cl ON pvra.idColor = cl.idColor
                  WHERE 1=1";
      
        // Mảng chứa giá trị bind
        $bindParams = [];
    
        // Lọc theo danh mục
        if (!empty($categoryIds)) {
            $placeholders = implode(',', array_fill(0, count($categoryIds), '?'));
            $query .= " AND prd.category_id IN ($placeholders)";
            $bindParams = array_merge($bindParams, $categoryIds);
        }
    
        // Lọc theo khoảng giá
        if ($minPrice !== null) {
            $query .= " AND pvra.price >= ?";
            $bindParams[] = $minPrice;
        }
        if ($maxPrice !== null) {
            $query .= " AND pvra.price <= ?";
            $bindParams[] = $maxPrice;
        }
    
        // Lọc theo tên sản phẩm
        if (!empty($name)) {
            $query .= " AND prd.name LIKE ?";
            $bindParams[] = "%$name%";
        }
    
        // Lọc theo màu sắc (chỉ khi có giá trị)
        if (!empty($selectedColors)) {
            $placeholders = implode(',', array_fill(0, count($selectedColors), '?'));
            $query .= " AND pvra.idColor IN ($placeholders)";
            $bindParams = array_merge($bindParams, $selectedColors);
        }
    
        // Lọc theo kích thước (chỉ khi có giá trị)
        if (!empty($selectedSizes)) {
            $placeholders = implode(',', array_fill(0, count($selectedSizes), '?'));
            $query .= " AND pvra.idSize IN ($placeholders)";
            $bindParams = array_merge($bindParams, $selectedSizes);
        }
    
        // Nhóm theo sản phẩm để tránh dữ liệu lặp
        $query .= " GROUP BY prd.id";
    
        // Sắp xếp kết quả
        switch ($sortBy) {
            case 'price_asc':
                $query .= " ORDER BY productPrice ASC";
                break;
            case 'price_desc':
                $query .= " ORDER BY productPrice DESC";
                break;
            case 'name_asc':
                $query .= " ORDER BY prd.name ASC";
                break;
            case 'name_desc':
                $query .= " ORDER BY prd.name DESC";
                break;
            default:
                $query .= " ORDER BY prd.created_at DESC";
                break;
        }
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute($bindParams);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }    
    public function getProductNames() {
        $query = "SELECT name FROM products";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_COLUMN);
    }
}


?>