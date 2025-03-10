<section id="detailProduct">
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
                    <h3 class="fw-bold text-center">SẢN PHẨM LIÊN QUAN</h3>
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
    <div class="ratingProduct mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-12 text-center">
                    <h3 class="fw-bold">ĐÁNH GIÁ SẢN PHẨM</h3>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-md-12">
                    <div class="comment p-4 rounded shadow">
                        <div class="container">
                            <div class="row align-items-center p-4 rounded-3 rounded shadow"
                                style="background-color:rgb(199, 199, 199);">
                                <!-- Tổng số sao -->
                                <div class="col-md-3 text-center">
                                    <div class="evaluate fs-1 fw-bold text-danger">
                                        <span
                                            class="evaluateStart"><?php echo number_format($averageRating['average_rating'], 1) ?></span>
                                        <span class="fs-4 text-dark">/ 5</span>
                                        <br>
                                        <?php
                                         $fullStars = floor($averageRating['average_rating']);
                                         $halfStar = ($averageRating['average_rating'] - $fullStars) >= 0.5 ? 1 : 0;
                                         $emptyStars = 5 - $fullStars - $halfStar;
                                         ?>
                                        <?php for ($i = 0; $i < $fullStars; $i++): ?>
                                        <i class="fa-solid fa-star text-danger fs-4"></i>
                                        <?php endfor; ?>
                                        <?php if ($halfStar): ?>
                                        <i class="fa-solid fa-star-half-alt text-danger fs-4"></i>
                                        <?php endif; ?>
                                        <?php for ($i = 0; $i < $emptyStars; $i++): ?>
                                        <i class="fa-regular fa-star text-danger fs-4"></i>
                                        <?php endfor; ?>
                                        <p class="text-muted mt-2 fs-4">(<?php echo count($comments) ?>)</p>
                                    </div>
                                </div>

                                <!-- Lọc đánh giá -->
                                <?php
                                $ratingsCount = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

                                foreach ($comments as $comment) {
                                    $ratingsCount[$comment['rating']]++;
                                }

                                $totalComments = count($comments);
                                ?>

                                <!-- Lọc đánh giá -->
                                <div class="col-md-9">
                                    <h5 class="fw-bold text-dark">Lọc đánh giá</h5>
                                    <div class="list-evaluate">
                                        <ul class="list-unstyled">
                                            <?php for ($star = 5; $star >= 1; $star--): 
                                                $percentage = ($totalComments > 0) ? ($ratingsCount[$star] / $totalComments) * 100 : 0;
                                            ?>
                                            <li class="d-flex align-items-center justify-content-between mb-2">
                                                <a href="javascript:void(0);"
                                                    class="text-decoration-none text-dark fw-bold filter-rating"
                                                    data-rating="<?= $star ?>"><?= $star ?> Sao</a>
                                                <div class="progress w-50">
                                                    <div class="progress-bar bg-danger"
                                                        style="width: <?= $percentage ?>%"></div>
                                                </div>
                                                <span class="text-muted ms-2">(<?= $ratingsCount[$star] ?>)</span>
                                            </li>
                                            <?php endfor; ?>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <!-- them binh luan -->
                        <?php if($canComment !== false): ?>
                        <div class="addComment p-4 rounded mt-3 ">
                            <div class="col-md-12">
                                <hr>
                                <div class="comment-form container">
                                    <form id="comment-form"
                                        action="/comments/addCommentUser/<?= $product['productId'] ?>" method="POST"
                                        enctype="multipart/form-data">
                                        <input type="hidden">
                                        <!-- Phần đánh giá sao -->
                                        <div class="d-flex">
                                            <label for="name" class="form-label fw-bold text-dark">Đánh giá</label>
                                            <div class="evaluate d-flex mx-3">
                                                <input type="hidden" name="rating" id="selected-star">
                                                <button type="button" class="btn d-flex btn-evaluate"
                                                    style="border-right: 1px solid #ccc; border-radius: 0;"
                                                    data-star="5">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </button>
                                                <button type="button" class="btn d-flex btn-evaluate"
                                                    style="border-right: 1px solid #ccc; border-radius: 0;"
                                                    data-star="4">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </button>
                                                <button type="button" class="btn d-flex btn-evaluate"
                                                    style="border-right: 1px solid #ccc; border-radius: 0;"
                                                    data-star="3">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </button>
                                                <button type="button" class="btn d-flex btn-evaluate"
                                                    style="border-right: 1px solid #ccc; border-radius: 0;"
                                                    data-star="2">
                                                    <i class="fa-solid fa-star"></i>
                                                    <i class="fa-solid fa-star"></i>
                                                </button>
                                                <button type="button" class="btn d-flex btn-evaluate" data-star="1">
                                                    <i class="fa-solid fa-star"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <div id="variant-error" class="text-danger mt-2"></div>

                                        <!-- Phần thông tin bình luận -->
                                        <label for="content" class="form-label fw-bold text-dark">Bình luận</label>
                                        <textarea class="form-control" id="content" name="content"
                                            placeholder="Nhập bình luận ..." required></textarea><br>

                                        <!-- Phần thêm hình ảnh -->
                                        <label for="images" class="form-label fw-bold text-dark ">Thêm hình
                                            ảnh</label><br>
                                        <input type="file" id="images" name="images[]" class="form-control w-50"
                                            multiple><br>

                                        <!-- Nút gửi bình luận -->
                                        <button type="submit" name="submit_comment" class="btn btn-primary">Gửi bình
                                            luận</button>
                                    </form>

                                    <?php
                                    // Hiển thị lỗi nếu có
                                    if (!empty($errors)) {
                                        foreach ($errors as $error) {
                                            if (is_array($error)) {
                                                foreach ($error as $e) {
                                                    echo "<p class='text-danger'>$e</p>";
                                                }
                                            } else {
                                                echo "<p class='text-danger'>$error</p>";
                                            }
                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>
                        <!-- Danh sách đánh giá -->
                        <div class="container mt-4">
                            <h5 class="fw-bold ">Đánh giá từ khách hàng</h5>
                            <?php if(empty($comments)): ?>
                            <p class="text-white text-center">Không có đánh giá nào</p>
                            <?php else: ?>
                            <?php foreach($comments as $comment): ?>

                            <div class="review mt-3 p-3 rounded shadow-sm" style="background-color:rgb(80, 80, 80);">
                                <div class="d-flex align-items-center">
                                    <img src="http://localhost:8000/<?= htmlspecialchars($comment['avatarUser']) ?>"
                                        class="rounded-circle me-3" width="30" height="30" alt="User">
                                    <div>
                                        <h6 class="mb-0"><?= htmlspecialchars($comment['nameUser']) ?><span
                                                class=" mx-2 fw-normal"
                                                style="color:rgb(189, 189, 189);">-<?= date('Y-m-d H:i:s', strtotime($comment['created_at'])) ?>-</span>
                                        </h6>
                                        <div class="text-danger">
                                            <?php for ($i = 0; $i < 5; $i++): ?>
                                            <i class="fa-solid fa-star<?= $i < $comment['rating'] ? '' : '-o'; ?>"></i>
                                            <?php endfor; ?>
                                        </div>
                                    </div>
                                </div>
                                <p class="mt-1">"<?= htmlspecialchars($comment['content']) ?>"</p>
                                <?php 
                                     $mediaUrls = explode(', ', $comment['media_urls']); 
                                     $mediaTypes = explode(', ', $comment['media_types']);
                                 ?>
                                <?php foreach ($mediaUrls as $index => $mediaUrl): ?>
                                <?php if (strpos($mediaTypes[$index], 'image') !== false): ?>
                                <img src="http://localhost:8000/<?= trim($mediaUrl) ?>" alt="Image"
                                    style="width: 100px; height: 100px; margin-right: 5px;">
                                <?php elseif (strpos($mediaTypes[$index], 'video') !== false): ?>
                                <video style="width: 100px; height: 70px; margin-right: 5px;" controls>
                                    <source src="http://localhost:8000/<?= trim($mediaUrl) ?>"
                                        type="<?= trim($mediaTypes[$index]) ?>">
                                    Your browser does not support the video tag.
                                </video>
                                <?php endif; ?>
                                <?php endforeach; ?>
                                <div class="d-flex justify-content-between align-items-center mt-2">
                                    <div>
                                        <button class="btn btn-sm btn-transparent text-white btn-like p-0 mb-1"
                                            data-comment-id="<?= $comment['id'] ?>">
                                            <span class="like-count"><?= $comment['likes'] ?></span>

                                            <i class="fa-regular fa-thumbs-up"></i> Like

                                        </button>
                                    </div>
                                    <div>
                                        <div class="dropdown">
                                        <button class="btn btn-sm btn-transparent text-white"
                                            type="button" id="dropdownMenuButton" data-bs-toggle="dropdown"
                                            aria-expanded="false">
                                            <i class="fas fa-ellipsis-h"></i>
                                        </button>
                                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                <?php if ($comment['idUser'] !== $_SESSION['user']['id']): ?>
                                                <li><a class="dropdown-item" href="#">Report</a></li>
                                                <li><a class="dropdown-item" href="#">Share</a></li>
                                                <?php else: ?>
                                                <li><button class="btn btn-edit w-100 text-start" class="dropdown-item"
                                                        data-comment-id="<?= $comment['id']; ?>"
                                                        data-content="<?= htmlspecialchars($comment['content']); ?>"
                                                        data-rating="<?= $comment['rating']; ?>"
                                                        data-idProduct="<?= $comment['idProduct']; ?>">
                                                        Cập nhật
                                                    </button></li>
                                                <li class="text-danger"><a class="dropdown-item" class="text-danger"
                                                        style="color: red" href="javascript:void(0);"
                                                        onclick="deleteComment(this)" data-id="<?= $comment['id'] ?>"
                                                        data-idProduct="<?= $comment['idProduct'] ?>">Delete</a></li>
                                                <?php endif; ?>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <?php endforeach; ?>
                            <?php endif; ?>
                        </div>

                        <!-- <div class="text-center mt-4">
                            <a href="#" class="btn btn-primary">Xem tất cả đánh giá</a>
                        </div> -->
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal HTML -->
    <div id="updateCommentModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h3 class="fw-bold text-dark">Cập nhật bình luận</h3><br>
            <form id="update-comment-form" action="/comments/editCommentUser" method="POST"
                enctype="multipart/form-data">
                <input type="hidden" name="commentId" id="commentId">
                <input type="hidden" name="idProduct" id="idProduct">
                <!-- Phần đánh giá sao -->
                <div class="d-flex">
                    <label for="name" class="form-label fw-bold text-dark">Đánh giá</label>
                    <div class="evaluate d-flex mx-3">
                        <input type="hidden" name="update-rating" id="update-selected-star">
                        <button type="button" class="btn d-flex btn-evaluate"
                            style="border-right: 1px solid #ccc; border-radius: 0;" data-star="5">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </button>
                        <button type="button" class="btn d-flex btn-evaluate"
                            style="border-right: 1px solid #ccc; border-radius: 0;" data-star="4">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </button>
                        <button type="button" class="btn d-flex btn-evaluate"
                            style="border-right: 1px solid #ccc; border-radius: 0;" data-star="3">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </button>
                        <button type="button" class="btn d-flex btn-evaluate"
                            style="border-right: 1px solid #ccc; border-radius: 0;" data-star="2">
                            <i class="fa-solid fa-star"></i>
                            <i class="fa-solid fa-star"></i>
                        </button>
                        <button type="button" class="btn d-flex btn-evaluate" data-star="1">
                            <i class="fa-solid fa-star"></i>
                        </button>
                    </div>
                </div>
                <span id="variant-error"></span><br>
                <label for="update-content" class="form-label fw-bold text-dark">Bình luận</label><br>
                <textarea class="form-control" id="update-content" name="content" placeholder="Nhập bình luận ..."
                    required></textarea><br>
                <label for="update-images" class="form-label fw-bold text-dark">Hình ảnh</label><br>
                <input type="file" id="update-images" name="images[]" class="form-control w-50" multiple><br>
                <button class="btn btn-primary btn-update" type="submit">Cập nhật</button>
            </form>
        </div>
    </div>


</section>

<style>
.selected {
    background-color: #007bff !important;
    color: white !important;
    border: 2px solid #0056b3 !important;
}

.evaluate button.btn-evaluate:hover {
    color: rgb(177, 1, 1) !important;
}

.evaluate button.btn-evaluate.active {
    color: rgb(177, 1, 1) !important;
    border: none;
}

.addComment {
    background-color: rgb(194, 194, 194) !important;
    color: white !important;
}

.modal {
    display: none;
    position: fixed;
    z-index: 1;

    width: 100%;
    height: 100%;
    overflow: auto;
    background-color: rgb(36, 36, 36);
    background-color: rgba(34, 34, 34, 0.4);
}

.modal-content {
    background-color: rgb(211, 211, 211);
    margin: 15% auto;
    padding: 20px;
    border: 1px solid #888;
    width: 80%;
}

.close {
    color: #aaa;
    float: right;
    font-size: 28px;
    font-weight: bold;
}

.close:hover,
.close:focus {
    color: black;
    text-decoration: none;
    cursor: pointer;
}

.btn-like i.fa-solid {
    color: rgb(20, 141, 255);
    /* Màu đỏ khi đã like */
}

.btn-like i.fa-regular {
    color: #ffffff;
    /* Màu trắng khi chưa like */
}
</style>

<script>
//variants
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

//comment
document.addEventListener('DOMContentLoaded', function() {
    const filterRatings = document.querySelectorAll('.filter-rating');
    const reviews = document.querySelectorAll('.review');

    filterRatings.forEach(filter => {
        filter.addEventListener('click', function() {
            const rating = parseInt(this.getAttribute('data-rating'));

            reviews.forEach(review => {
                const reviewRating = review.querySelectorAll(
                    '.text-danger i.fa-solid.fa-star').length;
                if (rating === reviewRating || isNaN(rating)) {
                    review.style.display = 'block';
                } else {
                    review.style.display = 'none';
                }
            });
        });
    });

    const viewAllReviews = document.querySelector('.text-center a');
    if (viewAllReviews) {
        viewAllReviews.addEventListener('click', function(event) {
            event.preventDefault();
            reviews.forEach(review => {
                review.style.display = 'block';
            });
        });
    }
});

function deleteComment(element) {
    var id = element.getAttribute('data-id');
    var idProduct = element.getAttribute('data-idProduct');
    if (confirm("Bạn có chắc chắn muốn xóa?")) {
        window.location.href = "/comments/deleteComment/" + id + "/" + idProduct;
    }
}

//them binh luan
document.addEventListener('DOMContentLoaded', () => {
    const buttonsAddComment = document.querySelectorAll('.btn-evaluate');
    const formComment = document.getElementById('comment-form');

    // Thêm sự kiện khi chọn đánh giá sao
    buttonsAddComment.forEach(button => {
        button.addEventListener('click', () => {
            const evaluate = button.getAttribute('data-star');
            document.getElementById('selected-star').value = evaluate;

            // Xóa class active của tất cả các nút và thêm vào nút được chọn
            buttonsAddComment.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');

            button.focus();
        });
    });

    // Thêm sự kiện kiểm tra khi form được submit
    formComment.addEventListener('submit', function(event) {
        const evaluate = document.getElementById('selected-star').value;
        if (!evaluate) {
            event.preventDefault(); // Ngăn form gửi đi
            document.getElementById('variant-error').textContent =
                'Vui lòng chọn giá trị đánh giá sao.';
        }
    });
});

//update commetn
document.addEventListener("DOMContentLoaded", function() {
    const updateButtons = document.querySelectorAll(".btn-edit");
    const updateModal = document.getElementById("updateCommentModal");
    const productIdInput = document.getElementById("idProduct");
    const commentIdInput = document.getElementById("commentId");
    const contentInput = document.getElementById("update-content");
    const ratingInput = document.getElementById("update-selected-star");
    const buttonsEvaluate = document.querySelectorAll(".btn-evaluate");
    const formComment = document.getElementById("update-comment-form");
    const errorRating = document.getElementById("variant-error");
    const closeModalButton = document.querySelector(".close");

    updateButtons.forEach(button => {
        button.addEventListener("click", function() {
            const productId = this.getAttribute("data-idProduct");
            const commentId = this.getAttribute("data-comment-id");
            const content = this.getAttribute("data-content");
            const rating = this.getAttribute("data-rating") || "0"; // Giá trị mặc định

            productIdInput.value = productId;
            commentIdInput.value = commentId;
            contentInput.value = content;
            ratingInput.value = rating;

            buttonsEvaluate.forEach(btn => {
                btn.classList.remove("active");
                if (btn.getAttribute("data-star") === rating) {
                    btn.classList.add("active");
                }
            });

            updateModal.style.display = "block";
        });
    });

    closeModalButton.addEventListener("click", function() {
        updateModal.style.display = "none";
    });

    buttonsEvaluate.forEach(button => {
        button.addEventListener('click', () => {
            const evaluate = button.getAttribute('data-star');
            ratingInput.value = evaluate;

            buttonsEvaluate.forEach(btn => btn.classList.remove("active"));
            button.classList.add("active");
            button.focus();
        });
    });

    formComment.addEventListener("submit", function(event) {
        const evaluate = ratingInput.value;
        console.log("Rating trước khi gửi:", evaluate); // Kiểm tra giá trị
        if (!evaluate) {
            event.preventDefault();
            errorRating.textContent = "Vui lòng chọn số sao.";
            errorRating.style.color = "red";
        } else {
            errorRating.textContent = "";
        }
    });
});

//like comment
document.addEventListener("DOMContentLoaded", function() {
    document.querySelectorAll(".btn-like").forEach(button => {
        const commentId = button.getAttribute("data-comment-id");
        const likeCountElement = button.querySelector(".like-count");
        const iconElement = button.querySelector("i");

        // Lấy số lượng like ban đầu từ server và cập nhật biểu tượng like
        fetch(`/comments/getLikeCount/${commentId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (likeCountElement) {
                        likeCountElement.textContent = data.likes;
                    }
                    fetch(`/comments/checkLike/${commentId}`)
                        .then(response => response.json())
                        .then(checkData => {
                            if (checkData.liked) {
                                if (iconElement) {
                                    iconElement.classList.remove("fa-regular");
                                    iconElement.classList.add("fa-solid");
                                }
                            } else {
                                if (iconElement) {
                                    iconElement.classList.remove("fa-solid");
                                    iconElement.classList.add("fa-regular");
                                }
                            }
                        })
                        .catch(error => {
                            console.error("Error checking like status:", error);
                        });
                } else {
                    console.error("Failed to get initial like count:", data.message);
                }
            })
            .catch(error => {
                console.error("Error getting initial like count:", error);
            });

        button.addEventListener("click", function() {
            fetch("/comments/toggleLikeComment", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json"
                },
                body: JSON.stringify({
                    commentId: commentId
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    if (likeCountElement) {
                        likeCountElement.textContent = data.likes;
                    }
                    if (iconElement) {
                        if (data.liked) {
                            iconElement.classList.remove("fa-regular");
                            iconElement.classList.add("fa-solid");
                        } else {
                            iconElement.classList.remove("fa-solid");
                            iconElement.classList.add("fa-regular");
                        }
                    }
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error("Error:", error);
            });
        });
    });
});
</script>