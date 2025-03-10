<?php
require_once "model/CommentModel.php";
require_once "model/CommentLikeModel.php";
require_once "model/CommentMediaModel.php";
require_once "model/ProductModel.php";
require_once "model/UserModel.php";
require_once "model/OrderModel.php";
require_once "model/OrderItemModel.php";

require_once "view/helpers.php";

class CommentController {
    private $commentModel;
    private $commentLikeModel;
    private $commentMediaModel;
    private $productModel;
    private $userModel;
    private $orderModel;
    private $orderItemModel;
    public function __construct() {
        $this->commentModel = new CommentModel();
        $this->commentLikeModel = new CommentLikeModel();
        $this->commentMediaModel = new CommentMediaModel();
        $this->productModel = new ProductModel();
        $this->userModel = new UserModel();
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function index() {
        $comments = $this->commentModel->getAllComments();
        renderViewAdmin("view/admin/comments/comment_list.php", compact('comments'), "Comment List");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduct = $_POST['product'];
            $idUser = $_POST['user'];
            $content = $_POST['content'];
            $rating = $_POST['rating'];
            $status = $_POST['status'];
            $image = $_FILES['image'];
    
            $commentId = $this->commentModel->createComment($idProduct, $idUser, $content, $rating, $status);
    
            if (!empty($image['tmp_name'][0])) {
                foreach ($image['tmp_name'] as $index => $tmpName) {
                    $mediaPath = "uploads/" . $image['name'][$index];
                    move_uploaded_file($tmpName, $mediaPath);
    
                    $mimeType = mime_content_type($mediaPath);
                    
                    if (strpos($mimeType, 'image') !== false) {
                        $mediaType = 'image';
                    } elseif (strpos($mimeType, 'video') !== false) {
                        $mediaType = 'video';
                    } else {
                        $mediaType = 'other';
                    }
                    $this->commentMediaModel->createCommentMedia($commentId, $mediaPath, $mediaType);
                }
            }
    
            header("Location: /comments");
            exit();
        } else {
            $products = $this->productModel->getAllProducts();
            $users = $this->userModel->getAllUsers();
            renderViewAdmin("view/admin/comments/comment_create.php", compact('products', 'users'), "Create Comment");
        }
    }

    public function delete($idcomment) {
        $this->commentModel->deleteComment($idcomment);
        header("Location: /comments");
        exit();
    }
    public function removeComment($idcomment, $idProduct) {
        $this->commentModel->deleteComment($idcomment);
        $_SESSION["success"] = "Bình luận đã bị xóa";
        header("Location: /products/$idProduct");
        exit();
    }
    
    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduct = $_POST['product'];
            $idUser = $_POST['user'];
            $content = $_POST['content'];
            $rating = $_POST['rating'];
            $status = $_POST['status'];
            $image = $_FILES['image'];

