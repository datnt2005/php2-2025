<section id="checkout" class="h-100">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="fs-4 fw-bold">THÔNG TIN THANH TOÁN</h3>
                        <form action="/orders/create" method="post">
                            <?php if (!empty($errors)): ?>
                                <div class="alert alert-danger">
                                    <ul>
                                        <?php foreach ($errors as $error): ?>
                                            <li><?= htmlspecialchars($error); ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                            <?php endif; ?>
                            <div class="address-delivery">
                                <p class="fw-bold mb-2">1. Địa chỉ nhận hàng</p>
                                <div class="detail-address px-2">
                                    <div class="nameOder mt-3">
                                        <label for="name" class="form-label">Tên</label>
                                        <input type="text" name="name" id="name" class="w-100 p-2 form-control" placeholder="Nhập tên" required>
                                    </div>
                                    <div class="phone mt-3">
                                        <label for="phone" class="form-label">SĐT</label>
                                        <input type="number" name="phone" id="phone" class="w-100 p-2 form-control" placeholder="Nhập số điện thoại" required>
                                    </div>
                                    <div class="address mt-3">
                                        <label for="address" class="form-label">Địa chỉ</label>
                                        <input type="text" name="address" id="address" class="w-100 p-2 form-control" placeholder="Nhập địa chỉ" required>
                                    </div>
                                    <div class="noteOrder mt-3">
                                        <label for="note" class="form-label">Ghi chú</label>
                                        <textarea name="noteOrder" id="note"
                                            class="w-100 p-2 form-control" rows="3" placeholder="Ghi chú ..."></textarea>
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
                                        <input type="radio" name="payment" value="cod" id="payment1" required> <label class="fs-6 mx-2" for="payment1">Thanh toán khi nhận hàng</label>
                                    </div>
                                    <div class="vnPay mt-1">
                                        <input type="radio" name="payment" value="vnpay" id="payment2" required>
                                        <label class="fs-6 mx-2" for="payment2">Thanh toán VNPAY</label>
                                    </div>
                                    <!-- <?php
                                            if (isset($errors['payment'])) {
                                                echo "<span class='text-danger'>$errors[payment] </span>";
                                            }
                                            ?> -->
                                </div>
                            </div>
                            <hr>
                            <!-- <div class="coupon">
                                <p class="fw-bold mb-2">4. Áp dụng mã giảm giá</p>
                                <div class="coupon-input px-2">
                                    <input type="search" name="coupon" id="coupon" placeholder="Nhập mã giảm giá">
                                    <button type="submit" id="apply-coupon">Sử dụng</button>
                                </div> -->
                                <!--                                 
                                <?php
                                // if (isset($errors['coupon'])) {
                                //     echo "<span class='text-danger mx-2'>{$errors['coupon']}</span>";
                                // }
                                // if ($discountAmount) {
                                //     foreach ($coupons as $value) {
                                //         echo "<span class='text-success mx-2'>Bạn được giảm {$value['discount']}%</span>";
                                //     }
                                // }
                                ?> -->

                            <!-- </div> -->
                            <input type="hidden" name="action" id="action" value="order">

                            <input type="submit" class="btn btn-primary fw-bold w-100 mt-5" value="MUA HÀNG">
                        </form>
                            <!-- <script>
                                document.getElementById('apply-coupon').addEventListener('click', function() {
                                    // Đặt giá trị action là 'coupon' để phân biệt với nút mua hàng
                                    document.getElementById('action').value = 'coupon';
                                    document.querySelector('form').submit(); // Submit form
                                });

                                document.querySelector('form').addEventListener('submit', function() {
                                    // Đặt giá trị action là 'order' trước khi form được gửi nếu nút mua hàng được click
                                    document.getElementById('action').value = 'order';
                                });
                            </script> -->
                            <!-- <?php
                                    // if (isset($errors['database'])) {
                                    //     echo "<div class='alert alert-danger mt-3'>$errors[database]</div>";
                                    // }
                                    ?> -->
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
                                                            <img src="http://localhost:8000/<?php echo htmlspecialchars($cartItem['productImage']); ?>" alt="Items" width="70" height="70">
                                                        </div>
                                                        <div class="product-content mx-2">
                                                            <a href="detailProduct.php?id=<?php echo $cartItem['idProduct']; ?>" class="name-products text-decoration-none">
                                                                <p class="product-name text-dark"><?php echo htmlspecialchars($cartItem['name']); ?> <br> <?php echo htmlspecialchars($cartItem['nameSize']); ?>-<?php echo htmlspecialchars($cartItem['nameColor']); ?></p>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>
                                                    <span class="price"><?php echo number_format($cartItem['price']); ?>đ</span>
                                                </td>
                                                <td>
                                                    <span class="quantity text-center"><?php echo $cartItem['quantity']; ?></span>
                                                </td>
                                                <td>
                                                    <span class="total-price"><?php echo number_format($cartItem['price'] * $cartItem['quantity']); ?>đ</span>
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
                                    <?php if (isset($idCoupon)): ?>
                                        <p class="fw-bold">Giảm giá:</p>
                                        <p class="fw-bold">Tổng tiền sau giảm:</p>
                                    <?php endif; ?>
                                </div>
                                <div class="end-items text-end">
                                    <p class="quantity-products"><?php echo number_format($totalQuantity); ?></p>
                                    <p class="total-quantityInCart"><?php echo number_format($totalPrice); ?>đ</p>
                                    <p class="delivery">+30.000đ</p>
                                    <?php if (isset($idCoupon)): ?>
                                        <p class="discount"><?php echo $totalPrice - $discountedPrice; ?></p>
                                        <p class="total-quantityInCart"><?php echo $discountedPrice; ?></p>
                                    <?php endif; ?>
                                    <?php if (isset($idCoupon)): ?>
                                        <form action="checkout.php" method="POST">
                                            <input type="hidden" name="cancel_coupon" value="1">
                                            <button type="submit" class="btn btn-danger">Hủy mã giảm giá</button>
                                        </form>
                                    <?php endif; ?>
                                </div>

                            </div>

                            <hr>
                            <div class="d-flex justify-content-between text-danger">
                                <h5 class="fw-bold">TỔNG TIỀN:</h5>
                                <h5 class="fw-bold"><?php echo number_format($totalPrice + 30000);  ?>đ</h5>
                            </div>
                        </div>


            </section>