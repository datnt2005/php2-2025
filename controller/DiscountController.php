<?php
require_once "model/DiscountModel.php";
require_once "view/helpers.php";

class DiscountController {
    private $discountModel;

    public function __construct() {
        $this->discountModel = new discountModel();
    }

    public function index() {
        $discounts = $this->discountModel->getAllDiscounts();
        //compact: gom bien dien thanh array
        renderViewAdmin("view/admin/discounts/discount_list.php", compact('discounts'), "discount List");
    }


    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameDiscount = trim($_POST['nameDiscount']);
            $description = trim($_POST['description']);
            $code = trim($_POST['code']);
            $discount_type = trim($_POST['discount_type']);
            $discount_value = trim($_POST['discount_value']);
            $min_order_value = trim($_POST['min_order_value']);
            $start_date = trim($_POST['start_date']);
            $end_date = trim($_POST['end_date']);
            $usage_limit = trim($_POST['usage_limit'] ) ;
    
            if (empty($nameDiscount)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [
                    'error' => 'discount name is required!'
                ], "Create discount");
            }elseif (empty($description)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [
                    'error' => 'description is required!'
                ], "Create discount");
            }elseif (empty($code)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [
                    'error' => 'code is required!'
                ], "Create discount");
            }elseif (empty($discount_type)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [    
                    'error' => 'discount type is required!' 
                    ], 'Create discount');
            }elseif (empty($discount_value)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [
                    'error' => 'discount value is required!'
                ], "Create discount");
            }elseif (empty($start_date)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [
                    'error' => 'start date is required!'
                ], "Create discount");
            }elseif (empty($end_date)) {
                renderViewAdmin("view/admin/discounts/discount_create.php", [
                    'error' => 'end date is required!'
                ], "Create discount");
            }else {
                $this->discountModel->createDiscount($nameDiscount, $description, $code, $discount_type, $discount_value, $min_order_value, $start_date, $end_date, $usage_limit );
                $_SESSION["success"] = "Thêm mã giảm giá thành công!";
                header("Location: /discounts");
            }
        } else {
            renderViewAdmin("view/admin/discounts/discount_create.php", [], "Create discount");
        }
    }
    

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
          $nameDiscount = trim($_POST['nameDiscount']);
          $description = trim($_POST['description']);
          $code = trim($_POST['code']);
          $discount_type = trim($_POST['discount_type']);
          $discount_value = trim($_POST['discount_value']);
          $min_order_value = trim($_POST['min_order_value']);
          $start_date = trim($_POST['start_date']);
          $end_date = trim($_POST['end_date']);
          $usage_limit = trim($_POST['usage_limit']);
          $status = trim($_POST['status']);

            $this->discountModel->updateDiscount($id, $nameDiscount,$description, $code, $discount_type, $discount_value, $min_order_value, $start_date, $end_date, $usage_limit, $status );
            header("Location: /discounts");
        } else {
            $discount = $this->discountModel->getDiscountById($id);
            renderViewAdmin("view/admin/discounts/discount_edit.php", compact('discount'), "Edit discount");
        }
    }

    public function delete($id) {
        $this->discountModel->deleteDiscount($id);
        echo"<script>
        confirm('Bạn có chắc chắn muốn xóa không?')
        if(confirm){
            alert('Delete discount successfully!')
                    window.location.href='/discounts'
        }else{
            alert('Delete discount fail!')
                    window.location.href='/discounts'
        }
        </script>";
        // header("Location: /discounts");
    }

    public function checkDiscount() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $code = $_POST['code'] ?? '';
            
            if (empty($code)) {
                $_SESSION['message_discount'] = 'Vui lòng nhập mã giảm giá!';
            }
    
            $discount = $this->discountModel->getDiscountByCode($code);
            
            if ($discount) {
                $discountId = $discount['id'];
                $discountType = $discount['discount_type'];
                $discountValue = $discount['discount_value'];
                $minOrderValue = $discount['min_order_value'];
                $startDate = $discount['start_date'];
                $endDate = $discount['end_date'];
                $usageLimit = $discount['usage_limit'];
                $usedCount = $discount['used_count'];
                $status = $discount['status'];
    
                if ($status != 1) {
                    $_SESSION['message_discount'] = 'Mã giảm giá không còn hoạt động';
                }
    
                $currentDate = date('Y-m-d H:i:s');
                if ($currentDate < $startDate || $currentDate > $endDate) {
                    $_SESSION['message_discount'] = 'Mã giảm giá này đã hết hạn';
                }
    
                if ($usageLimit !== null && $usedCount >= $usageLimit) {
                    $_SESSION['message_discount'] = 'Mã giảm giá đã hết lượt sử dụng';
                }
    
                $totalPrice = $this->getTotalPrice();      

                if ($minOrderValue !== null && $totalPrice < $minOrderValue) {
                    return [
                        'success' => false,
                        'message' => 'Đơn hàng chưa đạt giá trị tối thiểu để áp dụng mã'
                    ];
                }
    
                $discountAmount = 0;
                switch ($discountType) {
                    case 'percent':
                        $discountAmount = ($totalPrice * $discountValue) / 100;
                        break;
                    case 'fixed':
                        $discountAmount = $discountValue;
                        break;
                    case 'free_shipping':
                        $discountAmount = $totalPrice - 30000; 
                        break;
                }
    
                $finalAmount = $totalPrice - $discountAmount;
    
                return [
                    'success' => true,
                    'message' => 'Áp dụng mã giảm giá thành công',
                    'discount_id' => $discountId,
                    'discount_type' => $discountType,
                    'discount_value' => $discountValue,
                    'discount_amount' => $discountAmount,
                    'final_amount' => $finalAmount
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Mã giảm giá không tồn tại'
                ];
            }
        }
        
        return [
            'success' => false,
            'message' => 'Phương thức không hợp lệ'
        ];
    }
    
    private function getTotalPrice() {
        // Logic để lấy tổng giá đơn hàng
        // Ví dụ: return $this->cart->getTotal();
        return 0; // Thay bằng logic thực tế
    }
    
    private function getShippingCost() {
        // Logic để lấy phí vận chuyển
        // Ví dụ: return $this->shipping->getCost();
        return 0; // Thay bằng logic thực tế
    }
}