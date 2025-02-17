<h1>Edit User</h1>
<form method="POST">
    <div class="mb-3">
        <label for="name" class="form-label">User</label>
        <input type="text" class="form-control" id="name" name="name" value="<?= $user['name'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="email" class="form-label">Email</label>
        <input type="email" class="form-control" id="email" name="email" value="<?= $user['email'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="password" class="form-label">Password</label>
        <input type="password" class="form-control" id="password" name="password" value="<?= $user['password'] ?>" required>
    </div>
    <div class="mb-3">
        <label for="role" class="form-label">Role</label>
        <select class="form-select" id="role" name="role" required>
            <option value="admin" <?= $user['role'] == 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="user" <?= $user['role'] == 'user' ? 'selected' : '' ?>>User</option>
        </select>
    </div>
    <div class="mb-3">
        <label for="status" class="form-label">Status</label>
        <select class="form-select" id="status" name="status" required>
            <option value="active" <?= $user['status'] == 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= $user['status'] == 'inactive' ? 'selected' : '' ?>>Inactive</option>
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Update</button>
</form>