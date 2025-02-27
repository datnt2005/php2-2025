<div class="container-fluid">
    <!-- Place your content here -->
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Edit Product</h3>
                </div>
                <form method="POST" id="updateProductForm" enctype="multipart/form-data" class="m-5">
                    <div class="mb-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            value="<?= $product['productName'] ?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="4"
                            required><?= $product['productDescription'] ?></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="category_id" class="form-label">Category</label>
                        <select class="form-select" id="category_id" name="category_id" required>
                            <option value="">--Danh mục--</option>
                            <?php foreach ($categories as $category): ?>
                            <option value="<?= $category['id'] ?>"
                                <?= $product['categoryId'] == $category['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($category['name']) ?>
                            </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="image" class="form-label">Image</label>
                        <input type="file" class="form-control" id="image" name="image[]" multiple>
                        <div class="list-images mt-3" id="listImages">
                            <?php foreach ($images as $image): ?>
                            <div class="image-item position-relative d-inline-block">
                                <img src="/<?= $image['imagePath'] ?>" alt="Image" class="img-thumbnail"
                                    style="width: 100px; height: 100px; object-fit: cover;">
                                <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0"
                                    onclick="removeSelectedImage(this)" data-index="<?= $image['id'] ?>">×</button>
                            </div>
                            <?php endforeach; ?>
                        </div>
                    </div>
                    <div id="variant-container" class="mb-3">
                        <?php foreach ($variants as $index => $variant): ?>
                        <div class="variant-group border p-3 mb-3" id="variant-<?= $index ?>">
                            <div class="row">
                                <div class="col-md-2">
                                    <label for="size-<?= $index ?>" class="form-label">Kích thước</label>
                                    <select name="variants[<?= $index ?>][size]" id="size-<?= $index ?>"
                                        class="form-select" required>
                                        <option value="">Chọn kích thước</option>
                                        <?php foreach ($sizes as $size): ?>
                                        <option value="<?= $size['idSize'] ?>"
                                            <?= $variant['idSize'] == $size['idSize'] ? 'selected' : '' ?>>
                                            <?= $size['nameSize'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="color-<?= $index ?>" class="form-label">Màu sắc</label>
                                    <select name="variants[<?= $index ?>][color]" id="color-<?= $index ?>"
                                        class="form-select" required>
                                        <option value="">Chọn màu sắc</option>
                                        <?php foreach ($colors as $color): ?>
                                        <option value="<?= $color['idColor'] ?>"
                                            <?= $variant['idColor'] == $color['idColor'] ? 'selected' : '' ?>>
                                            <?= $color['nameColor'] ?>
                                        </option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label for="price-<?= $index ?>" class="form-label">Giá</label>
                                    <input type="number" name="variants[<?= $index ?>][price]" id="price-<?= $index ?>"
                                        class="form-control" min="0" value="<?= $variant['price'] ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="quantity-<?= $index ?>" class="form-label">Số lượng</label>
                                    <input type="number" name="variants[<?= $index ?>][quantity]"
                                        id="quantity-<?= $index ?>" class="form-control" min="0"
                                        value="<?= $variant['quantityProduct'] ?>" required>
                                </div>
                                <div class="col-md-2">
                                    <label for="sku-<?= $index ?>" class="form-label">SKU</label>
                                    <input type="text" name="variants[<?= $index ?>][sku]" id="sku-<?= $index ?>"
                                        class="form-control" value="<?= htmlspecialchars($variant['sku']) ?>" required>
                                </div>
                                <div class="col-md-2 d-flex align-items-end">
                                    <button type="button" class="btn btn-danger"
                                        onclick="removeVariant(<?= $index ?>)">Xóa</button>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                    <button type="button" class="btn btn-info" id="addVariantButton">Thêm biến thể</button>
                    <button type="submit" class="btn btn-success">Update</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script>
const sizes = <?= json_encode($sizes) ?>;
const colors = <?= json_encode($colors) ?>;
const variantContainer = document.getElementById('variant-container');
const addVariantButton = document.getElementById('addVariantButton');
const imageInput = document.getElementById('image');
const listImages = document.getElementById('listImages');
let variantCount = <?= count($variants) ?>;

function addVariant() {
    const variantHTML = `
            <div class="variant-group border p-3 mb-3" id="variant-${variantCount}">
                <div class="row">
                    <div class="col-md-2">
                        <label for="size-${variantCount}" class="form-label">Kích thước</label>
                        <select name="variants[${variantCount}][size]" id="size-${variantCount}" class="form-select" required>
                            <option value="">Chọn kích thước</option>
                            ${sizes.map(size => `<option value="${size.idSize}">${size.nameSize}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="color-${variantCount}" class="form-label">Màu sắc</label>
                        <select name="variants[${variantCount}][color]" id="color-${variantCount}" class="form-select" required>
                            <option value="">Chọn màu sắc</option>
                            ${colors.map(color => `<option value="${color.idColor}">${color.nameColor}</option>`).join('')}
                        </select>
                    </div>
                    <div class="col-md-2">
                        <label for="price-${variantCount}" class="form-label">Giá</label>
                        <input type="number" name="variants[${variantCount}][price]" id="price-${variantCount}" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-2">
                        <label for="quantity-${variantCount}" class="form-label">Số lượng</label>
                        <input type="number" name="variants[${variantCount}][quantity]" id="quantity-${variantCount}" class="form-control" min="0" required>
                    </div>
                    <div class="col-md-2">
                        <label for="sku-${variantCount}" class="form-label">SKU</label>
                        <input type="text" name="variants[${variantCount}][sku]" id="sku-${variantCount}" class="form-control" required>
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onclick="removeVariant(${variantCount})">Xóa</button>
                    </div>
                </div>
            </div>
        `;
    variantContainer.insertAdjacentHTML('beforeend', variantHTML);
    variantCount++;
}

function removeVariant(index) {
    const variant = document.getElementById(`variant-${index}`);
    if (variant) variant.remove();
}

addVariantButton.addEventListener('click', addVariant);

imageInput.addEventListener('change', function() {
    listImages.innerHTML = "";
    Array.from(imageInput.files).forEach((file, index) => {
        const imageUrl = URL.createObjectURL(file);
        const imageWrapper = document.createElement('div');
        imageWrapper.classList.add('image-wrapper', 'd-inline-block', 'position-relative', 'me-2',
            'mb-2');
        imageWrapper.innerHTML = `
            <img src="${imageUrl}" alt="Image Preview" class="img-thumbnail" style="width: 100px; height: 100px; object-fit: cover;">
            <button type="button" class="btn btn-sm btn-danger position-absolute top-0 end-0" onclick="removeSelectedImage(${index})">&times;</button>
        `;
        listImages.appendChild(imageWrapper);
    });
});

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