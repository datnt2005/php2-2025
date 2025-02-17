<h1>Order List</h1>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Address</th>
            <th>Total Price</th>
            <th>Code</th>
            <th>Date</th>
            <th>Status</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($orders as $order): ?>
        <tr>
            <td><?= $order['id'] ?></td>
            <td><?= $order['name'] ?></td>
            <td><?= $order['phone'] ?> <br> <?= $order['address'] ?></td>
            <td>$<?= $order['total_price'] ?></td>
            <td><?= $order['code'] ?></td>
            <td><?= $order['status'] ?></td>
            <td><?= $order['created_at'] ?></td>
            <td>
                <a href="/order/<?= $order['id'] ?>" class="btn btn-info btn-sm">View</a>
                <a href="/order/edit/<?= $order['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/order/delete/<?= $order['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>