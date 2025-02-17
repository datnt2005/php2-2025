<h1>Edit Color</h1>
<form method="POST">
    <div class="mb-3">
        <label for="nameColor" class="form-label">Color</label>
        <input type="text" class="form-control" id="nameColor" name="nameColor" value="<?= $color['nameColor'] ?>" required>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>