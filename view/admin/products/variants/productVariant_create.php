<h1>Create Product</h1>
<form method="POST" id="createVariantForm">
    <div id="variant-container" class="mb-3">
        <!-- Variants will be added dynamically here -->
    </div>
    <button type="button" class="btn btn-info" id="addVariantButton">Thêm biến thể</button>
    <button type="submit" class="btn btn-success">Create</button>
</form>

<script>
    // Selectors
    const variantContainer = document.getElementById('variant-container');
    const addVariantButton = document.getElementById('addVariantButton');
    const createVariantForm = document.getElementById('createVariantForm');

    // Function to add a variant
    function addVariant() {
        const variantCount = variantContainer.children.length;

        const variantHTML = `
            <div class="form-group variant-group border p-3 mb-3" id="variant-${variantCount}">
                <div class="row">
                    <div class="col-md-3">
                        <label for="size-${variantCount}" class="form-label">Kích thước</label>
                        <select name="variants[${variantCount}][size]" id="size-${variantCount}" class="form-select" required>
                            <option value="">Chọn kích thước</option>
                            <option value="1">Size 1</option>
                            <option value="2">Size 2</option>
                            <option value="3">Size 3</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <label for="price-${variantCount}" class="form-label">Giá</label>
                        <input type="number" name="variants[${variantCount}][price]" id="price-${variantCount}" class="form-control" placeholder="Nhập giá" min="0" required>
                    </div>
                    <div class="col-md-3">
                        <label for="quantity-${variantCount}" class="form-label">Số lượng</label>
                        <input type="number" name="variants[${variantCount}][quantity]" id="quantity-${variantCount}" class="form-control" placeholder="Nhập số lượng" min="0" required>
                    </div>
                    <div class="col-md-3 d-flex align-items-end">
                        <button type="button" class="btn btn-danger" onClick="removeVariant(${variantCount})">Xóa</button>
                    </div>
                </div>
            </div>
        `;

        variantContainer.insertAdjacentHTML('beforeend', variantHTML);
    }

    // Function to remove a variant
    function removeVariant(index) {
        const variant = document.getElementById(`variant-${index}`);
        if (variant) {
            variant.remove();
        }
    }

    // Add variant button click event
    addVariantButton.addEventListener('click', addVariant);

    // Form submit event
    createVariantForm.addEventListener('submit', (e) => {
        e.preventDefault(); // Prevent default form submission for testing
        const formData = new FormData(createVariantForm);
        console.log(Object.fromEntries(formData.entries()));
        alert('Form submitted successfully! Check console for form data.');
    });
</script>
