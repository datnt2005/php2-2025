<h1>OrderItem #<?= $order['id'] ?></h1>
    <p class="fw-bold">Name: <span class="fw-normal"> <?= htmlspecialchars($order['name']) ?></span></p>
    <p class="fw-bold">Phone: <span class="fw-normal"> <?= htmlspecialchars($order['phone']) ?></span></p>
    <p class="fw-bold">Address: <span class="fw-normal"> <?= htmlspecialchars($order['address']) ?></span></p>
    <p class="fw-bold">Note: <span class="fw-normal"> <?= htmlspecialchars($order['noteOrder']) ?></span></p>
    <p class="fw-bold">Code: <span class="fw-normal"> <?= htmlspecialchars($order['code']) ?></span></p>
    <p class="fw-bold">Date: <span class="fw-normal"> <?= htmlspecialchars($order['created_at']) ?></span></p>
    <p class="fw-bold">Status: <span class="fw-normal"> <?= htmlspecialchars($order['status']) ?></span></p>
    <p class="fw-bold">Payment: <span class="fw-normal"> <?= htmlspecialchars($order['payment']) ?></span></p>
    <p class="fw-bold">Total: <span class="fw-normal"> <?= htmlspecialchars(number_format($order['total_price'], 0, ',', '.')); ?>đ</span></p>

<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Product</th>
            <th>Quantity</th>
            <th>Price</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orderItems as $orderItem): ?>
        <tr>
            <td><?= $orderItem['id'] ?></td>
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
        </tr>
        <?php endforeach; ?>
    </tbody>
    
</table>