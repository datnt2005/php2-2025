<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Discount</h3>
                </div>
                <form method="POST" class="m-5">
                    <div class="mb-3">
                        <label for="nameDiscount" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameDiscount" name="nameDiscount" value="<?= $discount['nameDiscount'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required><?= $discount['description'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" value="<?= $discount['code'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Discount Type</label>
                        <select class="form-select" id="discount_type" name="discount_type" required>
                            <option value="percent" <?= $discount['discount_type'] == 'percent' ? 'selected' : '' ?>>Percent</option>
                            <option value="fixed" <?= $discount['discount_type'] == 'fixed' ? 'selected' : '' ?>>Fixed Amount</option>
                            <option value="free_shipping" <?= $discount['discount_type'] == 'free_shipping' ? 'selected' : '' ?>>free_shipping</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Discount Value</label>
                        <input type="number" class="form-control" id="discount_value" name="discount_value" value="<?= $discount['discount_value'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="min_order_value" class="form-label">Minimum Order Value</label>
                        <input type="number" class="form-control" id="min_order_value" name="min_order_value" value="<?= $discount['min_order_value'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" value="<?= $discount['start_date'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" value="<?= $discount['end_date'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">Usage Limit</label>
                        <input type="number" class="form-control" id="usage_limit" name="usage_limit" value="<?= $discount['usage_limit'] ?>">
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" name="status" required>
                            <option value="1" <?= $discount['status'] == '1' ? 'selected' : '' ?>>Active</option>
                            <option value="0" <?= $discount['status'] == '0' ? 'selected' : '' ?>>Inactive</option>
                        </select>
                    </div>
                    <?php if (isset($error)) { ?> 
                        <p class="text-danger"> <?php echo $error; ?> </p> 
                    <?php } ?>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>