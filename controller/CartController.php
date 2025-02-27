<?php

use Google\Service\Adsense\Header;

require_once "model/CartModel.php";
require_once "model/CartItemModel.php";
require_once "model/ProductModel.php";
require_once "model/ProductItemModel.php";
require_once "model/SizeModel.php";
require_once "model/ColorModel.php";

require_once "view/helpers.php";

class CartController {
    private $cartModel;
    private $cartItemModel;
    private $productModel;
    private $productItemModel;
    private $sizeModel;
    private $colorModel;
    public function __construct() {
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->productModel = new ProductModel();
        $this->productItemModel = new ProductItemModel();
        $this->sizeModel = new SizeModel();
        $this->colorModel = new ColorModel();
    }

    // public function index() {
    //     $idUser = $_SESSION['user']['id'] ?? null;
    //     $cartItems = [];
    //     $totalQuantity = 0;
    //     $totalPrice = 0;

    //     if ($idUser) {
    //         $idCart = $this->cartModel->getIdCartByIdUser($idUser);
    //         if ($idCart) {
    //             $cartItems = $this->cartItemModel->getCartItemByIdCart($idCart['id']);
    //         }
    //     } else {
    //         $cartItems = $_SESSION['cart'] ?? [];
    //     }

    //     foreach ($cartItems as &$cartItem) {
    //         $product = $this->productModel->getProductById($cartItem['idProduct']);
    //         $cartItem['productName'] = $product['name'] ?? 'Unknown';
    //         $cartItem['productImage'] = $product['image'] ?? 'default.jpg';
    //         $totalQuantity += $cartItem['quantity'];
    //         $totalPrice += $cartItem['price'] * $cartItem['quantity'];
    //     }
    //     foreach ($cartItems as &$cartItem) {
    //         $product = $this->productModel->getProductById($cartItem['idProduct']);
    //         $productItem = $this->productItemModel->getProductItemById($cartItem['idProductItem']);
    //         $color = $this ->colorModel->getColorById($productItem['idColor']);
    //         $size = $this ->sizeModel->getSizeById($productItem['idSize']);
    //         $cartItem['idCartItem'] = $cartItem['id'] ?? 0;
    //         $cartItem['name'] = $product['productName'] ?? 'Unknown';
    //         $cartItem['nameSize'] = $size['nameSize'] ?? 'Unknown';
    //         $cartItem['nameColor'] = $color['nameColor'] ?? 'Unknown';
    //         $cartItem['productImage'] = $product['productImage'] ?? 'default.jpg';
    //         $cartItem['price'] = $product['productPrice'] ?? 0;
    //         $cartItem['quantity'] = $cartItem['quantity'] ?? 0;
    //         $totalQuantity += $cartItem['quantity'];
    //         $totalPrice += $cartItem['price'] * $cartItem['quantity'];
    //     }

