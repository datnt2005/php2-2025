<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Categories</h3>
                </div>
                <a href="/categories/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create Category</a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Category</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($categories as $category): ?>
                        <tr>
                            <td><?= $category['id'] ?></td>
                            <td><?= $category['name'] ?></td>
                            <td>
                                <a href="/categories/<?= $category['id'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="/categories/edit/<?= $category['id'] ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="/categories/delete/<?= $category['id'] ?>"
                                    class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>