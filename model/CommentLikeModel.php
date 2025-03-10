<?php
require_once "Database.php";

class CommentLikeModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCommentLikes() {
        $query = "SELECT * FROM comment_likes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentLikeById($id) {
        $query = "SELECT * FROM comment_likes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCommentLikesByCommentId($commentId) {
        $query = "SELECT * FROM comment_likes WHERE comment_id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentLikesByUserId($userId) {
        $query = "SELECT * FROM comment_likes WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCommentLike($commentId, $userId) {
        $query = "INSERT INTO comment_likes (comment_id, user_id, created_at) VALUES (:comment_id, :user_id, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function deleteCommentLike($id) {
        $query = "DELETE FROM comment_likes WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteCommentLikeByCommentId($commentId) {
        $query = "DELETE FROM comment_likes WHERE comment_id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        return $stmt->execute();
    }

    public function deleteCommentLikeByUserId($userId) {
        $query = "DELETE FROM comment_likes WHERE user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':user_id', $userId);
        return $stmt->execute();
    }

    public function hasUserLiked($commentId, $userId) {
        $query = "SELECT * FROM comment_likes WHERE comment_id = :comment_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
        return $stmt->rowCount() > 0;
    }

    public function likeComment($commentId, $userId) {
        $query = "INSERT INTO comment_likes (comment_id, user_id, created_at) VALUES (:comment_id, :user_id, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    public function unlikeComment($commentId, $userId) {
        $query = "DELETE FROM comment_likes WHERE comment_id = :comment_id AND user_id = :user_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->bindParam(':user_id', $userId);
        $stmt->execute();
    }

    public function countLikes($commentId) {
        $query = "SELECT COUNT(*) FROM comment_likes WHERE comment_id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->execute();
        return $stmt->fetchColumn();
    }
}
?>