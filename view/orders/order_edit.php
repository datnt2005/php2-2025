<h1>Edit Order #<?= $order['id'] ?></h1>
<form method="POST" action="">
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