<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Create Banner</h3>
                </div>
                <form method="POST" class="m-5" enctype="multipart/form-data" >
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title">
                        <?php if (isset($error)) { ?> <p class="text-danger"> <?php echo $error; ?> </p> <?php } ?>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image">
                        <?php if (isset($error)) { ?> <p class="text-danger"> <?php echo $error; ?> </p> <?php } ?>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>