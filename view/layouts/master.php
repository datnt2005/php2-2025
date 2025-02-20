<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? "My App" ?></title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <header class="bg-dark text-white py-3">
        <div class="container">
            <h1 class="h3">TDAJTSHOP</h1>
            <div class="d-flex justify-content-between">
                <nav>
                    <a href="/" class="text-white me-3">Home</a>
                    <a href="/shop" class="text-white me-3">Shop</a>
                    <a href="/cart" class="text-white me-3">Cart</a>
                    <a href="/order" class="text-white me-3">Order</a>
                    <a href="/products" class="text-white me-3">Products</a>
                    <a href="/categories" class="me-3 text-white">Categories</a>
                    <a href="/users" class="me-3 text-white">Users</a>
                    <a href="/sizes" class="me-3 text-white">Sizes</a>
                    <a href="/colors" class="me-3 text-white">Colors</a>


                </nav>
                <div class="auth d-flex">
                    <?php if (isset($_SESSION['user'])) : ?>
                        <span class="text-white me-4">Hi <?= $_SESSION['user']['name'] ?>!</span>
                    <div class="dropdown">
                        <a href="#" class="dropdown-toggle" role="button" id="dropdownMenuLink"
                            data-bs-toggle="dropdown" aria-expanded="false"><img
                                src="http://localhost:8000/<?= $_SESSION['user']['avatar']; ?>" alt="" width="40"
                                height="40" class="border-0 rounded-circle"></a>
                        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="dropdownMenuLink">
                            <li><a class="dropdown-item" href="/account">Profile</a></li>
                            <li><a class="dropdown-item" href="/myOrder">Order</a></li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li><a class="dropdown-item text-danger" href="/logout">Logout</a></li>
                        </ul>

                </div>
                <?php else : ?>
                <a href="/login" class="text-white text-decoration-none fw-bold ">Login </a>/
                <a href="/register" class=" text-white text-decoration-none fw-bold">Register</a>
                <?php endif; ?>
            </div>
        </div>
        </div>

    </header>

    <main class="container my-4">
        <!-- thong bao -->
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



        <?php
         echo $content;
        ?>
    </main>
    <footer class="bg-dark text-white py-3 mt-4">
        <div class="container">
            <p class="mb-0">&copy; <?= date("Y") ?> My App</p>
        </div>
    </footer>
    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>