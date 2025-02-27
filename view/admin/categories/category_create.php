<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Category</h3>
                </div>
                <form method="POST" class="m-5">
                    <div class="mb-3">
                        <label for="name" class="form-label">Category</label>
                        <input type="text" class="form-control" id="name" name="name">
                        <?php if (isset($error)) { ?> <p class="text-danger"> <?php echo $error; ?> </p> <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>