<h1>Edit Order #<?= $order['id'] ?></h1>
<form method="POST" action="">
    <div class="mb-3">
        <label for="Status" class="form-label">Status</label>
        <select name="status" id="status" class="form-select">
            <option value="<?= $order['status'] ?>"><?= $order['status'] ?></option>
            <option value="Pending">Pending</option>
            <option value="Completed">Completed</option>
            <option value="Cancelled">Cancelled</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>