<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TdajtShop</title>
    <link rel="stylesheet" href="/public/css/style.css">
    <script src="https://kit.fontawesome.com/1d3d4a43fd.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body>

    <header class="header ">
        <nav class="container navbar navbar-expand-lg ">
            <div class="container-fluid">
                <a class="navbar-brand text-white" href="/">
                    <img src="/public/images/logo.webp" class="logo mx-3" alt="image">
                </a>
                <button class="navbar-toggler " type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon bg-white"></span>
                </button>
                <div class="collapse navbar-collapse justify-content-center w-300  " id="navbarNav">
                    <nav>
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/shop">
                                    iPhone
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/shop">
                                    iPad
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/shop">
                                    Macbook
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/shop">
                                    Watch
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/shop">
                                    Âm thanh
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/shop">
                                    Phụ kiện
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link text-white" aria-current="page" href="/stores/showStore">
                                    Stores
                                </a>
                            </li>
                        </ul>


                    </nav>
                </div>
                <div class="header-search">
                    <form action="/filterProduct" method="GET">
                        <input type="search" name="search" id="search" placeholder="Bạn tìm sản phẩm gì...">
                        <button type="submit">
                            <i class="fa-solid fa-search text-white"></i>
                        </button>
                    </form>
                </div>
                <div class="header-cart mt-3">
                    <ul class="d-flex ">
                        <li class="nav-link mx-2">
                            <a class="text-white " href="/favorites">
                                <svg class="lucide lucide-heart" stroke-linejoin="round" stroke-linecap="round"
                                    stroke-width="1" stroke="currentColor" fill="none" viewBox="0 0 24 24" height="30"
                                    width="30" xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M20.84 4.61a5.5 5.5 0 0 0-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 1 0-7.78 7.78l1.06 1.06L12 21.35l7.78-7.78 1.06-1.06a5.5 5.5 0 0 0 0-7.78Z">
                                    </path>
                                </svg>
                            </a>
                        </li>
                        <li class="nav-link mx-2">
                            <a class="text-white" href="/cart">
                                <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24"
                                    fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                    stroke-linejoin="round" class="lucide lucide-shopping-bag">
                                    <path d="M6 2 3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4Z" />
                                    <path d="M3 6h18" />
                                    <path d="M16 10a4 4 0 0 1-8 0" />
                                </svg>

                            </a>
                        </li>
                        <li class="nav-link mx-2">
                            <div class="auth d-flex">
                                <?php if (isset($_SESSION['user'])) : ?>
                                <div class="dropdown">
                                    <button class="btn p-0 border-0 dropdown-toggle" type="button" id="userDropdown"
                                        data-bs-toggle="dropdown" aria-expanded="false"
                                        style="background-color: transparent;">
                                        <img style="width: 35px; height: 35px; border-radius: 50%;"
                                            src="http://localhost:8000/<?php echo $_SESSION['user']['avatar']; ?>"
                                            alt="Avatar">
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end mt-1" aria-labelledby="userDropdown">
                                        <?php if($_SESSION['user']['role'] === 'admin') : ?>
                                        <li>
                                            <a class="dropdown-item" href="/admin">
                                                <i class="fa-solid fa-gear mx-1"></i>
                                                Quản trị
                                            </a>
                                        </li>
                                        <?php endif; ?>
                                        <li>
                                            <a class="dropdown-item" href="/account">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                    viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                    stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                                                    class="lucide lucide-user-round">
                                                    <circle cx="12" cy="8" r="5" />
                                                    <path d="M20 21a8 8 0 0 0-16 0" />
                                                </svg>
                                                Thông tin tài khoản
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="/myOrder">
                                                <i class="fa-solid fa-clipboard-list mx-1"></i>
                                                Đơn mua
                                            </a>
                                        </li>
                                        <li>
                                            <a class="dropdown-item" href="javascript:void(0);" onclick="logout()">
                                                <i class="fa-solid fa-right-from-bracket mx-1"></i>
                                                Đăng xuất
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                                <?php else : ?>
                                <a href="/login" class="text-white">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24"
                                        fill="none" stroke="currentColor" stroke-width="1" stroke-linecap="round"
                                        stroke-linejoin="round" class="lucide lucide-user-round">
                                        <circle cx="12" cy="8" r="5" />
                                        <path d="M20 21a8 8 0 0 0-16 0" />
                                    </svg>
                                </a>
                                <?php endif; ?>
                            </div>

                        </li>
                    </ul>
                </div>
            </div>
        </nav>

    </header>

    <main>
        <!-- thong bao -->
        <?php
        if (!empty($_SESSION['success'])) : ?>
        <div class="alert alert-success text-center m-0" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php
        if (!empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger text-center m-0" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>



        <?php
         echo $content;
        ?>
    </main>
    <footer id="footer" class="pt-5 pb-4">
        <div class="footer container">
            <div class="row">
                <div class="col-md-3">
                    <a href="#">
                        <img src="/public/images/logo.webp" width="100px" alt>
                    </a>
                </div>
                <div class="col-md-3">
                    <h4 class="text-info">ĐỊA CHỈ CỬA HÀNG</h4>
                    <p class="text-white">Địa chỉ: 126/77
                        YMoan Enuol, TP.Buôn Ma Thuột, Đắk
                        Lắk.</p>
                    <p class="text-white">Mua hàng:
                        0847701203</p>
                </div>
                <div class="col-md-3">
                    <h4 class="text-info">HỖ TRỢ KHÁCH HÀNG</h4>
                    <ul class="text-white list-unstyled">
                        <li><a href="#">Hướng dẫn mua
                                hàng</a></li>
                        <li><a href="#">Hướng dẫn thanh
                                toán</a></li>
                        <li><a href="#">Chính sách giao
                                hàng</a></li>
                        <li><a href="#">Chính sách đổi trả, hoàn
                                tiền</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h4 class="text-info">THƯƠNG HIỆU</h4>
                    <ul class="text-white list-unstyled">
                        <li><a href="#">Giới thiệu</a></li>
                        <li><a href="#">Thông tin liên
                                hệ</a></li>
                        <li><a href="#">Chính sách bảo mật thông
                                tin</a></li>
                        <li><a href="#">Mua hàng trả góp, thu cũ
                                đổi mới</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </footer>
    <script src="/public/js/script.js"></script>
</body>

</html>
<script>
function logout() {
    if (confirm("Bạn có chắc chắn muốn đăng xuất không?")) {
        window.location.href = "/logout";
    }
}
</script>