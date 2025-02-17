<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
require_once "model/OrderModel.php";
require_once "model/OrderItemModel.php";
require_once "model/ProductModel.php";
require_once "model/ProductItemModel.php";
require_once "model/CartModel.php";
require_once "model/CartItemModel.php";
require_once "view/helpers.php";

class OrderController {
    private $orderModel;
    private $orderItemModel;
    private $productModel;
    private $productItemModel;
    private $cartModel;
    private $cartItemModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
        $this->productItemModel = new ProductItemModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();
        
        $orderItems = $this->orderItemModel->getAllOrderItems();
    
        renderView("view/orders/order_list.php", compact('orders', 'orderItems'), "Order List");
    }

    public function showCheckout(){
        $idUser = $_SESSION['user']['id'];
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
    
        renderView("view/checkout.php", compact('carts', 'cartItems', 'totalQuantity', 'totalPrice', 'productPrices'), "Cart List");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $name = $_POST['name'];
            $phone = $_POST['phone'];
            $address = $_POST['address'];
            $noteOrder = $_POST['noteOrder'] ?? '';
            $payment = $_POST['payment'];
            $code = substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789'), 0, 8);
            $status = "pending";
            $idUser = $_SESSION['user']['id'];
            $email = $_SESSION['user']['email'];
            $idCart = $this->cartModel->getIdCartByIdUser($idUser);
    
            if (!empty($idCart)) {
                $cartItems = $this->cartItemModel->getCartItemByIdCart($idCart['id']);
            } else {
                $cartItems = [];
            }
    
            $totalQuantity = 0;
            $totalPrice = 30000;
    
           foreach ($cartItems as $cartItem) {
                    $totalQuantity += $cartItem['quantity'];
                    $totalPrice += $cartItem['price'] * $cartItem['quantity'];
                }
        

            if($payment == 'code'){
                $idOrder = $this->orderModel->createOrder($idUser, $status, $noteOrder, $payment, $totalPrice, $name, $phone, $address, $code);
                if (!empty($cartItems)) {
                    foreach ($cartItems as $cartItem) {
                        $this->orderItemModel->createOrderItem(
                            $idOrder,
                            $cartItem['idProduct'],
                            $cartItem['idProductItem'],
                            $cartItem['quantity'],
                            $cartItem['price']
                        );
                    }
                }
                // header('Location: /cart');
                // exit;
            }elseif($payment == 'vnpay'){
                $_SESSION['order_data'] = [
                    'idUser' => $idUser,
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'noteOrder' => $noteOrder,
                    'payment' => $payment,
                    'total_price' => $totalPrice,
                    'code' => $code
                ];
                header("Location: /order/vnpay_payment");
                exit;
            }
            $error = null;
            $success = null;
            $this->cartModel->clearCartByIdUser($idUser);
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'ntdad2005@gmail.com';
                $mail->Password = 'neoqrbrvqtuonfnv';
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                $mail->setFrom('ntdad2005@gmail.com', 'tdajtshop');
                $mail->addAddress($email);

                $mail->isHTML(isHtml: true);
                $mail->Subject = "Thank you for your order";
                $mail->Body = " <h2>Shop cám ơn bạn rất nhiều đã mua hàng của chúng tôi!</h2>
                                <p>Chúc bạn 8 3 8 6 bạn nhé. Khách hàng mãi đỉnh, mãi đỉnh luôn!</p>
                                <h3>Đây là đơn hàng của bạn:</h3>
                                <ul>
                                    <li><strong>Mã đơn hàng:</strong> $code</li>
                                    <li><strong>Tên khách hàng:</strong> $name</li>
                                    <li><strong>Số điện thoại:</strong> $phone</li>
                                    <li><strong>Địa chỉ:</strong> $address</li>
                                    <li><strong>Tổng Tiền:</strong> " . number_format($totalPrice, 0, ',', '.') . "₫</li>
                                </ul>
                ";

                $mail->send();
                $success = "Order created successfully.";
            } catch (Exception $e) {
                $error = "Failed to send email: {$mail->ErrorInfo}";
            }

            header('Location: /cart');
            exit;
        }
    }
    
    public function delete($id) {
        $this->orderModel->deleteOrder($id);
        header("Location: /order");
    }

