<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Size</h3>
                </div>
                <form method="POST" class="m-5">
                    <div class="mb-3">
                        <label for="nameSize" class="form-label">Size</label>
                        <input type="text" class="form-control" id="nameSize" name="nameSize"
                            value="<?= $size['nameSize'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>