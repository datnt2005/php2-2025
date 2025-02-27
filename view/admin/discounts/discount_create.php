<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create discount</h3>
                </div>
                <form method="POST" class="m-5">
                    <div class="mb-3">
                        <label for="nameDiscount" class="form-label">Name</label>
                        <input type="text" class="form-control" id="nameDiscount" name="nameDiscount" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="code" class="form-label">Code</label>
                        <input type="text" class="form-control" id="code" name="code" required>
                    </div>
                    <div class="mb-3">
                        <label for="discount_type" class="form-label">Discount Type</label>
                        <select class="form-select" id="discount_type" name="discount_type" required>
                            <option value="percent">Percent</option>
                            <option value="fixed">Fixed Amount</option>
                            <option value="free_shipping">free_shipping</option>

                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="discount_value" class="form-label">Discount Value</label>
                        <input type="number" class="form-control" id="discount_value" name="discount_value" required>
                    </div>
                    <div class="mb-3">
                        <label for="min_order_value" class="form-label">Minimum Order Value</label>
                        <input type="number" class="form-control" id="min_order_value" name="min_order_value">
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">Start Date</label>
                        <input type="date" class="form-control" id="start_date" name="start_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="end_date" class="form-label">End Date</label>
                        <input type="date" class="form-control" id="end_date" name="end_date" required>
                    </div>
                    <div class="mb-3">
                        <label for="usage_limit" class="form-label">Usage Limit</label>
                        <input type="number" class="form-control" id="usage_limit" name="usage_limit" >
                    </div>
                    <?php if (isset($error)) { ?> 
                        <p class="text-danger"> <?php echo $error; ?> </p> 
                    <?php } ?>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>