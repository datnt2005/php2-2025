<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Comment</h3>
                </div>
                <form method="POST" class="m-5" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="user" class="form-label">User</label>
                        <select name="user" id="user" class="form-select" required>
                            <option value="">--User--</option>
                            <?php foreach ($users as $user) { ?>
                                <option value="<?= $user['id'] ?>" <?= $comment['idUser'] == $user['id'] ? 'selected' : '' ?>>
                                    <?= $user['name'] ?> (#<?= $user['id'] ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="product" class="form-label">Product</label>
                        <select name="product" id="product" class="form-select" required>
                            <option value="">--Product--</option>
                            <?php foreach ($products as $product) { ?>
                                <option value="<?= $product['productId'] ?>" <?= $comment['idProduct'] == $product['productId'] ? 'selected' : '' ?>>
                                    <?= $product['productName'] ?> (#<?= $product['productId'] ?>)
                                </option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <input type="text" class="form-control m-0" id="content" name="content" required 
                               value="<?= htmlspecialchars($comment['content']) ?>">
                    </div>
                    <div class="mb-3">
                        <label for="rating" class="form-label">Rating</label>
                        <select name="rating" id="rating" class="form-select" required>
                            <option value="">--Rating--</option>
                            <?php for ($i = 1; $i <= 5; $i++) { ?>
                                <option value="<?= $i ?>" <?= $comment['rating'] == $i ? 'selected' : '' ?>><?= $i ?></option>
                            <?php } ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple>
                        <div class="list-images mt-3" id="listImages">
                            <?php foreach ($mediaComments as $mediaComment): ?>
                            <div class="image-item position-relative d-inline-block">
                                <img src="/<?= $mediaComment['media_url'] ?>" alt="Image" class="img-thumbnail"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                    onclick="removeSelectedImage(this)" data-index="<?= $mediaComment['id'] ?>">×</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="status" class="form-label">Status</label>
                        <select name="status" id="status" class="form-select" required>
                            <option value="">--Status--</option>
                            <option value="visible" <?= $comment['status'] == 'visible' ? 'selected' : '' ?>>Visible</option>
                            <option value="hidden" <?= $comment['status'] == 'hidden' ? 'selected' : '' ?>>Hidden</option>
                            <option value="reported" <?= $comment['status'] == 'reported' ? 'selected' : '' ?>>Reported</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
const imageInput = document.getElementById('image');
const listImages = document.getElementById('listImages');

// Xử lý khi chọn ảnh mới
imageInput.addEventListener('change', function () {
    listImages.innerHTML = "";

    Array.from(imageInput.files).forEach((file, index) => {
        const imageUrl = URL.createObjectURL(file);
        const imageWrapper = document.createElement('div');
        imageWrapper.classList.add('image-item', 'd-inline-block', 'position-relative', 'me-2', 'mb-2');

        imageWrapper.innerHTML = `
            <img src="${imageUrl}" alt="Image Preview" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" 
                    onclick="removeSelectedImage(${index})" style="cursor: pointer;">&times;</button>
        `;
        listImages.appendChild(imageWrapper);
    });
});

// Xóa ảnh mới được chọn
function removeSelectedImage(index) {
    const files = Array.from(imageInput.files);
    files.splice(index, 1);

    const dataTransfer = new DataTransfer();
    files.forEach(file => dataTransfer.items.add(file));
    imageInput.files = dataTransfer.files;

    const changeEvent = new Event("change");
    imageInput.dispatchEvent(changeEvent);
}



</script>
