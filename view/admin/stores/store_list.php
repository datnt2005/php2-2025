<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Stores</h3>
                </div>
                <a href="/stores/create" class="btn btn-primary mb-3 w-25 mt-3 ms-3">Create Store</a>
                <table class="table table-bordered table-striped">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Address</th>
                            <th>Phone</th>
                            <th>Open Time</th>
                            <th>Close Time</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($stores as $store): ?>
                        <tr>
                            <td><?= $store['id'] ?></td>
                            <td><?= $store['name'] ?></td>
                            <td><?= $store['description'] ?></td>
                            <td><?= $store['address'] ?></td>
                            <td><?= $store['phone_number'] ?></td>
                            <td><?= $store['open_time'] ?></td>
                            <td><?= $store['close_time'] ?></td>
                            <td>
                                <a href="/stores/<?= $store['id'] ?>" class="btn btn-info btn-sm">View</a>
                                <a href="/stores/edit/<?= $store['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                <a href="/stores/delete/<?= $store['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>