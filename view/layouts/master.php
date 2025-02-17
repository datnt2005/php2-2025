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
            <div class="auth">
                <?php if (isset($_SESSION['user'])) : ?>
                    <span class="text-white me-3">Hi bro!</span>
                    <a href="/logout" class="text-white text-decoration-none fw-bold">Logout</a>
                <?php else : ?>
                    <a href="/login" class="text-white text-decoration-none fw-bold ">Login </a>/
                    <a href="/register" class=" text-white text-decoration-none fw-bold">Register</a>
                <?php endif; ?>
            </div>
            </div>
        </div>

    </header>

    <main class="container my-4">
        
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