<?php
require_once "Database.php";

class FavoriteModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllFavorites() {
        $query = "SELECT * FROM favorites";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getFavoriteByUserId($idUser) {
        $query = "SELECT * FROM favorites WHERE user_id = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getIdFavoriteByIdUser($idUser){
        $query = "SELECT * FROM favorites WHERE user_id = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getFavoriteById($id) {
        $query = "SELECT * FROM favorites WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createFavorite($idUser) {
        $query = "INSERT INTO favorites (user_id)VALUES (:idUser)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updateFavorite($id, $idUser) {
        $query = 'UPDATE favorites SET user_id = :idUser, status = :status WHERE id = :id';
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idUser', $idUser);
        return $stmt->execute();
    }

    public function deleteFavorite($id) {
        $query = "DELETE FROM favorites WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getFavoriteSummary(){
        $query = 'SELECT fi.*, prd.*, pvra.*, cl.*, sz.* FROM favorite_items fi
        INNER JOIN products prd ON ci.idProduct = prd.id
        INNER JOIN product_variants pvra ON ci.idProductItem = pvra.idVariant
        INNER JOIN colors cl ON pvra.idColor = cl.idColor
        INNER JOIN sizes sz ON pvra.idSize = sz.idSize'; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function clearFavoriteByIdUser( $idUser ) {
        $query = "DELETE FROM favorites WHERE user_id = :idUser";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idUser', $idUser);
        return $stmt->execute();
    }

    
}
?>