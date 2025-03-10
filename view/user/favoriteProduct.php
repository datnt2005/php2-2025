<div id="shop">
    <div class="container py-5">
        <div class="row">
            <?php if(!empty($favoriteItems)): ?>
            <?php foreach ($favoriteItems as $favoriteItem) : ?>
            <div class="col-md-3 mt-3 text-center position-relative">
                <a class="text-decoration-none" href="/products/<?= $favoriteItem['productId'] ?>">
                    <div class="product-items">
                        <div class="favorite-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="lucide lucide-heart favorite-btn <?= in_array($favoriteItem['productId'], $favoriteProductIds) ? 'favorite' : '' ?>"
                                data-id="<?= $favoriteItem['productId'] ?>" id="favorite-<?= $favoriteItem['productId'] ?>">
                                <path
                                    d="M12 21.593c-5.63-5.539-11-10.297-11-14.402 0-3.791 3.068-5.191 5.281-5.191 1.312 0 4.151.501 5.719 4.457 1.59-3.968 4.464-4.447 5.726-4.447 2.54 0 5.274 1.621 5.274 5.181 0 4.069-5.136 8.625-11 14.402m5.726-20.583c-2.203 0-4.446 1.042-5.726 3.238-1.285-2.206-3.522-3.248-5.719-3.248-3.183 0-6.281 2.187-6.281 6.191 0 4.661 5.571 9.429 12 15.809 6.43-6.38 12-11.148 12-15.809 0-4.011-3.095-6.181-6.274-6.181" />
                            </svg>
                        </div>

                        <div class="image-product">
                            <img class="w-100" src="http://localhost:8000/<?= $favoriteItem['productImage'] ?>" alt>
                        </div>
                        <div class="name-price text-center p-3">
                            <span class="text-white"><?= $favoriteItem['productName'] ?></span>
                            <p class="text-info fs-5">
                                <?= number_format($favoriteItem['productPrice']); ?>đ
                            </p>
                        </div>
                    </div>
                </a>
            </div>

            <?php endforeach; ?>
            <?php else: ?>
                <span class="text-white text-center">Không có sản phẩm nào trong danh sách yêu thích!</span>
            <?php endif; ?>
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
                body: JSON.stringify({
                    productId
                })
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
                alert('Có lỗi xảy ra!');
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
    outline: none;
    /* Bỏ viền focus mặc định */
}
</style>