<?php
session_start();
require_once "controller/ProductController.php";
require_once "controller/CategoryController.php";
require_once "controller/UserController.php";
require_once "controller/SizeController.php";
require_once "controller/ColorController.php";
require_once "controller/CartController.php";
require_once "controller/OrderController.php";
require_once "router/Router.php";
require_once "middleware.php";

$router = new Router();

$productController = new ProductController();
$categoryController = new CategoryController();
$userController = new UserController();
$sizeController = new SizeController();
$colorController = new ColorController();
$cartController = new CartController();
$orderController = new OrderController();

$router->addMiddleware('logRequest');
$router->addMiddleware(function () { 
    $currentRoute = $_SERVER['REQUEST_URI'];

    // Loại trừ các route không yêu cầu đăng nhập
    $excludedRoutes = ['/login', '/register', '/forgotPassword', '/resetPassword', '/google/login', '/google/callback'];
    foreach ($excludedRoutes as $route) {
        if (strpos($currentRoute, $route) === 0) {
            return true;
        }
    }

    // Áp dụng middleware isUser
    if (!isset($_SESSION['user'])) {
        header("Location: /login");
        exit;
    }
    return true;
});

$router->addRoute("/products", [$productController, "index"]);
$router->addRoute("/products/create", [$productController, "create"]);
$router->addRoute("/products/{id}", [$productController, "show"]);
$router->addRoute("/product-variants/{id}", [$productController, "listVariant"]);
$router->addRoute("/products/edit/{id}", [$productController, "edit"]);
$router->addRoute("/products/delete/{id}", [$productController, "delete"]);

$router->addRoute("/categories", [$categoryController, "index"]);
$router->addRoute("/categories/create", [$categoryController, "create"]);
$router->addRoute("/categories/{id}", [$categoryController, "show"]);
$router->addRoute("/categories/edit/{id}", [$categoryController, "edit"]);
$router->addRoute("/categories/delete/{id}", [$categoryController, "delete"]);

$router->addRoute("/users", [$userController, "index"]);
$router->addRoute("/users/create", [$userController, "create"]);
$router->addRoute("/users/{id}", [$userController, "show"]);
$router->addRoute("/users/edit/{id}", [$userController, "edit"]);
$router->addRoute("/users/delete/{id}", [$userController, "delete"]);

$router->addRoute("/login", [$userController, "login"]);
$router->addRoute("/register", [$userController, "register"]);
$router->addRoute("/logout", [$userController, "logout"]);
$router->addRoute("/forgotPassword", [$userController, "forgotPassword"]);
$router->addRoute("/resetPassword", [$userController, "resetPassword"]);
$router->addRoute('/google/login', [$userController, 'googleLogin']);
$router->addRoute('/google/callback', [$userController, 'googleCallback']);

$router->addRoute('/sizes', [$sizeController, 'index']);
$router->addRoute('/sizes/create', [$sizeController, 'create']);
$router->addRoute('/sizes/{id}', [$sizeController, 'show']);
$router->addRoute('/sizes/edit/{id}', [$sizeController, 'edit']);
$router->addRoute('/sizes/delete/{id}', [$sizeController, 'delete']);

$router->addRoute('/colors', [$colorController, 'index']);
$router->addRoute('/colors/create', [$colorController, 'create']);
$router->addRoute('/colors/{id}', [$colorController, 'show']);
$router->addRoute('/colors/edit/{id}', [$colorController, 'edit']);
$router->addRoute('/colors/delete/{id}', [$colorController, 'delete']);

$router->addRoute("/shop", [$productController, "shop"]);
$router->addRoute("/cart", [$cartController, "index"]);
$router->addRoute("/cart/create", [$cartController,"create"]);
$router->addRoute("/cart/delete/{idCartItem}", [$cartController,"deleteCartItem"]);
$router->addRoute("/cart/update", [$cartController, "updateCartItem"]);

$router->addRoute("/order", [$orderController, "index"]);
$router->addRoute("/checkout", [$orderController,"showCheckout"]);
$router->addRoute("/order/{id}", [$orderController,"showOrderItem"]);
$router->addRoute("/orders/create", [$orderController,"create"]);
$router->addRoute("/order/edit/{id}", [$orderController,"statusUpdate"]);
$router->addRoute("/order/delete/{id}", [$orderController,"delete"]);
$router->addRoute("/payment/vnpay", [$orderController, "vnpayPayment"]);
$router->addRoute("/payment/vnpay/return", [$orderController, "vnpayReturn"]);
$router->addRoute("/payment/vnpay/cancel", [$orderController, "vnpayCancel"]);


$router->dispatch();
?>