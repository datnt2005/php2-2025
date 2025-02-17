<section id="cart" class="h-100">
    <div class="container">
        <div class="row">
            <div class="col-md-9">
                <form method="post">
                    <table class="table table-cart text-center">
                        <thead>
                            <tr>
                                <th></th>
                                <th class="text-start">Sản phẩm</th>
                                <th>Giá</th>
                                <th>Số lượng</th>
                                <th>Tạm tính</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($cartItems)): ?>
                            <?php foreach ($cartItems as $cartItem): ?>
                            <tr class="align-middle">
                                <td>
                                    <a href="/cart/delete/<?php echo $cartItem['idCartItem']; ?>" class="text-danger fw-bold text-decoration-none">Xóa</a>
                                </td>
                                <td>
                                    <a href="products/<?= $cartItem['idProduct']; ?>" class="name-products text-decoration-none">
                                        <div class="cart-products d-flex align-items-center">
                                            <img src="http://localhost:8000/<?= $cartItem['productImage']; ?>" alt="Items" style="width: 70px; height: 70px;">
                                            <div class="product-content mx-2">
                                                <p class="fw-bold text-dark"> 
                                                    <?php echo htmlspecialchars($cartItem['name']); ?>
                                                    (<?php echo htmlspecialchars($cartItem['nameSize']); ?> - <?php echo htmlspecialchars($cartItem['nameColor']); ?>)
                                                </p>
                                            </div>
                                        </div>
                                    </a>
                                </td>
                                <td><span class="price"> <?php echo number_format($cartItem['price'], 0, ',', '.'); ?>₫ </span></td>
                                <td>
                                    <div class="quantity d-flex align-items-center">
                                        <button type="button" class="btn btn-outline-secondary btn-minus" data-id="<?php echo $cartItem['idCartItem']; ?>">-</button>
                                        <input type="number" min="1" max="<?php echo $cartItem['quantity']; ?>" class="form-control text-center quantity-input m-2" 
                                             style='width: 70px;' id="quantity-<?php echo $cartItem['idCartItem']; ?>"
                                             data-id="<?php echo $cartItem['idCartItem']; ?>"
                                             data-price="<?php echo $cartItem['price']; ?>"
                                             value="<?php echo $cartItem['quantity']; ?>">

                                        <button type="button" class="btn btn-outline-secondary btn-plus" data-id="<?php echo $cartItem['idCartItem']; ?>">+</button>
                                    </div>
                                </td>
                                <td>
                                    <span class="total-price" id="total-price-<?php echo $cartItem['idCartItem']; ?>">
                                        <?php echo number_format($cartItem['price'] * $cartItem['quantity'], 0, ',', '.'); ?>₫
                                    </span>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                            <?php else: ?>
                            <tr>
                                <td colspan="5" class="text-center">Giỏ hàng của bạn đang trống</td>
                            </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                    <div class="d-flex justify-content-between mt-3 mb-4">
                        <a href="./shop" class="btn btn-info">TIẾP TỤC MUA HÀNG</a>
                        <!-- <button type="submit" name="update_cart" class="btn btn-warning">CẬP NHẬT GIỎ HÀNG</button> -->
                    </div>
                </form>
            </div>
            <div class="col-md-3">
                <p class="fw-bold text-dark">Tổng giỏ hàng</p>
                <hr>
                <div class="d-flex justify-content-between">
                    <p class="fw-bold">Tổng sản phẩm:</p>
                    <p class="quantity-products"> <?php echo $totalQuantity; ?> </p>
                </div>
                <div class="d-flex justify-content-between">
                    <p class="fw-bold">TỔNG:</p>
                    <p class="total-quantityInCart"> <span id="total_price"> <?php echo number_format($totalPrice, 0, ',', '.'); ?>₫ </span> </p>
                </div>
                <?php if (!empty($cartItems)){
                    echo '<a href="checkout" name="checkout" class="btn btn-primary w-100">THANH TOÁN</a>';
                }else{
                    echo '<a href="shop" class="btn btn-primary w-100">TIẾP TỤC MUA HÀNG</a>';
                }
                ?>
               
            </div>
        </div>
    </div>
</section>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateTotalPrice(id) {
        let quantityInput = document.getElementById('quantity-' + id);
        let price = parseFloat(quantityInput.dataset.price);
        let quantity = parseInt(quantityInput.value) || 1;
        document.getElementById('total-price-' + id).textContent = (price * quantity).toLocaleString('vi-VN') + '₫';
        updateCartTotal();
    }

    function updateCartTotal() {
        let totalQuantity = 0;
        let totalPrice = 0;
        document.querySelectorAll('.quantity-input').forEach(input => {
            let quantity = parseInt(input.value) || 1;
            let price = parseFloat(input.dataset.price);
            totalQuantity += quantity;
            totalPrice += price * quantity;
        });
        document.querySelector('.quantity-products').textContent = totalQuantity;
        document.getElementById('total_price').textContent = totalPrice.toLocaleString('vi-VN') + '₫';
    }

    function updateCartItem(id, quantity) {
    fetch('/cart/update', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'  // Đảm bảo gửi JSON
        },
        body: JSON.stringify({ idCartItem: id, quantity: quantity }) // Chuyển object thành JSON
    })
    .then(response => response.json())
    .then(data => {
        console.log("Server response:", data);
        if (data.status === "success") {
            document.querySelector('.quantity-products').textContent = data.totalQuantity;
            document.getElementById('total_price').textContent = data.totalPrice + '₫';
        } else {
            alert(data.message);
        }
    })
    .catch(error => console.error('Lỗi:', error));
}

    document.querySelectorAll('.quantity-input').forEach(input => {
        input.addEventListener('input', function () {
            let id = this.dataset.id;
            let quantity = parseInt(this.value) || 1;
            if (quantity < 1) quantity = 1;
            updateTotalPrice(id);
            updateCartItem(id, quantity); // Gọi AJAX để cập nhật trên server
        });
    });

    document.querySelectorAll('.btn-minus').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.dataset.id;
            let input = document.getElementById('quantity-' + id);
            if (input.value > 1) {
                input.value--;
                updateTotalPrice(id);
                updateCartItem(id, input.value);
            }
        });
    });

    document.querySelectorAll('.btn-plus').forEach(button => {
        button.addEventListener('click', function () {
            let id = this.dataset.id;
            let input = document.getElementById('quantity-' + id);
            input.value++;
            updateTotalPrice(id);
            updateCartItem(id, input.value);
        });
    });
});

</script>
