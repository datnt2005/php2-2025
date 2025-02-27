<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Products</h3>
                </div>
                <div class="choose d-flex justify-content-end">
                    <a href="/products/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create Product</a>
                    <a href="/sizes" class="btn btn-secondary mb-3 mt-3 ms-3">Size</a>
                    <a href="/colors" class="btn btn-secondary mb-3 mt-3 ms-3">Color</a>
                </div>

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
                                <a href="/product-variants/<?= $product['productId'] ?>"
                                    class="btn btn-secondary btn-sm">Variant</a>
                                <a href="/products/edit/<?= $product['productId'] ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="/products/delete/<?= $product['productId'] ?>"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>
</div>