            $this->commentModel->updateComment($id, $idProduct, $idUser, $content , $rating, $status);
            $oldMedia = $this->commentMediaModel->getCommentMediaByCommentId($id);
            if (!empty($image['tmp_name'][0])) {
                foreach ($oldMedia as $media) {
                    if (file_exists($media['path'])) {
                        unlink($media['path']); 
                    }
                }
                $this->commentMediaModel->deleteCommentMediaByCommentId($id);

                //lưu ảnh
                foreach ($image['tmp_name'] as $index => $tmpName) {
                    $mediaPath = "uploads/" . $image['name'][$index];
                    move_uploaded_file($tmpName, $mediaPath);
    
                    $mimeType = mime_content_type($mediaPath);
                    
                    if (strpos($mimeType, 'image') !== false) {
                        $mediaType = 'image';
                    } elseif (strpos($mimeType, 'video') !== false) {
                        $mediaType = 'video';
                    } else {
                        $mediaType = 'other';
                    }
                    $this->commentMediaModel->createCommentMedia($id, $mediaPath, $mediaType);
                }
            }
            header("Location: /comments");
            exit();
        }else {
            $comment = $this->commentModel->getCommentById($id);
            $products = $this->productModel->getAllProducts();
            $users = $this->userModel->getAllUsers();
            $mediaComments = $this->commentMediaModel->getCommentMediaByCommentId($id);
            renderViewAdmin("view/admin/comments/comment_edit.php", compact('comment','products', 'users', 'mediaComments'), "Create Comment");
        }
    }
    
    public function deletePicComment($idComment, $idCommentMedia) {
        $this->commentMediaModel->deleteCommentMedia($idCommentMedia);
        header("Location: /comments/$idComment");
        exit();
    }
    
    public function addCommentUser($idProduct){
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUser = $_SESSION['user']['id'];
            $content = $_POST['content'];
            $rating = $_POST['rating'];
            $status = "visible";        
            $image = $_FILES['images']??[];
            if(!isset($idUser)){
                header("Location: /login");
                exit();
            }
            $commentId = $this->commentModel->createComment($idProduct, $idUser, $content, $rating, $status);
            if ($commentId) {
                if (!empty($image['tmp_name'][0])) {
                    foreach ($image['tmp_name'] as $index => $tmpName) {
                        $mediaPath = "uploads/" . $image['name'][$index];
                        move_uploaded_file($tmpName, $mediaPath);
    
                        $mimeType = mime_content_type($mediaPath);
                        
                        if (strpos($mimeType, 'image') !== false) {
                            $mediaType = 'image';
                        } elseif (strpos($mimeType, 'video') !== false) {
                            $mediaType = 'video';
                        } else {
                            $mediaType = 'other';
                        }
                        $this->commentMediaModel->createCommentMedia($commentId, $mediaPath, $mediaType);
                    }
                }
            }
            header("Location: /products/$idProduct");
            exit();
        }
    }

    public function getCommentByProduct($idProduct){
        $comments = $this ->commentModel->getCommentByProduct($idProduct);
        renderViewUser("view/user/comment/list.php", compact('comments'), "Comment List");
    }

    public function updateCommentUser(){ 
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduct = $_POST['idProduct'];
            $id = $_POST['commentId'];
            $idUser = $_SESSION['user']['id'];
            $content = $_POST['content'];
            $rating = $_POST['update-rating'];
            $status = "visible";
            $image = $_FILES['images'] ?? [];

            $this->commentModel->updateComment($id, $idProduct, $idUser, $content , $rating, $status);
            $oldMedia = $this->commentMediaModel->getCommentMediaByCommentId($id);
            if (!empty($image['tmp_name'][0])) {
                foreach ($oldMedia as $media) {
                    if (file_exists($media['path'])) {
                        unlink($media['path']); 
                    }
                }
                $this->commentMediaModel->deleteCommentMediaByCommentId($id);

                //lưu ảnh
                foreach ($image['tmp_name'] as $index => $tmpName) {
                    $mediaPath = "uploads/" . $image['name'][$index];
                    move_uploaded_file($tmpName, $mediaPath);
    
                    $mimeType = mime_content_type($mediaPath);
                    
                    if (strpos($mimeType, 'image') !== false) {
                        $mediaType = 'image';
                    } elseif (strpos($mimeType, 'video') !== false) {
                        $mediaType = 'video';
                    } else {
                        $mediaType = 'other';
                    }
                    $this->commentMediaModel->createCommentMedia($id, $mediaPath, $mediaType);
                }
            }
            $_SESSION["success"] = "Bình luận của bạn đã được cập nhật";
            header("Location: /products/$idProduct");
            exit();
        }  else
        {
            $_SESSION['error'] = 'Cập nhật bình luận thất bại';
        }    
    }
    public function toggleLikeComment() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idUser = $_SESSION['user']['id'] ?? null;
            $data = json_decode(file_get_contents("php://input"), true);
            $idComment = $data['commentId'] ?? null;
    
            if (!$idUser) {
                echo json_encode(["success" => false, "message" => "Vui lòng đăng nhập để thích bình luận"]);
                http_response_code(401);
                exit();
            }
    
            if (!$idComment) {
                echo json_encode(["success" => false, "message" => "ID bình luận không hợp lệ"]);
                http_response_code(400);
                exit();
            }
    
            $liked = $this->commentLikeModel->hasUserLiked($idComment, $idUser);
            if ($liked) {
                $this->commentLikeModel->unlikeComment($idComment, $idUser);
                $this->commentModel->unlikeComment($idComment);
                $liked = false;
            } else {
                $this->commentLikeModel->likeComment($idComment, $idUser);
                $this->commentModel->likeComment($idComment);
                $liked = true;
            }
    
            $likeCount = $this->commentLikeModel->countLikes($idComment);
            echo json_encode(["success" => true, "likes" => $likeCount, "liked" => $liked]);
            exit();
        }
        
    }

    public function getLikeCount($commentId) {
        header('Content-Type: application/json');
        try {
            $likeCount = $this->commentLikeModel->countLikes($commentId);
            echo json_encode(["success" => true, "likes" => $likeCount]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        exit();
    }

    public function checkLike($commentId) {
        header('Content-Type: application/json');
        try {
            $liked = $this->commentLikeModel->hasUserLiked($commentId, $_SESSION['user']['id']);
            echo json_encode(["success" => true, "liked" => $liked]);
        } catch (PDOException $e) {
            echo json_encode(["success" => false, "message" => $e->getMessage()]);
        }
        exit();
    }
}
?>