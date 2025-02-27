<section id="myOrder" class="py-3">
<div class="container my-5">
<!-- Thông tin khách hàng -->
<div class="card shadow-sm border-0 rounded-4 p-4 mt-4">
    <h5 class="mb-3">Thông Tin Giao hàng</h5>
    <table class="table table-borderless mb-4">
        <tbody>
            <tr>
                <td><strong>Họ và Tên:</strong></td>
                <td><?php echo $orders['name']; ?></td>
            </tr>
            <tr>
                <td><strong>Số Điện Thoại:</strong></td>
                <td><?php echo $orders['phone']; ?></td>
            </tr>
            <tr>
                <td><strong>Địa Chỉ:</strong></td>
                <td><?php echo $orders['address']; ?></td>
            </tr>
            <tr>
                <td><strong>Ghi Chú:</strong></td>
                <td><?php echo $orders['noteOrder']; ?></td>
            </tr>
            <tr>
                <td><strong>Mã sản phẩm:</strong></td>
                <td><?php echo $orders['code']; ?></td>
            </tr>
            <tr>
                <td><strong>Phương thức thanh toán:</strong></td>
                <td><?php echo $orders['payment']; ?></td>
            </tr>
            <tr>
                <td><strong>Trạng thái đơn hàng:</strong></td>
                <td><?php echo $orders['status']; ?></td>
            </tr>

        </tbody>
    </table>
</div>

<!-- Thông tin sản phẩm -->
<div class="card shadow-sm border-0 rounded-4 p-4 mt-4">
    <h5 class="mb-3">Thông Tin Sản Phẩm</h5>
    <table class="table table-bordered mb-4">
        <thead class="table-light">
            <tr>
                <th>Sản Phẩm</th>
                <th>Số Lượng</th>
                <th>Giá</th>
                <th>Thành Tiền</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach ($orderItems as $orderItem): ?>
        <tr>
            <td width="40%">
            <div class="cart-products d-flex align-items-center">
                 <img src="http://localhost:8000/<?= $orderItem['productImage']; ?>" alt="Items" style="width: 70px; height: 70px;">
                 <div class="product-content mx-2">
                     <p class="fw-bold text-dark"> 
                         <?php echo htmlspecialchars($orderItem['name']); ?>
                         (<?php echo htmlspecialchars($orderItem['nameSize']); ?> - <?php echo htmlspecialchars($orderItem['nameColor']); ?>)
                     </p>
                 </div>
            </div>
            <td><?= $orderItem['quantity'] ?></td>
            <td>$<?= $orderItem['price'] ?></td>
                    <td><?php echo number_format($orderItem['quantity'] * $orderItem['price']); ?>đ</td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <div class="d-flex justify-content-end">
        <p class="fw-bold">Phí vận chuyển: 30.000đ</p>
    </div>
    <div class="d-flex justify-content-end">
        <p class="fw-bold">Tổng tiền: <?php echo number_format($orders['total_price']); ?>đ</p>
    </div>
    
    <div class="d-flex justify-content-end">
        <p class="fw-bold">Giảm giá: -<?php echo number_format($orders['discount_value']); ?></p>
    </div>
    <div class="d-flex justify-content-end">
        <h5 class="fw-bold">Thành tiền: <?php echo number_format($orders['final_amount']); ?></h5>
    </div>
</div>
</div>
</section>