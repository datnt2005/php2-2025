<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require_once 'vendor/autoload.php';
require_once "model/OrderModel.php";
require_once "model/OrderItemModel.php";
require_once "model/ProductModel.php";
require_once "model/ProductItemModel.php";
require_once "model/CartModel.php";
require_once "model/CartItemModel.php";
require_once "model/DiscountModel.php";
require_once "view/helpers.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

class OrderController {
    private $orderModel;
    private $orderItemModel;
    private $productModel;
    private $productItemModel;
    private $cartModel;
    private $cartItemModel;
    private $discountModel;
    
    public function __construct() {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->productModel = new ProductModel();
        $this->productItemModel = new ProductItemModel();
        $this->cartModel = new CartModel();
        $this->cartItemModel = new CartItemModel();
        $this->discountModel = new DiscountModel();
    }

    public function index() {
        $orders = $this->orderModel->getAllOrders();
        
        $orderItems = $this->orderItemModel->getAllOrderItems();
    
        renderViewAdmin("view/admin/orders/order_list.php", compact('orders', 'orderItems'), "Order List");
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
    
        renderViewUser("view/user/checkout.php", compact('carts', 'cartItems', 'totalQuantity', 'totalPrice', 'productPrices'), "Cart List");
    }


    public function checkDiscount() {
        if ($_SERVER["REQUEST_METHOD"] !== "POST") {
            echo json_encode(["status" => "error", "message" => "Phương thức không hợp lệ"]);
            exit;
        }
    
        header("Content-Type: application/json");
        $code = trim($_POST['code'] ?? '');
    
        if (empty($code)) {
            echo json_encode(["status" => "error", "message" => "Vui lòng nhập mã giảm giá!"]);
            exit;
        }
    
        $discount = $this->discountModel->getDiscountByCode($code);
    
        if (!$discount) {
            echo json_encode(["status" => "error", "message" => "Mã giảm giá không tìm thấy"]);
            exit;
        }
    
        if ($discount['status'] != 1 || strtotime($discount['end_date']) < time()) {
            echo json_encode(["status" => "error", "message" => "Mã giảm giá không hợp lệ hoặc đã hết hạn"]);
            exit;
        }
    
        if (!is_null($discount['usage_limit']) && $discount['used_count'] >= $discount['usage_limit']) {
            echo json_encode(["status" => "error", "message" => "Mã giảm giá đã hết lượt sử dụng"]);
            exit;
        }
    
        if (!isset($_SESSION['user']['id'])) {
            echo json_encode(["status" => "error", "message" => "Bạn cần đăng nhập để sử dụng mã giảm giá"]);
            exit;
        }
    
        $idUser = $_SESSION['user']['id'];
        $idCart = $this->cartModel->getIdCartByIdUser($idUser);
        $cartItems = !empty($idCart) ? $this->cartItemModel->getCartItemByIdCart($idCart['id']) : [];
        $totalPrice = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
    
        if (!is_null($discount['min_order_value']) && $totalPrice < $discount['min_order_value']) {
            echo json_encode(["status" => "error", "message" => "Đơn hàng chưa đủ giá trị để sử dụng mã giảm giá này"]);
            exit;
        }
        if($discount['discount_type'] === 'percent') {
        $discountAmount = $totalPrice * $discount['discount_value'] / 100;
        } elseif($discount['discount_type'] === 'fixed') {
            $discountAmount = $discount['discount_value'];
        } elseif($discount['discount_type'] === 'free_shipping') {
            $discountAmount = 0;
        }
        $finalAmount = max($totalPrice - $discountAmount, 0);

        $appliedDiscount = [
            'discount_id'=> $discount['id'],
            'discount_amount'=> $finalAmount,
            'discount_value'=> $discountAmount,
            'discount_type'=> $discount['discount_type'],
            'code'=> $code,
        ];
        $_SESSION['discount'] = $appliedDiscount;
    
        echo json_encode([
            "status" => "success", 
            "message" => "Mã giảm giá đã được áp dụng!", 
            'discount_amount'=> $finalAmount,
            'discount_value'=> $discountAmount,
            'code'=> $code,
        ]);
        
        exit;
    }
    
