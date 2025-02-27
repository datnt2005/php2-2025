<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Product Variants</h3>
                </div>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Size</th>
                            <th>Color</th>
                            <th>Quantity</th>
                            <th>Price</th>
                            <th>SKU</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($productItems as $productItem): ?>
                        <tr>
                            <td><?= $productItem['idVariant'] ?></td>
                            <td><?= $productItem['nameSize'] ?></td>
                            <td><?= $productItem['nameColor'] ?></td>
                            <td><?= $productItem['quantityProduct'] ?></td>
                            <td>$<?= $productItem['price'] ?></td>
                            <td><?= $productItem['sku'] ?></td>

                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>