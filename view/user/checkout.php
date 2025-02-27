<section id="checkout" class="h-100">
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3 class="fs-4 fw-bold">THÔNG TIN THANH TOÁN</h3>
                <form action="/orders/create" method="post">
                    <div class="address-delivery">
                        <p class="fw-bold mb-2">1. Địa chỉ nhận hàng</p>
                        <div class="detail-address px-2">
                            <div class="nameOder mt-3">
                                <label for="name" class="form-label">Tên</label>
                                <input type="text" name="name" id="name" class="w-100 p-2 form-control"
                                    placeholder="Nhập tên" required>
                            </div>
                            <div class="phone mt-3">
                                <label for="phone" class="form-label">SĐT</label>
                                <input type="number" name="phone" id="phone" class="w-100 p-2 form-control"
                                    placeholder="Nhập số điện thoại" required>
                            </div>
                            <div class="address mt-3">
                                <label for="address" class="form-label">Địa chỉ</label>
                                <input type="text" name="address" id="address" class="w-100 p-2 form-control"
                                    placeholder="Nhập địa chỉ" required>
                            </div>
                            <div class="noteOrder mt-3">
                                <label for="note" class="form-label">Ghi chú</label>
                                <textarea name="note" id="note" class="w-100 p-2 form-control" rows="3"
                                    placeholder="Ghi chú ..."></textarea>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="delivery-price">
                        <p class="fw-bold mb-2">2. Vận chuyển</p>
                        <div class="d-flex justify-content-between px-2">
                            <div class="input-checked">
                                <label class="fs-6">GHN-Tiêu chuẩn</label>
                            </div>
                            <p class="price delivery">+30.000đ</p>
                        </div>
                    </div>
                    <hr>
                    <div class="payment">
                        <p class="fw-bold mb-2">3. Phương thức thanh toán</p>
                        <div class="payment-method px-2">
                            <div class="pay">
                                <input type="radio" name="payment" value="cod" id="payment1" required>
                                <label class="fs-6 mx-2" for="payment1">Thanh toán khi nhận hàng</label>
                            </div>
                            <div class="vnPay mt-1">
                                <input type="radio" name="payment" value="vnpay" id="payment2" required>
                                <label class="fs-6 mx-2" for="payment2">Thanh toán VNPAY</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="coupon">
                        <p class="fw-bold mb-2">4. Áp dụng mã giảm giá</p>
                        <div class="coupon-input px-2">
                            <input type="search" id="code" placeholder="Nhập mã giảm giá" class="text-dark">
                            <button type="button" id="apply-coupon" class="btn btn-secondary">Sử dụng</button>
                        </div>
                        <div id="current-discount"></div>
                    </div>

                    <input type="hidden" name="action" id="action" value="order">
                    <input type="submit" class="btn btn-primary fw-bold w-100 mt-5" value="MUA HÀNG">
                </form>

                <?php if (isset($errors['database'])): ?>
                <div class="alert alert-danger mt-3"><?= htmlspecialchars($errors['database']); ?></div>
                <?php endif; ?>
            </div>
            <div class="col-md-6">
                <h3 class="fs-4 fw-bold">THÔNG TIN SẢN PHẨM</h3>
                <table class="table table-cart">
                    <thead>
                        <tr>
                            <th>Sản phẩm</th>
                            <th>Giá</th>
                            <th>Số lượng</th>
                            <th>Tạm tính</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($cartItems)): ?>
                        <?php foreach ($cartItems as $cartItem): ?>
                        <tr>
                            <td width="40%">
                                <div class="cart-products d-flex align-items-center">
                                    <div class="image-products">
                                        <img src="http://localhost:8000/<?= htmlspecialchars($cartItem['productImage']); ?>"
                                            alt="Items" width="70" height="70">
                                    </div>
                                    <div class="product-content mx-2">
                                        <a href="products/<?= $cartItem['idProduct']; ?>"
                                            class="name-products text-decoration-none">
                                            <p class="product-name text-white fw-bold">
                                                <?= htmlspecialchars($cartItem['name']); ?> <br>
                                                <?= htmlspecialchars($cartItem['nameSize']); ?>-<?= htmlspecialchars($cartItem['nameColor']); ?>
                                            </p>
                                        </a>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <span class="price"><?= number_format($cartItem['price']); ?>đ</span>
                            </td>
                            <td>
                                <span class="quantity text-center"><?= $cartItem['quantity']; ?></span>
                            </td>
                            <td>
                                <span
                                    class="total-price"><?= number_format($cartItem['price'] * $cartItem['quantity']); ?>đ</span>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                        <?php else: ?>
                        <tr>
                            <td colspan="4" class="text-center">Giỏ hàng của bạn đang trống</td>
                        </tr>
                        <?php endif; ?>
                    </tbody>
                </table>

                <div class="general-cart d-flex justify-content-between">
                    <div class="start-items">
                        <p class="fw-bold">Tổng sản phẩm:</p>
                        <p class="fw-bold">Tổng tiền:</p>
                        <p class="fw-bold">Vận chuyển:</p>
                        <?php if (isset($_SESSION['discount']) ): ?>
                        <p class="fw-bold">Giảm giá:</p>
                        <p class="fw-bold">Tổng tiền sau giảm:</p>
                        <?php endif; ?>
                    </div>
                    <div class="end-items text-end">
                        <p class="quantity-products"><?= number_format($totalQuantity); ?></p>
                        <p class="total-quantityInCart"><?= number_format($totalPrice); ?>đ</p>
                        <?php if (isset($_SESSION['discount']) && $_SESSION['discount']['discount_type'] === "free_shipping" ): ?>
                        <p class="delivery">Miễn phí</p>
                        <?php else: ?>
                        <p class="delivery">30.000đ</p>
                        <?php endif; ?>
                        <?php if (isset($_SESSION['discount']) ): ?>
                        <p class="discount">-<?= number_format($_SESSION['discount']['discount_value']); ?>đ</p>
                        <p class="total-quantityInCart"><?= number_format($_SESSION['discount']['discount_amount']); ?>đ</p>
                        <form action="/cancelDiscount" method="post" class="mt-2">
                            <input type="hidden" name="cancel_discount" value="1">
                            <button type="submit" class="btn btn-sm btn-danger">Hủy mã giảm giá</button>
                        </form>
                        <?php endif; ?>
                    </div>
                </div>

                <hr>
                <div class="d-flex justify-content-between text-danger">
                    <h5 class="fw-bold">THÀNH TIỀN:</h5>
                    <h5 class="fw-bold">
                        <?php
                        $finalTotal = $totalPrice + 30000;
                        
                        if (isset($_SESSION['discount']) && $_SESSION['discount']['discount_value'] > 0) {
                            $finalTotal = $_SESSION['discount']['discount_amount'] + 30000;
                            if ($_SESSION['discount']['discount_type'] === 'free_shipping') {
                                $finalTotal = $_SESSION['discount']['discount_amount'] + 30000; 
                            }
                        }
                        echo number_format($finalTotal);
                        
                        ?>đ
                    </h5>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.table th,
