<h1>Product List</h1>
<a href="/products/create" class="btn btn-primary mb-3">Create Product</a>
<table class="table table-bordered table-striped">
    <thead class="table-dark">
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Category</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($products as $product): ?>
        <tr>
            <td><?= $product['productId'] ?></td>
            <td><?= $product['productName'] ?></td>
            <td>$<?= $product['productPrice'] ?></td>
            <td><?= $product['totalQuantity'] ?></td>
            <td><?= $product['categoryName'] ?></td>
            <td>
                <a href="/product-variants/<?= $product['productId'] ?>" class="btn btn-secondary btn-sm">Variant</a>
                <a href="/products/edit/<?= $product['productId'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/products/delete/<?= $product['productId'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>