    //     renderViewUser("view/user/cart.php", compact('cartItems', 'totalQuantity', 'totalPrice'), "Cart List");
    // }
    public function index() {
        $idUser = $_SESSION['user']['id'] ?? null;
        $carts = $this->cartModel->getCartsByUserId($idUser);
        $idCart = $this->cartModel->getIdCartByIdUser($idUser);

        if(!empty($idCart)) {
            $cartItems = $this->cartItemModel->getCartItemByIdCart($idCart['id']);
        } else {
            $cartItems = [];
        }
        
        $totalQuantity = 0;
        $totalPrice = 0;
        $productPrices = [];
    
        foreach ($cartItems as $cartItem) {
            $totalQuantity += $cartItem['quantity'];
            $productPrice = $this->productModel->getProductById($cartItem['idProduct']);
            $totalPrice += $cartItem['price'] * $cartItem['quantity'];
        }
        if(empty($idUser)){
            $cartItems = $_SESSION['cart'] ?? [];

        }
        renderViewUser("view/user/cart.php", compact('carts', 'cartItems', 'totalQuantity', 'totalPrice', 'productPrices'), "Cart List");
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $idProduct = $_POST['idProduct'];
            $idSize = $_POST['selectSize'];
            $idColor = $_POST['selectColor'];
            $quantity = $_POST['quantity'];
            $idProductItem = $_POST['idProductItem'];
            $sku = $_POST['sku'];
            $price = $_POST['price'];
    
            if (!$idProduct || !$idSize || !$idColor || !$idProductItem || !$sku || !$quantity || !$price) {
                echo "Dữ liệu không hợp lệ!";
                echo "$idProduct, $idSize, $idColor, $idProductItem, $sku, $quantity , $price";
                header("Location: /products/$idProduct");
                return;            }
            
            $productItem = $this->productItemModel->getProductItemById($idProductItem);
            if ($productItem['quantityProduct'] < $quantity) {
                echo "Số lượng trong kho không đủ!";
                header("Location: /products/$idProduct");
                return;
            }
            // Kiểm tra xem người dùng có đăng nhập không
            // if (!isset($_SESSION['user'])) {
            //     $cartItem = [
            //         'idProduct' => $idProduct,
            //         'idSize' => $idSize,
            //         'idColor' => $idColor,
            //         'quantity' => $quantity,
            //         'idProductItem' => $idProductItem,
            //         'sku' => $sku,
            //         'price' => $price
            //     ];

            //     $_SESSION['cart'][] = $cartItem;
            //     echo "Sản phẩm đã được thêm vào giỏ hàng!";
            //     return;
            // }
            if(!isset($_SESSION['user'])) {
                $_SESSION['error'] = "Bạn cần đăng nhập để mua hàng!";
                header("Location: /products/$idProduct");
                exit;
            }
    
            $idUser = $_SESSION['user']['id'];
            $status = 1;
            $carts = $this->cartModel->getCartsByUserId($idUser);
            if (empty($carts)) {
                $idCart = $this->cartModel->createCart($idUser, $status);
            } else {
                $idCart = $carts[0]['id'];
            }
            
            $cartItem = $this ->cartItemModel->getCartItemByProductAndCart($idProduct,$idCart, $idProductItem);
            if (empty($cartItem)) {
                $this->cartItemModel->createCartItem($idCart, $idProduct, $idProductItem, $sku, $quantity, $price );
            }else{
                $cartItemId = $cartItem['idCartItem'];
                $quantityOld = $cartItem['quantity'];
                $quantityUpdate = $quantityOld + $quantity;
                $this->cartItemModel->updateQuantityCartItem($cartItemId, $quantityUpdate);
            }
            $_SESSION['success'] = "Sản phẩm đã được thêm vào giỏ hàng!";
            header("Location: /products/$idProduct");
            exit();

        }
    }

    public function deleteCartItem($idCartItem) {
        $this->cartItemModel->deleteCartItem($idCartItem);
        header("Location: /cart");
        exit();
    }
    public function updateCartItem() {
        header("Content-Type: application/json");
        error_reporting(E_ALL);
        ini_set('display_errors', 1);
    
        // 🛠 Debug: In dữ liệu JSON nhận được
        $rawData = file_get_contents("php://input");
        file_put_contents("debug.log", "Raw Input: " . $rawData . "\n", FILE_APPEND);
    
        $data = json_decode($rawData, true);
    
        if (!$data) {
            echo json_encode([
                "status" => "error", 
                "message" => "Dữ liệu không hợp lệ", 
                "raw_input" => $rawData // Gửi luôn dữ liệu để debug
            ]);
            return;
        }
    
        $idCartItem = $data['idCartItem'] ?? null;
        $quantity = $data['quantity'] ?? null;
    
        if (!$idCartItem || !$quantity || $quantity < 1) {
            echo json_encode(["status" => "error", "message" => "Dữ liệu không hợp lệ"]);
            return;
        }
    
        $cartItem = $this->cartItemModel->getCartItemById($idCartItem);
        $idProductItem = $cartItem['idProductItem'];
        $productItem = $this->productItemModel->getProductItemById($idProductItem);
        if ($productItem['quantityProduct'] < $quantity) {
            echo json_encode(['status'=> 'error','message'=> 'Số lượng trong kho không đủ! Số lượng sản phẩm còn lại trong kho: '. $productItem['quantityProduct']]);
            return;
        }
        // Cập nhật giỏ hàng
        $updateStatus = $this->cartItemModel->updateQuantityCartItem($idCartItem, $quantity);
    
        if ($updateStatus) {
            $cartSummary = $this->cartModel->getCartSummary();
            echo json_encode([
                "status" => "success",
                "totalQuantity" => $cartSummary['totalQuantity'],
                "totalPrice" => number_format($cartSummary['totalPrice'], 0, ',', '.')
            ]);
        } else {
            echo json_encode(["status" => "error", "message" => "Cập nhật thất bại"]);
        }
    }

    
}