.table td {
    background-color: transparent !important;
    color: white !important;
    border-color: rgb(177, 177, 177) !important;
}
</style>
<script>
document.addEventListener('DOMContentLoaded', function() {
    function showAlert(message, type = 'danger') {
        let alertBox = document.createElement('div');
        alertBox.className = `alert alert-${type} mt-3`;
        alertBox.textContent = message;
        document.getElementById('checkout').prepend(alertBox);
        setTimeout(() => alertBox.remove(), 3000);
    }

    function number_format(number) {
        return new Intl.NumberFormat('vi-VN').format(number);
    }

    document.getElementById('apply-coupon').addEventListener('click', function() {
        let code = document.getElementById('code').value.trim();
        if (!code) {
            showAlert('Vui lòng nhập mã giảm giá!', 'warning');
            return;
        }

        fetch('/applyDiscount', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'code=' + encodeURIComponent(code)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Cập nhật tổng tiền
                document.querySelector('.total-quantityInCart').textContent = number_format(data.finalAmount) + 'đ';

                // Thêm hoặc cập nhật phần giảm giá
                let discountRow = document.querySelector('.discount');
                if (discountRow) {
                    discountRow.textContent = '-' + number_format(data.discountAmount) + 'đ';
                } else {
                    let discountRowElement = document.createElement('p');
                    discountRowElement.className = 'discount';
                    discountRowElement.textContent = '-' + number_format(data.discountAmount) + 'đ';
                    document.querySelector('.general-cart .start-items').appendChild(discountRowElement);
                }

                // Cập nhật tổng tiền sau giảm giá
                let finalTotalElement = document.querySelector('.total-quantityInCart');
                finalTotalElement.textContent = number_format(data.finalAmount) + 'đ';

                // Cập nhật UI mã giảm giá
                let currentDiscountElement = document.getElementById('current-discount');
                if (!currentDiscountElement) {
                    currentDiscountElement = document.createElement('div');
                    currentDiscountElement.id = 'current-discount';
                    document.querySelector('.coupon-input').appendChild(currentDiscountElement);
                }
                currentDiscountElement.innerHTML = `
                    <p class="text-success">Mã áp dụng: <strong>${data.code}</strong></p>
                    <button id="cancel-discount" class="btn btn-sm btn-danger">Hủy mã</button>
                `;

                showAlert('Áp dụng mã giảm giá thành công!', 'success');
                
                document.getElementById('cancel-discount').addEventListener('click', function() {
                    cancelDiscount();
                });
            } else {
                showAlert(data.message);
            }
        })
        .catch(() => showAlert('Lỗi kết nối đến máy chủ!'));
    });

    function cancelDiscount() {
        fetch('/cancelDiscount', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: 'cancel_discount=1'
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Xóa phần hiển thị mã giảm giá
                let currentDiscountElement = document.getElementById('current-discount');
                if (currentDiscountElement) {
                    currentDiscountElement.remove();
                }
                document.querySelector('.total-quantityInCart').textContent = number_format(data.originalTotal) + 'đ';
                
                let discountElement = document.querySelector('.discount');
                if (discountElement) {
                    discountElement.remove();
                }

                showAlert('Hủy mã giảm giá thành công!', 'success');
            } else {
                showAlert(data.message);
            }
        })
        .catch(() => showAlert('Lỗi kết nối đến máy chủ!'));
    }
});
</script>