    public function cancelDiscount() {
        unset($_SESSION['discount']);
        $idUser = $_SESSION['user']['id'];
        $idCart = $this->cartModel->getIdCartByIdUser($idUser);
        $cartItems = !empty($idCart) ? $this->cartItemModel->getCartItemByIdCart($idCart['id']) : [];
        $totalPrice = array_reduce($cartItems, function ($sum, $item) {
            return $sum + ($item['price'] * $item['quantity']);
        }, 0);
        echo json_encode(["status" => "success", "message" => "Mã giảm giá đã được hủy!", "originalTotal" => $totalPrice]);
        header("Location: /checkout");
        exit;
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
    
            $cartItems = !empty($idCart) ? $this->cartItemModel->getCartItemByIdCart($idCart['id']) : [];
            $totalQuantity = 0;
            $totalPrice = 30000; 
    
            foreach ($cartItems as $cartItem) {
                $totalQuantity += $cartItem['quantity'];
                $totalPrice += $cartItem['price'] * $cartItem['quantity'];
            }
            if(!empty($_SESSION['discount'])) {
                $discount_id = $_SESSION['discount']['discount_id'];
                $discount_value = $_SESSION['discount']['discount_value'];
                $final_amount = $_SESSION['discount']['discount_amount'] ;
            } else {
                $discount_id = null;
                $discount_value = null;
                $final_amount = $totalPrice;
            }
            if ($payment == 'cod') {
                $idOrder = $this->orderModel->createOrder($idUser, $status, $noteOrder, $payment, $totalPrice, $name, $phone, $address, $code, $discount_id, $discount_value, $final_amount);
                
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
    
                $this->cartModel->clearCartByIdUser($idUser);
    
                if ($this->sendOrderEmail($email, $name, $phone, $address, $code, $totalPrice)) {
                    $_SESSION['success'] = "Đơn hàng đã được tạo thành công. Vui lòng kiểm tra email!";
                } else {
                    $_SESSION['error'] = "Đơn hàng đã tạo nhưng không thể gửi email.";
                }
                $this->discountModel->updateDiscountUsage($discount_id);
                unset($_SESSION['discount']);
                header('Location: /cart');
                exit;
            } elseif ($payment == 'vnpay') {

                $_SESSION['order_data'] = [
                    'idUser' => $idUser,
                    'name' => $name,
                    'phone' => $phone,
                    'address' => $address,
                    'noteOrder' => $noteOrder,
                    'payment' => $payment,
                    'total_price' => $totalPrice,
                    'code' => $code,
                    'discount_id' => $discount_id,
                    'discount_value' => $discount_value,
                    'final_amount'=> $final_amount
                ];
                header("Location: /payment/vnpay_payment");
                exit;
            }
        }
    }
    
    private function sendOrderEmail($email, $name, $phone, $address, $code, $totalPrice) {
        $mail = new PHPMailer(true);
    
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV["SMTP_HOST"];
            $mail->SMTPAuth = $_ENV["SMTP_AUTH"];
            $mail->Username = $_ENV["SMTP_USERNAME"]; 
            $mail->Password = $_ENV["SMTP_PASSWORD"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Cấu hình người gửi và người nhận
            $mail->setFrom($_ENV["SMTP_USERNAME"], 'tdajtshop');
            $mail->addAddress($email);
    
            // Nội dung email
            $mail->isHTML(true);
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
            return true;
        } catch (Exception $e) {
            error_log("Lỗi gửi email: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function delete($id) {
        $this->orderModel->deleteOrder($id);
        header("Location: /order");
    }

    public function showOrderItem($id) {
        $order = $this->orderModel->getOrderById($id);
        $orderItems = $this->orderItemModel->getOrderItemByIdOrder($id);
        
        renderViewAdmin("view/admin/orders/order_detail.php", compact('order', 'orderItems'), "Order Item List");
    }

    public function statusUpdate($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $status = $_POST['status'];
            $currentStatus = $this->orderModel->getStatusById($id);

            if($status === 'completed' && $currentStatus['status'] !== 'completed') {
               $orderItems = $this->orderItemModel->getOrderItemByIdOrder($id);
               foreach ($orderItems as $orderItem) {
                $this->productItemModel->decrementProductQuantity($orderItem['idProductItem'], $orderItem['quantity']);
               }
            }

            $this->orderModel->updateStatus($id, $status);
            $this-> sendMailChangeStatus($status, $id, $_SESSION['user']['name'], $_SESSION['user']['email'], $_SESSION['user']['phone'] , 0);
            header("Location: /order");

        } else {    
            $order = $this->orderModel->getOrderById($id);
            renderViewAdmin("view/admin/orders/order_edit.php", compact('order'), "Edit Order");
        }
    }

    public function vnpay_payment() {
    
        if (!isset($_SESSION['order_data'])) {
            die("Không tìm thấy đơn hàng.");
        }
    
        $order = $_SESSION['order_data'];
        $vnp_TmnCode = $_ENV['VNP_TMN_CODE'];
        $vnp_HashSecret = $_ENV['VNP_HASH_SECRET'];
        $vnp_Url = $_ENV['VNP_URL'];
        $vnp_Returnurl = $_ENV['VNP_RETURN_URL'];
    
        $vnp_TxnRef = $order['code']; // Mã đơn hàng
        $vnp_OrderInfo = "Thanh toán đơn hàng " . $order['code'];
        $vnp_OrderType = "billpayment";
        $vnp_Amount = $order['final_amount'] * 100; // VNPay nhận đơn vị VNĐ x 100
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
        
        $vnp_SecureHash = $_GET['vnp_SecureHash'];
        $inputData = array();
        foreach ($_GET as $key => $value) {
            if (substr($key, 0, 4) == "vnp_") {
                $inputData[$key] = $value;
            }
        }
        unset($inputData['vnp_SecureHash']);
        ksort($inputData);
    
        // Ensure proper encoding
        $hashData = "";
        foreach ($inputData as $key => $value) {
            $hashData .= $key . '=' . urlencode($value) . '&';  // Use urlencode to encode values
        }
        $hashData = rtrim($hashData, '&');  // Remove last '&'
    
        // Generate secure hash
        $secureHash = hash_hmac('sha512', $hashData, $_ENV['VNP_HASH_SECRET']);
    
        if ($secureHash === $vnp_SecureHash) {
            if ($_GET['vnp_ResponseCode'] == '00') {
                $code = $_GET['vnp_TxnRef'];  // Mã đơn hàng
                $total_price = $_GET['vnp_Amount'] / 100;
                $status = 'completed';
    
                // Retrieve order data from session
                $order = $_SESSION['order_data'];
                $idUser = $order['idUser'];
                $name = $order['name'];
                $phone = $order['phone'];
                $address = $order['address'];
                $noteOrder = $order['noteOrder'];
                $payment = $order['payment'];
                $email = $_SESSION['user']['email'];
                if(!empty($_SESSION['discount'])) {
                    $discount_id = $_SESSION['discount']['id'];
                    $discount_value = $_SESSION['discount']['discount_value'];
                    $final_amount = $_SESSION['discount']['discount_amount'];
                } else {
                    $discount_id = null;
                    $discount_value = null;
                    $final_amount = $total_price;
                }
                // Create order in the database
                $idOrder = $this->orderModel->createOrder($idUser, $status, $noteOrder, $payment, $total_price, $name, $phone, $address, $code, $discount_id, $discount_value, $final_amount);
    
                // Retrieve cart items
                $idCart = $this->cartModel->getIdCartByIdUser($idUser);
                $cartItems = !empty($idCart) ? $this->cartItemModel->getCartItemByIdCart($idCart['id']) : [];
    
                // Create order items in the database
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
    
                // Clear the cart
                $this->cartModel->clearCartByIdUser($idUser);
    
                // Send order confirmation email
                $this->sendOrderEmail($email, $name, $phone, $address, $code, $total_price);
                $this->discountModel->updateDiscountUsage($discount_id);
                unset($_SESSION['discount']);
                // Redirect to order success page
                $_SESSION['success'] = "Thanh toán thành công. Đơn hàng đã được tạo.";
                header('Location: /cart');
                exit;
            } else {
                echo "Thanh toán thất bại!";
            }
        } else {
            echo "Lỗi xác thực!";
        }
    }
    
    public function getOrdersBuyed() {
        $idUser = $_SESSION['user']['id'];
        $orders = $this->orderModel->getAllOrderByIdUser($idUser);
        renderViewUser("view/user/order_buyed.php", compact('orders' ), "Orders Buyed");
    }
    
    public function getOrderItemsBuyed($idOrder) {
        $orders = $this->orderModel->getOrderById($idOrder);
        $orderItems = $this->orderItemModel->getOrderItemByIdOrder($idOrder);
        renderViewUser("view/user/order_detail_buyed.php", compact('orders' , 'orderItems' ), "Orders Buyed");
    }

    public function trackOrder(){
        if($_SERVER['REQUEST_METHOD'] === 'POST'){
            $code = $_POST['order_code'];

            $orders = $this->orderModel->getOrderByCode($code);
            if($orders){
                $idOrder = $orders['id'];
                $this->getOrderItemsBuyed($idOrder);
            } else {
                $_SESSION['error'] = 'Không tìm thấy đơn hàng';
                header('Location: /myOrder');
                exit;
            }
        }else{
          $_SESSION['error'] = 'Vui lòng nhập mã đơn hàng';
        }
    }

    public function cancelOrder($id){
        $this->orderModel->cancelOrder($id);
        $_SESSION['success'] = 'Đơn hàng đã bị huỷ';
        $this -> sendMailChangeStatus('cancelled', $id, $_SESSION['user']['name'], $_SESSION['user']['email'], $_SESSION['user']['phone'], 0);
        header('Location: /myOrder');
        exit;
    }

    private function sendMailChangeStatus($status, $code, $name, $email, $phone, $totalPrice) {
        $mail = new PHPMailer(true);
    
        try {
            // Cấu hình SMTP
            $mail->isSMTP();
            $mail->Host = $_ENV["SMTP_HOST"];
            $mail->SMTPAuth = $_ENV["SMTP_AUTH"];
            $mail->Username = $_ENV["SMTP_USERNAME"];
            $mail->Password = $_ENV["SMTP_PASSWORD"];
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
    
            // Cấu hình người gửi và người nhận
            $mail->setFrom( $_ENV["SMTP_USERNAME"], 'TDAJT Shop');
            $mail->addAddress($email, $name);
    
            // Xác định nội dung email dựa trên trạng thái đơn hàng
            switch ($status) {
                case 'pending':
                    $statusMessage = "⏳ Đơn hàng của bạn đang chờ xử lý. Chúng tôi sẽ sớm xác nhận!";
                    break;
                case 'processing':
                    $statusMessage = "🚀 Đơn hàng của bạn đang được chuẩn bị. Chúng tôi sẽ giao hàng trong thời gian sớm nhất!";
                    break;
                case 'shipped':
                    $statusMessage = "📦 Đơn hàng của bạn đã được giao cho đơn vị vận chuyển. Hãy chuẩn bị nhận hàng!";
                    break;
                case 'delivered':
                    $statusMessage = "✅ Đơn hàng của bạn đã được giao thành công. Cảm ơn bạn đã ủng hộ!";
                    break;
                case 'cancelled':
                    $statusMessage = "❌ Đơn hàng của bạn đã bị hủy. Nếu có bất kỳ thắc mắc nào, hãy liên hệ ngay với chúng tôi!";
                    break;
                case "completed":
                    $statusMessage = "✅ Đơn hàng của bạn đã hoàn thành. Cảm ơn bạn đã ủng hộ!";
                    break;
                default:
                    $statusMessage = "🔄 Đơn hàng của bạn đã được cập nhật trạng thái!";
                    break;
            }
    
            // Nội dung email
            $mail->isHTML(true);
            $mail->Subject = "Cập nhật trạng thái đơn hàng!";
            $mail->Body = "
                <div style='font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4;'>
                    <div style='max-width: 600px; margin: auto; background: white; padding: 20px; border-radius: 10px; box-shadow: 0px 4px 10px rgba(0,0,0,0.1);'>
                        <h2 style='color: #2d89ef;'>TDAJT Shop xin chào, $name! 👋</h2>
                        <p style='font-size: 16px;'>Chúng tôi muốn thông báo rằng đơn hàng của bạn đã có sự thay đổi về trạng thái:</p>
                        <h3 style='color: #ff9900;'>🔔 $statusMessage</h3>
                        <h4>📦 Chi tiết đơn hàng:</h4>
                        <ul>
                            <li><strong>Mã đơn hàng:</strong> <span style='color: #2d89ef;'>$code</span></li>
                            <li><strong>Tên khách hàng:</strong> $name</li>
                            <li><strong>Số điện thoại:</strong> $phone</li>
                            <li><strong>Địa chỉ giao hàng:</strong> </li>
                            <li><strong>Tổng tiền:</strong> <span style='color: #28a745; font-weight: bold;'>" . number_format($totalPrice, 0, ',', '.') . "₫</span></li>
                        </ul>
                        <p style='font-size: 14px; color: #555;'>Nếu bạn có bất kỳ câu hỏi nào, đừng ngần ngại liên hệ với đội ngũ hỗ trợ của chúng tôi!</p>
                        <p style='text-align: center;'><a href='http://localhost:8000/' style='background-color: #2d89ef; color: white; padding: 10px 20px; border-radius: 5px; text-decoration: none;'>Truy cập cửa hàng</a></p>
                        <p style='text-align: center; font-size: 12px; color: #777;'>Cảm ơn bạn đã tin tưởng và mua sắm tại TDAJT Shop! 💙</p>
                    </div>
                </div>
            ";
    
            $mail->send();
            return true;
        } catch (Exception $e) {
            error_log("Lỗi gửi email: " . $mail->ErrorInfo);
            return false;
        }
    }

    public function buyAgain($idOrder) {
        if (!isset($_SESSION['user']['id'])) {
            $_SESSION['error'] = "Bạn cần đăng nhập để mua lại.";
            header("Location: /login");
            exit;
        }
    
        $idUser = $_SESSION['user']['id'];
        $status = 1;
        $idCart = $this->cartModel->getIdCartByIdUser($idUser);
        
        if (empty($idCart)) {
            $idCart = $this->cartModel->createCart($idUser, $status);
        } else {
            $idCart = $idCart['id'];
        }
    
        $orderItems = $this->orderItemModel->getOrderItemByIdOrder($idOrder);
    
        if (empty($orderItems)) {
            $_SESSION['error'] = "Không tìm thấy sản phẩm trong đơn hàng.";
            header("Location: /order");
            exit;
        }
    
        foreach ($orderItems as $orderItem) {
            $product = $this->productModel->getProductById($orderItem['idProduct']);
    
            if ($product) {
                // Kiểm tra xem sản phẩm còn hàng không
                $stock = $this->productItemModel->getProductStock($orderItem['idProductItem']);
                if ($stock < $orderItem['quantity']) {
                    $_SESSION['error'] = "Sản phẩm {$product['name']} không đủ hàng.";
                    header("Location: /myOrder");
                    exit;
                }
    
                // Thêm sản phẩm vào giỏ hàng
                $this->cartItemModel->createCartItem($idCart, $orderItem['idProduct'], $orderItem['idProductItem'], $orderItem['sku'], $orderItem['quantity'], $orderItem['price']);
            }
        }
    
        $_SESSION['success'] = "Sản phẩm đã được thêm vào giỏ hàng!";
        header("Location: /checkout");
        exit;
    }

        public function revenue() {
            $stockData = $this->productItemModel->getStockCounts();

            $productNames = array_column($stockData, 'product_name');
            $stockCounts = array_column($stockData, 'stock_count');

            $statusData = $this->orderModel->getOrderStatusCount();

            $statusLabels = array_column($statusData, 'status');
            $statusCounts = array_column($statusData, 'count');

            $bestSellingData = $this->orderItemModel->getBestSellingProducts();

            $bestSellingNames = array_column($bestSellingData, 'name');
            $bestSellingCounts = array_column($bestSellingData, 'sold_count');
            $data = [
                'totalRevenue' => $this->orderModel->getTotalRevenue(),
                'totalRevenueSuccess' => $this->orderModel->getTotalRevenueSuccess(),
                'totalOrders' => $this->orderModel->getTotalOrder(),
                'totalSoldProducts' => $this->orderItemModel->getTotalSoldProducts(),
                'totalStock' => $this->productItemModel->getTotalStock(),
                'productNames' => $productNames,
                'stockCounts' => $stockCounts,
                'orderDates' => $this->orderModel->getOrderDates(),
                'dailyRevenues' => $this->orderModel->getDailyRevenues(),
                'monthlyRevenues' => $this->orderModel->getMonthlyRevenues(),
                'months' => $this->orderModel->getMonths(),
                'orderStatusCount' => $this->orderModel->getOrderStatusCount(),
                'bestSellingProducts' => $this->orderItemModel->getBestSellingProducts(),
                'statusLabels' => $statusLabels,
                'statusCounts' => $statusCounts,
                'bestSellingNames' => $bestSellingNames,
                'bestSellingCounts' => $bestSellingCounts,
            ];
    
            renderViewAdmin("view/admin/dashboard.php", $data);
    }
}