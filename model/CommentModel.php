<?php
require_once "Database.php";

class CommentModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }
    
    public function getAllComments() {
        $query = "SELECT 
        cmt.*, 
        prd.name AS nameProduct, 
        usr.name AS nameUser, 
        MAX(cl.user_id) AS liked_by_user, 
        MAX(cl.created_at) AS liked_at, 
        GROUP_CONCAT(cm.media_url ORDER BY cm.id SEPARATOR ', ') AS media_urls, 
        GROUP_CONCAT(cm.media_type ORDER BY cm.id SEPARATOR ', ') AS media_types, 
        (SELECT COUNT(*) FROM comment_likes WHERE comment_id = cmt.id) AS total_likes
    FROM comments cmt
    INNER JOIN products prd ON cmt.idProduct = prd.id
    INNER JOIN users usr ON cmt.idUser = usr.id
    LEFT JOIN comment_likes cl ON cmt.id = cl.comment_id
    LEFT JOIN comment_media cm ON cmt.id = cm.comment_id 
    GROUP BY cmt.id
    ORDER BY cmt.created_at DESC";
    
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentsByProductId($idProduct) {
        $query = "SELECT cmt.*, usr.username AS user_name, 
                         cl.user_id AS liked_by_user, cl.created_at AS liked_at, 
                         cm.media_url, cm.media_type
                  FROM comments cmt
                  INNER JOIN users usr ON cmt.idUser = usr.idUser
                  LEFT JOIN comment_likes cl ON cmt.id = cl.comment_id
                  LEFT JOIN comment_media cm ON cmt.id = cm.comment_id
                  WHERE cmt.idProduct = :idProduct";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentById($id) {
        $query = "SELECT cmt.*, 
                      prd.name AS nameProduct, 
                      usr.name AS nameUser, 
                      MAX(cl.user_id) AS liked_by_user, 
                      MAX(cl.created_at) AS liked_at, 
                      GROUP_CONCAT(cm.media_url ORDER BY cm.id SEPARATOR ', ') AS media_urls, 
                      GROUP_CONCAT(cm.media_type ORDER BY cm.id SEPARATOR ', ') AS media_types, 
                      (SELECT COUNT(*) FROM comment_likes WHERE comment_id = cmt.id) AS total_likes
                  FROM comments cmt
                  INNER JOIN products prd ON cmt.idProduct = prd.id
                  INNER JOIN users usr ON cmt.idUser = usr.id
                  LEFT JOIN comment_likes cl ON cmt.id = cl.comment_id
                  LEFT JOIN comment_media cm ON cmt.id = cm.comment_id 
                  WHERE cmt.id = :id 
                  GROUP BY cmt.id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function createComment($idProduct, $idUser, $content , $rating, $status) {
        $query = "INSERT INTO comments (idProduct, idUser, content, rating, status) 
                  VALUES (:idProduct, :idUser, :content, :rating, :status)";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':status', $status);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updateComment($id, $idProduct, $idUser, $content , $rating, $status) {
        $query = "UPDATE comments SET idProduct = :idProduct, idUser = :idUser, content = :content, rating = :rating, status = :status WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->bindParam(':idUser', $idUser);
        $stmt->bindParam(':content', $content);
        $stmt->bindParam(':rating', $rating);
        $stmt->bindParam(':status', $status);
        return $stmt->execute();
    }

    public function deleteComment($id) {
        $query = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }


    public function reportComment($id) {
        $query = "UPDATE comments SET status = 'reported' WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }
    public function getCommentByProduct($idProduct) {
        $query = "SELECT cmt.*, 
                      prd.name AS nameProduct, 
                      usr.name AS nameUser, 
                      usr.avatar AS avatarUser,
                      COUNT(cmt.id) AS total_comments,
                      MAX(cl.user_id) AS liked_by_user, 
                      MAX(cl.created_at) AS liked_at, 
                      GROUP_CONCAT(cm.media_url ORDER BY cm.id SEPARATOR ', ') AS media_urls, 
                      GROUP_CONCAT(cm.media_type ORDER BY cm.id SEPARATOR ', ') AS media_types, 
                      (SELECT COUNT(*) FROM comment_likes WHERE comment_id = cmt.id) AS total_likes
                  FROM comments cmt
                  INNER JOIN products prd ON cmt.idProduct = prd.id
                  INNER JOIN users usr ON cmt.idUser = usr.id
                  LEFT JOIN comment_likes cl ON cmt.id = cl.comment_id
                  LEFT JOIN comment_media cm ON cmt.id = cm.comment_id 
                  WHERE cmt.idProduct = :idProduct
                  GROUP BY cmt.id";
                  $stmt = $this->conn->prepare($query);
                  $stmt->bindParam(':idProduct', $idProduct);
                  $stmt->execute();
                  return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAverageRating($idProduct) {
        $query = "SELECT AVG(rating) AS average_rating FROM comments WHERE idProduct = :idProduct ";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':idProduct', $idProduct);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

   public function likeComment($id) {
        $query = "UPDATE comments SET likes = likes + 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function unlikeComment($id) {
        $query = "UPDATE comments SET likes = likes - 1 WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function getLikes($id) {
        $query = "SELECT likes FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>