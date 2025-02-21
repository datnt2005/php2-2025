<div id="shop">
    <div class="container">
        <div class="row">
            <div class="col-md-3">
                <aside class="sidebar">
                    <div class="sidebar-product-general pt-4">
                        <ul class="heading px-0">
                            <li class=" list-unstyled fw-bold text-success fs-4">DANH MỤC SẢN PHẨM</li>
                        </ul>
                        <ul class="category-list px-0">
                            <!-- Danh mục cha -->
                            <?php foreach ($categories as $category) : ?>
                            <li class="category-item mt-2 px-0 list-unstyled ">
                                <a class="fw-bold fs-5 text-uppercase text-decoration-none text-dark   ">
                                    <?= $category['name'] ?>
                                </a>
                                <!-- Hiển thị danh mục con -->

                            </li>
                            <?php endforeach; ?>
                        </ul>
                        <ul class="mt-4 px-0 list-unstyled search-price ">
                            <li class="price-item mt-3 ">
                                <a href="#" class="fw-bold fs-5 text-uppercase">Giá</a>
                            </li>
                            <li class="searchPrice-item mt-3 price"><a
                                    href="../client/shop.php?min_price=0&amp;max_price=5000000">0k
                                    - 100k</a></li>
                            <li class="searchPrice-item mt-3 price"><a
                                    href="../client/shop.php?min_price=5000000&amp;max_price=10000000">100k
                                    - 200k</a></li>
                            <li class="searchPrice-item mt-3 price"><a
                                    href="../client/shop.php?min_price=10000000&amp;max_price=15000000">200k
                                    - 300k</a></li>
                            <li class="searchPrice-item mt-3 price"><a
                                    href="../client/shop.php?min_price=15000000&amp;max_price=20000000">300k
                                    - 400k</a></li>
                            <li class="searchPrice-item mt-3 price"><a
                                    href="../client/shop.php?min_price=20000000&amp;max_price=30000000">400k
                                    - 500k</a></li>
                            <li class="searchPrice-item mt-3 price"><a
                                    href="../client/shop.php?min_price=30000000&amp;max_price=40000000">500k
                                    - 1000k</a></li>
                        </ul>
                    </div>
                </aside>
            </div>

             <div class="col-md-9">
                    <div class="row">
                        <?php foreach ($products as $product) : ?>
                        <div class="col-md-4 mb-3" >
                            <a href="products/<?= $product['productId'] ?>" class="text-decoration-none">
                                <div class="product-items border p-2">
                                    <img class="w-100 main-image" height="250"
                                        src="http://localhost:8000/<?= $product['productImage'] ?>" alt="Product Image" />
                                    <div class="mt-2 text-center">
                                        <span class="text-dark fw-bold fs-5"><?= $product['productName'] ?></span>
                                    </div>
                                    <ul>
                                        <li class="fs-6 fw-bold text-danger list-unstyled text-center" >
                                            <?= number_format($product['productPrice']); ?> VNĐ
                                        </li>
                                    </ul>
                                </div>
                            </a>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
    </div>
</div>
