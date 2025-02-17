<h1>Category List</h1>
<a href="/categories/create" class="btn btn-primary mb-3">Create Category</a>
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
                <a href="/categories/edit/<?= $category['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                <a href="/categories/delete/<?= $category['id'] ?>" class="btn btn-danger btn-sm">Delete</a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>