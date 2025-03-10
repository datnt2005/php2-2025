<div id="shop">
    <div class="container">
        <div class="row">
            <aside class="col-md-3">
                <div class="sidebar">
                    <div class="sidebar-product-general pt-5">
                        <form action="/filterProduct" method="GET">
                            <input type="text" name="search" class="form-control mb-3"
                                placeholder="Tìm kiếm sản phẩm..." value="<?= $_GET['search'] ?? '' ?>">

                            <select name="sort" class="form-select mb-3">
                                <option value="">Sắp xếp theo</option>
                                <option value="price_asc">Giá tăng dần</option>
                                <option value="price_desc">Giá giảm dần</option>
                                <option value="name_asc">Tên A-Z</option>
                                <option value="name_desc">Tên Z-A</option>
                            </select>

                            <ul>
                                <li class="category-item fw-bold fs-6 text-info">DANH MỤC SẢN PHẨM</li>
                            </ul>
                            <?php foreach ($categories as $category) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="category[]"
                                    value="<?= $category['id']; ?>">
                                <label class="form-check-label"><?= $category['name']; ?></label>
                            </div>
                            <?php endforeach; ?>

                            <ul class="mt-4">
                                <li class="category-item fw-bold fs-6 text-info">GIÁ</li>
                            </ul>
                            <select name="price_range" class="form-select">
                                <option value="">Chọn khoảng giá</option>
                                <option value="0-5000000">0₫ - 5tr₫</option>
                                <option value="5000000-10000000">5tr₫ - 10tr₫</option>
                                <option value="10000000-15000000">10tr₫ - 15tr₫</option>
                                <option value="15000000-20000000">15tr₫ - 20tr₫</option>
                                <option value="20000000-30000000">20tr₫ - 30tr₫</option>
                            </select>

                            <ul class="mt-4">
                                <li class="category-item fw-bold fs-6 text-info">MÀU SẮC</li>
                            </ul>
                            <?php foreach ($colors as $color) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="color[]"
                                    value="<?= $color['idColor']; ?>">
                                <label class="form-check-label"><?= $color['nameColor']; ?></label>
                            </div>
                            <?php endforeach; ?>

                            <ul class="mt-4">
                                <li class="category-item fw-bold fs-6 text-info">KÍCH THƯỚC</li>
                            </ul>
                            <?php foreach ($sizes as $size) : ?>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="size[]"
                                    value="<?= $size['idSize']; ?>">
                                <label class="form-check-label"><?= $size['nameSize']; ?></label>
                            </div>
                            <?php endforeach; ?>

                            <button type="submit" class="btn btn-primary mt-3 w-100">Tìm kiếm</button>
                        </form>
                    </div>
                </div>
            </aside>

            <main class="col-md-9">
                <div class="container">
                    <div id="productCarousel" class="carousel slide mt-5 mx-5" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            <?php $isFirst = true; ?>
                            <?php foreach ($banners as $banner) : ?>
                            <div class="carousel-item <?= $isFirst ? 'active' : '' ?>">
                                <img width="100%" height="300px"
                                    src="http://localhost:8000/<?= htmlspecialchars($banner['image']) ?>"
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
                    <div class="row mt-5">
                        <?php foreach ($products as $product) : ?>
                        <div class="col-md-3 text-center position-relative">
                            <a class="text-decoration-none" href="/products/<?= $product['productId'] ?>">
                                <div class="product-items">
                                    <div class="favorite-icon">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1"
                                            stroke-linecap="round" stroke-linejoin="round"
                                            class="lucide lucide-heart favorite-btn <?= in_array($product['productId'], $favoriteProductIds) ? 'favorite' : '' ?>"
                                            data-id="<?= $product['productId'] ?>" id="favorite-<?= $product['productId'] ?>">
                                            <path
                                                d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181" />
                                        </svg>
                                    </div>

                                    <div class="image-product">
                                        <img class="w-100" src="http://localhost:8000/<?= $product['productImage'] ?>"
                                            alt>
                                    </div>
                                    <div class="name-price text-center p-3">
                                        <span class="text-white"><?= $product['productName'] ?></span>
                                        <p class="text-info fs-5">
                                            <?= number_format($product['productPrice']); ?>đ
                                        </p>
                                    </div>
                                </div>
                            </a>
                        </div>

                        <?php endforeach; ?>
                    </div>
                </div>
            </main>
        </div>
    </div>
</div>

<script>
document.querySelectorAll('.favorite-btn').forEach(button => {
    button.addEventListener('click', function(event) {
        event.preventDefault();
        const productId = this.getAttribute('data-id');
        const isFavorite = this.classList.contains('favorite');

        fetch(`/favorites/${isFavorite ? 'delete' : 'create'}/${productId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({ productId })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                this.classList.toggle('favorite');
            } else {
                alert(data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            // alert('Có lỗi xảy ra!');
            console.log('Chưa đăng nhập mà thêm làm sao được :))');
            location.href = '/login';
        });
    });
});

</script>

<style>
.favorite {
    fill: red !important;
    stroke: red !important;
    
}
.favorite-btn:focus {
    fill: red !important;
    stroke: red !important;
    outline: none; /* Bỏ viền focus mặc định */
}

</style>