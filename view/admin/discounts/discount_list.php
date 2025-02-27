<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Discounts</h3>
                </div>
                <a href="/discounts/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create Discount</a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Code</th>
                            <th>Start Date</th>
                            <th>End date</th>
                            <th>Discount Type</th>
                            <th>Discount Value</th>
                            <th>Quantity</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($discounts as $discount): ?>
                        <tr>
                            <td><?= $discount['id'] ?></td>
                            <td><?= $discount['nameDiscount'] ?></td>
                            <td><?= $discount['code'] ?></td>
                            <td><?= $discount['start_date'] ?></td>
                            <td><?= $discount['end_date'] ?></td>
                            <td><?= $discount['discount_type'] ?></td>
                            <td><?= $discount['discount_value'] ?></td>
                            <td><?= $discount['usage_limit'] ?></td>
                            <td>
                                <a href="/discounts/<?= $discount['id'] ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="/discounts/delete/<?= $discount['id'] ?>"
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