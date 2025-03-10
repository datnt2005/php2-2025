<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link rel="stylesheet" href="/public/css/style_admin.css">
    <script src="https://kit.fontawesome.com/1d3d4a43fd.js" crossorigin="anonymous"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script type="text/javascript" src="vendor/jquery/jquery.min.js"></script>
    <script type="text/javascript" src="vendor/chart.js/Chart.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>

<body>

    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper" class="bg-dark px-3">
            <ul class="sidebar-nav mt-3 mb-5">
                <li class="sidebar-brand d-flex align-items-center px-5">
                    <div class="logo_sidebar">
                        <a href="/admin">
                            <img src="/public/images/logo.webp" width="60" alt="logo">
                        </a>
                    </div>
                </li>
                <li class="sidebar-nav-item mt-4">
                    <a href="/admin" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-tachometer-alt me-2"></i> Dashboard
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/categories" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-th-list me-2"></i> Categories
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/categories"
                        class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-th me-2"></i> Category Products
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/products" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-boxes me-2"></i> Products
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/order" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-shopping-cart me-2"></i> Orders
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/users" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-users me-2"></i> Users
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/comments" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-comments me-2"></i> Comments
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/discounts" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-tags me-2"></i> Coupons
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/banners" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-image me-2"></i> Banners
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/stores" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-store me-2"></i> Stores
                    </a>
                </li>
                <li class="sidebar-nav-item">
                    <a href="/settings" class="text-white text-decoration-none d-flex align-items-center">
                        <i class="fas fa-cogs me-2"></i> Settings
                    </a>
                </li>
            </ul>
        </div>

        <div id="content">

            <nav class="navbar">
                <div class="search-nav mx-5">
                    <form action>
                        <input type="search" name="search" id="search" placeholder="Search...">
                        <button>
                            <i class="fa-solid fa-search"></i>
                        </button>
                    </form>
                </div>
                <ul class="navbar-nav ml-auto">
                    <!-- Nav Item - User Information -->
                    <li class="nav-item  no-arrow d-flex align-items-center mr-3">
                        <a class="nav-link" href="#" id="user" aria-haspopup="true" aria-expanded="false">
                            <span
                                class="mr-2 d-none d-lg-inline text-gray-600 small "><?php echo $_SESSION['user']['name']; ?></span>
                            <i class="fa-regular fa-envelope text-gray-400 fs-5 mr-2 mx-2"></i>
                        </a>
                        <!-- Dropdown - User Information -->
                        <div class="logout">
                            <a class="nav-link" href="/" data-toggle="modal"
                                data-target="#logoutModal">
                                <i class="fas fa-sign-out-alt fa-sm fa-fw fs-5 mr-2 text-gray-400"></i>
                            </a>
                        </div>
                    </li>
                </ul>
            </nav>
            <?php
        if (!empty($_SESSION['success'])) : ?>
        <div class="alert alert-success text-center" role="alert">
            <?= $_SESSION['success'] ?>
        </div>
        <?php unset($_SESSION['success']); ?>
        <?php endif; ?>

        <?php
        if (!empty($_SESSION['error'])) : ?>
        <div class="alert alert-danger text-center" role="alert">
            <?= $_SESSION['error'] ?>
        </div>
        <?php unset($_SESSION['error']); ?>
        <?php endif; ?>

            <!-- content main-->
            <?php echo $content; ?>
        </div>
    </div>
    <script src="/public/js/script.js"></script>
</body>

</html>