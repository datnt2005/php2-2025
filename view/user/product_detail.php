<section id="detailProduct" >
    <div class="container ">
        <div class="row">
            <div class="col-md-6">
                <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-inner">
                        <?php $isFirst = true; ?>
                        <?php foreach ($picProducts as $picProduct) : ?>
                        <div class="carousel-item <?= $isFirst ? 'active' : '' ?>">
                            <img src="http://localhost:8000/<?= htmlspecialchars($picProduct['imagePath']) ?>"
                                class="d-block w-100" alt="Sản phẩm">
                        </div>
                        <?php $isFirst = false; ?>
                        <?php endforeach; ?>
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Trở lại</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#productCarousel"
                        data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Tiếp theo</span>
                    </button>
                </div>
            </div>

            <div class="col-md-6">
                <form action="/cart/create" method="POST">
                    <input type="hidden" name="selectSize" id="selectSize">
                    <input type="hidden" name="selectColor" id="selectColor">
                    <input type="hidden" name="idProductItem" id="idProductItem">
                    <input type="hidden" name="sku" id="sku">
                    <input type="hidden" name="idProduct" value="<?= $product['productId'] ?>">
                    <input type="hidden" name="price" id="price">
                    <h2><?= htmlspecialchars($product['productName']) ?></h2>
                    <p><?= htmlspecialchars($product['productDescription']) ?></p>

                    <!-- Chọn dung lượng -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Dung lượng</label><br>
                        <?php $displayedSizes = []; ?>
                        <?php foreach ($productItems as $productItem): ?>
                        <?php if (!in_array($productItem['idSize'], $displayedSizes)): 
                        $displayedSizes[] = $productItem['idSize']; ?>
                        <button type="button" class="btn btn-outline-danger size-option"
                            data-size="<?= $productItem['idSize'] ?>">
                            <?= htmlspecialchars($productItem['nameSize'] ?? 'Không xác định') ?>
                        </button>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- Chọn màu sắc -->
                    <div class="mb-3">
                        <label class="form-label fw-bold">Màu sắc</label><br>
                        <?php $displayedColors = []; ?>
                        <?php foreach ($productItems as $productItem): ?>
                        <?php if (!in_array($productItem['idColor'], $displayedColors)): 
                        $displayedColors[] = $productItem['idColor']; ?>
                        <button type="button" class="btn btn-outline-danger color-option"
                            data-color="<?= $productItem['idColor'] ?>">
                            <?= htmlspecialchars($productItem['nameColor'] ?? 'Không xác định') ?>
                        </button>
                        <?php endif; ?>
                        <?php endforeach; ?>
                    </div>

                    <!-- hien thi sku -->
                    <p class=" fw-bold"> SKU: <span class="fw-normal" id="product-sku">---</span></p>
                    <!-- hien thi ton kho -->
                    <p class=" fw-bold"> Còn: <span class="fw-normal" id="product-inventory">---</span></p>
                    <!-- Hiển thị giá -->
                    <p class="text-danger" style="font-size: 24px; font-weight: bold;">Giá: <span
                            id="product-price">0</span></p>

                    <!-- Chọn số lượng -->
                    <div class="col-md-3">
                        <label for="quantity" class="form-label">Số lượng</label>
                        <div class="d-flex align-items-center">
                            <button type="button" class="btn btn-outline-secondary fw-bold m-1 btn-minus">-</button>
                            <input type="text" name="quantity" id="quantity" value="1" class="form-control text-center"
                                style="width: 70px;">
                            <button type="button" class="btn btn-outline-secondary fw-bold m-1 btn-plus">+</button>
                        </div>
                    </div>

                    <br>
                    <button class="btn btn-primary" id="add-to-cart">Thêm vào giỏ hàng</button>
                </form>
            </div>
        </div>
    </div>
    <div class="relativeProduct mt-5">
        <div class="container mt-3">
            <div class="row">
                <div class="col-md-12">
                    <h3 class="fw-bold text-center">Sản phẩm liên quan</h3>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col-md-12">
                    <div class="row">
                        <?php foreach ($relatedProducts as $relatedProduct): ?>
                        <div class="col-md-3 product">
                            <div class="card">
                                <img src="http://localhost:8000/<?= htmlspecialchars($relatedProduct['productImage']) ?>"
                                    class="card-img-top" alt="Sản phẩm">
                                <div class="card-body">
                                    <h5 class="card-title fw-bold"><?= htmlspecialchars($relatedProduct['name']) ?></h5>
                                    <a href="/products/<?= $relatedProduct['id'] ?>" class="btn btn-primary">Xem chi
                                        tiết</a>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
