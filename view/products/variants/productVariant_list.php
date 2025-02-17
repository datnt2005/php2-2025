<h1>Product Variant List</h1>
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