<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Order <?= $order['id'] ?></h3>
                </div>
                <form method="POST" action="" class="m-5">
                    <div class="mb-3">
                        <label for="Status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" require>
                            <option value="<?= $order['status'] ?>"><?= $order['status'] ?></option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>