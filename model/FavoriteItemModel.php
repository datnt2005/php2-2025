<?php
require_once "Database.php";

class FavoriteItemModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllFavoriteItems() {
        $query = "SELECT * FROM favorite_items";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavoriteItemByIdFavorite($idFavorite) {
        $query = "SELECT fi.*,  
                   prd.id AS productId, 
                    prd.name AS productName, 
                    prd.description AS productDescription, 
                    MIN(pvra.price) AS productPrice, -- Giá thấp nhất
                    prd.created_at AS productCreatedAt, 
                    prd.updated_at AS productUpdatedAt,
                    SUM(pvra.quantityProduct) AS totalQuantity, -- Tổng số lượng tất cả biến thể
                    pvra.sku AS productSku, -- SKU của biến thể (có thể lấy 1 SKU đầu tiên)
                    GROUP_CONCAT(DISTINCT sz.nameSize ORDER BY sz.nameSize ASC) AS sizeName, -- Danh sách kích thước
                    GROUP_CONCAT(DISTINCT cl.nameColor ORDER BY cl.nameColor ASC) AS colorName, -- Danh sách màu
                    (SELECT PI.imagePath 
                     FROM pic_products PI 
                     WHERE PI.idProduct = prd.id 
                     ORDER BY PI.id ASC LIMIT 1) AS productImage -- Hình ảnh mặc định
                  FROM favorite_items fi
                  INNER JOIN products prd ON fi.idProduct = prd.id
                  INNER JOIN product_variants pvra ON prd.id = pvra.idProduct
                  INNER JOIN sizes sz ON pvra.idSize = sz.idSize
                  INNER JOIN colors cl ON pvra.idColor = cl.idColor
                  WHERE fi.idFavorite = :idFavorite GROUP BY fi.idFavoriteItem";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idFavorite', $idFavorite);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    public function getFavoriteItemById($idFavoriteItem) {
        $query = "SELECT * FROM favorite_items WHERE idFavoriteItem = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $idFavoriteItem);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createFavoriteItem($idFavorite, $idProduct){
        $query = 'INSERT INTO favorite_items (idFavorite, idProduct) VALUES (:idFavorite, :idProduct)';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idFavorite', $idFavorite);
        $stmt->bindParam(':idProduct', $idProduct);
        if ($stmt->execute()) {
            return $this->conn->lastInsertId();
        } else {
            return false;
        }
    }

    public function updateFavoriteItem($idFavoriteItem, $idFavorite, $idProduct) {
        $query = 'UPDATE favorite_items SET idFavorite = :idFavorite, idProduct = :idProduct  WHERE idFavoriteItem = :idFavoriteItem';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idFavoriteItem', $idFavoriteItem);
        $stmt->bindParam(':idFavorite', $idFavorite);
        $stmt->bindParam(':idProduct', $idProduct);
        return $stmt->execute();
    }


    public function deleteFavoriteItem($idProduct) {
        $query = "DELETE FROM favorite_items WHERE idProduct = :idProduct ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        return $stmt->execute();    
    }

    public function getFavoriteItemByProductAndFavorite($idProduct, $idFavorite) {
        $query = "SELECT * FROM cart_items WHERE idProduct = :idProduct AND idFavorite = :idFavorite ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idFavorite', $idFavorite);
        $stmt->execute();
        return $stmt-> fetch(PDO::FETCH_ASSOC);
    }

    public function checkFavorited( $idUser, $idProduct) {
        $query = "SELECT * FROM favorite_items fi
                INNER JOIN products prd ON fi.idProduct = prd.id
                INNER JOIN favorites fv ON fi.idFavorite = fv.idFavorite    
                WHERE fv.idUser = :idUser  AND fi.idProduct = :idProduct";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>