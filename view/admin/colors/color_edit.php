<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Color</h3>
                </div>
                <form method="POST" class="m-5">
                    <div class="mb-3">
                        <label for="nameColor" class="form-label">Color</label>
                        <input type="text" class="form-control" id="nameColor" name="nameColor"
                            value="<?= $color['nameColor'] ?>" required>
                    </div>
                    <button type="submit" class="btn btn-warning">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>