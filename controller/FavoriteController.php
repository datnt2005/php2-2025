<?php

// use Google\Service\Adsense\Header;

require_once "model/FavoriteModel.php";
require_once "model/FavoriteItemModel.php";
require_once "model/ProductModel.php";

require_once "view/helpers.php";

class FavoriteController {
    private $favoriteModel;
    private $favoriteItemModel;
    private $productModel;
    public function __construct() {
        $this->favoriteModel = new FavoriteModel();
        $this->favoriteItemModel = new FavoriteItemModel();
        $this->productModel = new ProductModel();

    }

    public function index() {
        $idUser = $_SESSION['user']['id'] ;
        $favorites = $this->favoriteModel->getFavoriteByUserId($idUser) ;
        $favoriteProductIds = [];
        if (!empty($favorites)) {
            foreach ($favorites as $favorite) {
                $favoriteItems = $this->favoriteItemModel->getFavoriteItemByIdFavorite($favorite['id']);
                foreach ($favoriteItems as $item) {
                    $favoriteProductIds[] = $item['idProduct'];
                }
            }
        }else{
            $favoriteItems = [];
        }
        renderViewUser("view/user/favoriteProduct.php", compact('favorites', 'favoriteItems', 'favoriteProductIds'), "Favorite List");
    }
    public function create($idProduct) {
        if (!isset($_SESSION['user'])) {
            if ($this->isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Bạn cần đăng nhập để thêm sản phẩm vào yêu thích!']);
                header("Location: /login");
            } else {
                $_SESSION['error'] = "Bạn cần đăng nhập để thêm sản phẩm vào yêu thích!";
                header("Location: /products/$idProduct");
            }
            exit;
        }
    
        $idUser = $_SESSION['user']['id'];
        $favorites = $this->favoriteModel->getFavoriteByUserId($idUser);
        if (empty($favorites)) {
            $idFavorite = $this->favoriteModel->createFavorite($idUser);
        } else {
            $idFavorite = $favorites[0]['id'];
        }
    
        $favoriteItem = $this->favoriteItemModel->createFavoriteItem($idFavorite, $idProduct);
    
        if ($this->isAjaxRequest()) {
            echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được thêm vào yêu thích!']);
        } else {
            $_SESSION['success'] = "Sản phẩm đã được thêm vào yêu thích!";
            header("Location: /products/$idProduct");
        }
        exit;
    }
    
    private function isAjaxRequest() {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public function deleteFavorite($idProduct) {
      if (!isset($_SESSION['user'])) {
        if ($this->isAjaxRequest()) {
          echo json_encode(['success' => false, 'message' => 'Vui lòng đăng nhập để thực hiện thao tác này!']);
        } else {
          $_SESSION['error'] = "Vui lòng đăng nhập để thực hiện thao tác này!";
          header("Location: /favorite");
        }
        exit;
      }
      $this->favoriteItemModel->deleteFavoriteItem($idProduct);
      if ($this->isAjaxRequest()) {
        echo json_encode(['success' => true, 'message' => 'Sản phẩm đã được xóa khỏi yêu thích!']);
      } else {
        $_SESSION['success'] = "Sản phẩm đã được xóa khỏi yêu thích!";
        header("Location: /favorite");
      }
    }
}
    // public function updateFavoriteItem() {
    //     header("Content-Type: application/json");
    //     error_reporting(E_ALL);
    //     ini_set('display_errors', 1);
    
    //     // 🛠 Debug: In dữ liệu JSON nhận được
    //     $rawData = file_get_contents("php://input");
    //     file_put_contents("debug.log", "Raw Input: " . $rawData . "\n", FILE_APPEND);
    
    //     $data = json_decode($rawData, true);
    
    //     if (!$data) {
    //         echo json_encode([
    //             "status" => "error", 
    //             "message" => "Dữ liệu không hợp lệ", 
    //             "raw_input" => $rawData // Gửi luôn dữ liệu để debug
    //         ]);
    //         return;
    //     }
    
    //     $idCartItem = $data['idCartItem'] ?? null;
    //     $quantity = $data['quantity'] ?? null;
    
    //     if (!$idCartItem || !$quantity || $quantity < 1) {
    //         echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
    //         return;
    //     }
    
    //     $cartItem = $this->favoriteItemModel->getCartItemById($idCartItem);
    //     $idProductItem = $cartItem['idProductItem'];
    //     $productItem = $this->productItemModel->getProductItemById($idProductItem);
    //     if ($productItem['quantityProduct'] < $quantity) {
    //         echo json_encode(['status'=> 'error','message'=> 'Số lượng trong kho không đủ! Số lượng sản phẩm còn lại trong kho: '. $productItem['quantityProduct']]);
    //         return;
    //     }
    //     // Cập nhật giỏ hàng
    //     $updateStatus = $this->favoriteItemModel->updateQuantityCartItem($idCartItem, $quantity);
    
    //     if ($updateStatus) {
    //         $cartSummary = $this->favoriteModel->getCartSummary();
    //         echo json_encode([
    //             "status" => "success",
    //             "totalQuantity" => $cartSummary['totalQuantity'],
    //             "totalPrice" => number_format($cartSummary['totalPrice'], 0, ',', '.')
    //         ]);
    //     } else {
    //         echo json_encode(["status" => "error", "message" => "Cập nhật thất bại"]);
    //     }
    // }

    
