<div class="banner">
    <div class="banner-1 text-center pt-3">
        <div class="banner-text">
            <h4 class="text-info">iPhone 15</h4>
            <h1 class="text-white">iPhone 15 Pro</h1>
            <h5 class="text-white">Nguyên seal - Chưa Active - Bảo
                hành chĩnh hãng</h5>
        </div>
        <div class="banner-image">
            <img src="./public/images/banner.png" width="500" alt="image">
        </div>
    </div>
    <div class="banner-2 text-center bg-dark">
        <ul class="d-flex justify-content-between align-items-center container ">
            <li class="nav-link mx-2">
                <i class="fa-solid fa-globe text-white"></i>
                <p class="text-white">Đa dạng sản phẩm</p>
            </li>
            <li class="nav-link mx-2">
                <i class="fa-solid fa-truck-fast text-white"></i>
                <p class="text-white">Giao hàng toàn quốc</p>
            </li>
            <li class="nav-link mx-2">
                <i class="fa-solid fa-shield-heart text-white"></i>
                <p class="text-white">Bảo hành toàn diện</p>
            </li>
            <li class="nav-link mx-2">
                <i class="fa-solid fa-credit-card text-white"></i>
                <p class="text-white">Trả góp bằng Visa, Thẻ tín
                    dụng</p>
            </li>
        </ul>
    </div>
</div>
<div id="shop">
    <div class="container">
        <div class="row">
            <main class="col-md-12">
                <div class="container py-3">
                    <div class="row mt-5">
                        <h3 class="fw-bold text-center text-white">iPhone</h3>
                        <?php foreach ($products as $product) : ?>
                        <div class="col-md-3 text-center position-relative mt-4">
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