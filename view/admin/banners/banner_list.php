<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Banners</h3>
                </div>
                <a href="/banners/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create banner</a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Title</th>
                            <th>Image</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($banners as $banner): ?>
                        <tr>
                            <td><?= $banner['id'] ?></td>
                            <td><?= $banner['title'] ?></td>
                            <td><img src="http://localhost:8000/<?= $banner['image']; ?>" alt="Items" style="width: 70px; height: 70px;"></td>
                            <td><?= $banner['status'] ?></td>
                            <td>
                                <a href="/banners/<?= $banner['id'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="/banners/<?= $banner['id'] ?>"
                                    class="btn btn-warning btn-sm">Edit</a>
                                <a href="/banners/delete/<?= $banner['id'] ?>"
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