public function showOrderItem($id) {
    $order = $this->orderModel->getOrderById($id);
    $orderItems = $this->orderItemModel->getOrderItemByIdOrder($id);
    
    renderView("view/orders/order_detail.php", compact('order', 'orderItems'), "Order Item List");
}

 public function statusUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];

            $this->orderModel->updateStatus($id, $status);
            header("Location: /order");
        } else {
            $order = $this->orderModel->getOrderById($id);
            renderView("view/orders/order_edit.php", compact('order'), "Edit Order");
        }
    
    }



    public function vnpay_payment() {
        require_once 'view/orders/config_vnpay.php';
        $vnpayConfig = include('view/orders/config_vnpay.php');
    
        if (!isset($_SESSION['order_data'])) {
            die("Không tìm thấy đơn hàng.");
        }
    
        $order = $_SESSION['order_data'];
        $vnp_TmnCode = $vnpayConfig['vnp_TmnCode'];
        $vnp_HashSecret = $vnpayConfig['vnp_HashSecret'];
        $vnp_Url = $vnpayConfig['vnp_Url'];
        $vnp_Returnurl = $vnpayConfig['vnp_Returnurl'];
    
        $vnp_TxnRef = $order['code']; // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng " . $order['code'];
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $order['total_price'] * 100; // VNPay nhận đơn vị VNĐ x 100
        $vnp_Locale = "vn";
        $vnp_BankCode = "";
        $vnp_IpAddr = $_SERVER['REMOTE_ADDR'];
    
        $inputData = array(
            "vnp_Version" => "2.1.0",
            "vnp_TmnCode" => $vnp_TmnCode,
            "vnp_Amount" => $vnp_Amount,
            "vnp_Command" => "pay",
            "vnp_CreateDate" => date('YmdHis'),
            "vnp_CurrCode" => "VND",
            "vnp_IpAddr" => $vnp_IpAddr,
            "vnp_Locale" => $vnp_Locale,
            "vnp_OrderInfo" => $vnp_OrderInfo,
            "vnp_OrderType" => $vnp_OrderType,
            "vnp_ReturnUrl" => $vnp_Returnurl,
            "vnp_TxnRef" => $vnp_TxnRef
        );
    
        ksort($inputData);
        $query = "";
        $i = 0;
        $hashdata = "";
        foreach ($inputData as $key => $value) {
            if ($i == 1) {
                $hashdata .= '&' . urlencode($key) . "=" . urlencode($value);
            } else {
                $hashdata .= urlencode($key) . "=" . urlencode($value);
                $i = 1;
            }
            $query .= urlencode($key) . "=" . urlencode($value) . '&';
        }
    
        $vnp_Url = $vnp_Url . "?" . $query;
        $vnpSecureHash = hash_hmac('sha512', $hashdata, $vnp_HashSecret);
        $vnp_Url .= 'vnp_SecureHash=' . $vnpSecureHash;
    
        header('Location: ' . $vnp_Url);
        exit;
    }
    

    public function vnpay_return() {
        require_once 'view/orders/config_vnpay.php';
        $vnpayConfig = include('view/orders/config_vnpay.php');
    
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . '=' . $value . '&';
        }
        $hashData = rtrim($hashData, '&');
    
        $secureHash = hash_hmac('sha512', $hashData, $vnpayConfig['vnp_HashSecret']);
        if ($secureHash == $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                echo "Thanh toán thành công!";
                // Xử lý cập nhật đơn hàng
            } else {
                echo "Thanh toán thất bại!";
            }
        } else {
            echo "Lỗi xác thực!";
        }
    }
    
}