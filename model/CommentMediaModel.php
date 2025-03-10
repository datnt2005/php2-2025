<?php
require_once "Database.php";

class CommentMediaModel {
    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function getAllCommentMedia() {
        $query = "SELECT * FROM comment_media";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getCommentMediaById($id) {
        $query = "SELECT * FROM comment_media WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getCommentMediaByCommentId($commentId) {
        $query = "SELECT * FROM comment_media WHERE comment_id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function createCommentMedia($commentId, $mediaUrl, $mediaType) {
        $query = "INSERT INTO comment_media (comment_id, media_url, media_type, created_at) VALUES (:comment_id, :media_url, :media_type, NOW())";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        $stmt->bindParam(':media_url', $mediaUrl);
        $stmt->bindParam(':media_type', $mediaType);
        $stmt->execute();
        return $this->conn->lastInsertId();
    }

    public function updateCommentMedia($id, $mediaUrl, $mediaType) {
        $query = "UPDATE comment_media SET media_url = :media_url, media_type = :media_type, updated_at = NOW() WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':media_url', $mediaUrl);
        $stmt->bindParam(':media_type', $mediaType);
        return $stmt->execute();
    }

    public function deleteCommentMedia($id) {
        $query = "DELETE FROM comment_media WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    }

    public function deleteCommentMediaByCommentId($commentId) {
        $query = "DELETE FROM comment_media WHERE comment_id = :comment_id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':comment_id', $commentId);
        return $stmt->execute();
    }
}
?>