.selected {
    background-color: #007bff !important;
    color: white !important;
    border: 2px solid #0056b3 !important;
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const variants = <?php echo json_encode($productItems) ?>;
    let selectedSize = null;
    let selectedColor = null;

    function updateFields() {
        if (selectedSize && selectedColor) {
            const variant = variants.find(v => v.idSize == selectedSize && v.idColor == selectedColor);
            if (variant) {
                document.getElementById('product-price').textContent = variant.price.toLocaleString() + " VNĐ";
                document.getElementById('product-sku').textContent = variant.sku;
                document.getElementById('product-inventory').textContent = variant.quantityProduct;
                document.getElementById('selectSize').value = selectedSize;
                document.getElementById('selectColor').value = selectedColor;
                document.getElementById('idProductItem').value = variant.idVariant;
                document.getElementById('sku').value = variant.sku;
                document.getElementById('price').value = variant.price;
                document.getElementById('quantity').max = variant.quantityProduct;
            }
        }
    }

    function updatePrice() {
        if (selectedSize && selectedColor) {
            const variant = variants.find(v => v.idSize == selectedSize && v.idColor == selectedColor);
            document.getElementById('product-price').textContent = variant ? variant.price.toLocaleString() +
                " VNĐ" : "Sản phẩm hiện tại đang hết hàng!";
        } else {
            document.getElementById('product-price').textContent = "Vui lòng chọn biến thể";
        }
    }

    function updateSku() {
        if (selectedSize && selectedColor) {
            const variant = variants.find(v => v.idSize == selectedSize && v.idColor == selectedColor);
            document.getElementById('product-sku').textContent = variant ? variant.sku : "---";
        } else {
            document.getElementById('product-sku').textContent = "---";
        }
    }

    function updateInventory() {
        if (selectedSize && selectedColor) {
            const variant = variants.find(v => v.idSize == selectedSize && v.idColor == selectedColor);
            document.getElementById('product-inventory').textContent = variant ? variant.quantityProduct :
                "---";
            document.getElementById('quantity').max = variant ? variant.quantityProduct : 1;
        } else {
            document.getElementById('product-inventory').textContent = "---";
            document.getElementById('quantity').max = 1;
        }
    }

    document.querySelectorAll('.size-option').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.size-option').forEach(btn => btn.classList.remove(
                'selected'));
            this.classList.add('selected');
            selectedSize = this.getAttribute('data-size');
            updatePrice();
            updateSku();
            updateInventory();
            updateFields();
        });
    });

    document.querySelectorAll('.color-option').forEach(button => {
        button.addEventListener('click', function() {
            document.querySelectorAll('.color-option').forEach(btn => btn.classList.remove(
                'selected'));
            this.classList.add('selected');
            selectedColor = this.getAttribute('data-color');
            updatePrice();
            updateSku();
            updateInventory();
            updateFields();
        });
    });

    const quantityInput = document.getElementById('quantity');
    quantityInput.addEventListener('input', function() {
        let value = parseInt(this.value);
        let maxQuantity = parseInt(this.max);
        this.value = isNaN(value) || value < 1 ? 1 : Math.min(value, maxQuantity);
    });

    document.querySelector('.btn-minus').addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        if (value > 1) quantityInput.value = value - 1;
    });

    document.querySelector('.btn-plus').addEventListener('click', function() {
        let value = parseInt(quantityInput.value);
        let maxQuantity = parseInt(quantityInput.max);
        if (value < maxQuantity) quantityInput.value = value + 1;
    });

    document.getElementById('add-to-cart').addEventListener('click', function() {
        if (!selectedSize || !selectedColor) {
            alert("Vui lòng chọn dung lượng và màu sắc!");
            return;
        } else if (parseInt(quantityInput.value) == 0 || isNaN(parseInt(quantityInput.value)) ||
            parseInt(quantityInput.value) > parseInt(document.getElementById('product-inventory')
                .textContent)) {
            alert("Số lượng không hợp lý!");
            return;
        }
        let quantity = quantityInput.value;
        let variant = variants.find(v => v.idSize == selectedSize && v.idColor == selectedColor);
        let idVariant = variant.idVariant;
        // alert(`Thêm sản phẩm với Size: ${selectedSize}, Màu: ${selectedColor}, SKU: ${document.getElementById('product-sku').textContent}, Số lượng: ${quantity}, idProductItems: ${idVariant} vào giỏ hàng!`);
        // alert('Thêm sản phẩm thành công vào giỏ hàng!')
    });
});
</script>