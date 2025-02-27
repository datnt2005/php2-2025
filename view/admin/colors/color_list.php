<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Colors</h3>
                </div>
                <a href="/colors/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create Color</a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Color</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($colors as $color): ?>
                        <tr>
                            <td><?= $color['idColor'] ?></td>
                            <td><?= $color['nameColor'] ?></td>
                            <td>
                                <a href="/colors/edit/<?= $color['idColor'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="/colors/delete/<?= $color['idColor'] ?>"
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