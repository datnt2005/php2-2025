
<form action="/trackOrder" class="d-flex" method="POST">
    <input type="text" name="order_code" class="form-control w-25 " placeholder="Nhập mã đơn hàng" required>
    <button type="submit" class="btn btn-primary mx-2">Tìm kiếm</button>
</form>
<?php foreach ($orders as $order): ?>

<div class="container my-5">
            <div class="row row-cols-1 row-cols-md-2 g-4">
                <!-- Hiển thị từng đơn hàng -->
                    <div class="col-md-12">
                        <a href="/myOrderItem/<?php echo $order['id']; ?>" class="text-decoration-none text-dark">
                            <div class="card h-100 shadow border-0 rounded-4 p-3 hover-effect">
                                <div class="card-body">
                                    <h5 class="card-title mb-3">Mã Đơn Hàng: <?php echo $order['code']; ?></h5>
                                    <table class="table table-borderless mb-0">
                                        <thead>
                                            <tr>
                                                <th>Ngày Mua</th>
                                                <th>Địa Chỉ</th>
                                                <th>Tổng Tiền</th>
                                                <th>Trạng Thái</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td><?php echo $order['created_at']; ?></td>
                                                <td><?php echo $order['phone'] . " - " . $order['address'];?></td>
                                                <td><?php echo number_format($order['total_price']); ?>đ</td>
                                                <td>
                                                    <?= $order['status'] ?>
                                                </td>
                                                <td>
                                                    <a href="shop.php" class="btn btn-primary">Mua lại</a>
                                                </td>
                                                <?php if ($order['status'] == "pending") : ?>
                                                    <td><a href="javascript:void(0);" onclick="cancelOrder('<?php echo $order['id']; ?>')" class="btn btn-danger">Hủy đơn hàng</a>
                                                    </td>
                                                <?php endif; ?>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </a>
                    </div>
            </div>
        </div>
        <?php endforeach; ?>
        <script>
function cancelOrder(orderId) {
    if (confirm("Bạn có chắc chắn muốn hủy đơn hàng này không?")) {
        window.location.href = "/cancelOrder/" + orderId;
    }
}
</script>
