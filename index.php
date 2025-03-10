<?php
session_start();
require_once __DIR__ . '/vendor/autoload.php';
require_once "controller/ProductController.php";
require_once "controller/CategoryController.php";
require_once "controller/UserController.php";
require_once "controller/SizeController.php";
require_once "controller/ColorController.php";
require_once "controller/CartController.php";
require_once "controller/OrderController.php";
require_once "controller/DiscountController.php";
require_once "controller/BannerController.php";
require_once "controller/StoreController.php";
require_once "controller/LocationController.php";
require_once "controller/FavoriteController.php";
require_once "controller/CommentController.php";



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
$discountController = new DiscountController();
$bannerController = new BannerController();
$storeController = new StoreController();
$locationController = new LocationController();
$favoriteController = new FavoriteController();
$commentController = new CommentController();

$router->addMiddleware('logRequest');

$router->addRoute("/", [$productController, "home"]);

$router->addRoute("/products", [$productController, "index"],['isAdmin']);
$router->addRoute("/products/create", [$productController, "create"],['isAdmin']);
$router->addRoute("/products/{id}", [$productController, "show"]);
$router->addRoute("/product-variants/{id}", [$productController, "listVariant"],['isAdmin']);
$router->addRoute("/products/edit/{id}", [$productController, "edit"],['isAdmin']);
$router->addRoute("/products/delete/{id}", [$productController, "delete"],['isAdmin']);

$router->addRoute("/categories", [$categoryController, "index"],['isAdmin']);
$router->addRoute("/categories/create", [$categoryController, "create"],['isAdmin']);
$router->addRoute("/categories/edit/{id}", [$categoryController, "edit"],['isAdmin']);
$router->addRoute("/categories/delete/{id}", [$categoryController, "delete"],['isAdmin']);

$router->addRoute("/users", [$userController, "index"],['isAdmin']);
$router->addRoute("/users/create", [$userController, "create"],['isAdmin']);
$router->addRoute("/account", [$userController, "updateAccount"],['isUser']);
$router->addRoute("/users/edit/{id}", [$userController, "edit"],['isAdmin']);
$router->addRoute("/users/delete/{id}", [$userController, "delete"],['isAdmin']);
$router->addRoute("/users/updateAccount", [$userController,"updateAccount"],['isUser']);
$router->addRoute("/users/updateAccountPassword", [$userController,"updateAccountPassword"],['isUser']);

$router->addRoute("/login", [$userController, "login"]);
$router->addRoute("/register", [$userController, "register"]);
$router->addRoute("/logout", [$userController, "logout"]);
$router->addRoute("/forgotPassword", [$userController, "forgotPassword"]);
$router->addRoute("/resetPassword", [$userController, "resetPassword"]);
$router->addRoute('/google/login', [$userController, 'googleLogin']);
$router->addRoute('/google/callback', [$userController, 'googleCallback']);

$router->addRoute('/sizes', [$sizeController, 'index'],['isAdmin']);
$router->addRoute('/sizes/create', [$sizeController, 'create'],['isAdmin']);
$router->addRoute('/sizes/edit/{id}', [$sizeController, 'edit'],['isAdmin']);
$router->addRoute('/sizes/delete/{id}', [$sizeController, 'delete'],['isAdmin']);

$router->addRoute('/colors', [$colorController, 'index'],['isAdmin']);
$router->addRoute('/colors/create', [$colorController, 'create'],['isAdmin']);
$router->addRoute('/colors/edit/{id}', [$colorController, 'edit'],['isAdmin']);
$router->addRoute('/colors/delete/{id}', [$colorController, 'delete'],['isAdmin']);

$router->addRoute("/shop", [$productController, "shop"]);
$router->addRoute("/filterProduct", [$productController, "filterProduct"]);
$router->addRoute("/cart", [$cartController, "index"]);
$router->addRoute("/cart/create", [$cartController,"create"]);
$router->addRoute("/cart/delete/{idCartItem}", [$cartController,"deleteCartItem"],['isUser']);
$router->addRoute("/cart/update", [$cartController, "updateCartItem"],['isUser']);

$router->addRoute("/order", [$orderController, "index"],['isAdmin']);
$router->addRoute("/checkout", [$orderController,"showCheckout"],['isUser']);
$router->addRoute("/order/{id}", [$orderController,"showOrderItem"],['isAdmin']);
$router->addRoute("/orders/create", [$orderController,"create"],['isUser']);
$router->addRoute("/order/edit/{id}", [$orderController,"statusUpdate"],['isAdmin']);
$router->addRoute("/order/delete/{id}", [$orderController,"delete"],['isAdmin']);
$router->addRoute("/payment/vnpay_payment", [$orderController, "vnpay_payment"],['isUser']);
$router->addRoute("/payment/vnpay/return", [$orderController, "vnpay_return"],['isUser']);
$router->addRoute("/payment/vnpay/cancel", [$orderController, "vnpayCancel"],['isUser']);
$router->addRoute("/myOrder", [$orderController,"getOrdersBuyed"],['isUser']);
$router->addRoute("/myOrderItem/{idOrder}", [$orderController,"getOrderItemsBuyed"],['isUser']);
$router->addRoute("/trackOrder", [$orderController,"trackOrder"]);
$router->addRoute("/cancelOrder/{id}", [$orderController,"cancelOrder"],['isUser']);
$router->addRoute("/buyAgain/{id}", [$orderController,"buyAgain"],['isUser']);
$router->addRoute('/applyDiscount', [$orderController,'checkDiscount'],['isUser']);
$router->addRoute('/cancelDiscount', [$orderController,'cancelDiscount'],['isUser']);

$router->addRoute('/discounts', [$discountController,'index'],['isAdmin']);
$router->addRoute('/discounts/create', [$discountController,'create'],['isAdmin']);
$router->addRoute('/discounts/{id}', [$discountController,'edit'],['isAdmin']);
$router->addRoute('/discounts/delete/{id}', [$discountController,'delete'],['isAdmin']);

$router->addRoute('/banners', [$bannerController,'index'],['isAdmin']);
$router->addRoute('/banners/create', [$bannerController,'create'],['isAdmin']);
$router->addRoute('/banners/{id}', [$bannerController,'edit'],['isAdmin']);
$router->addRoute('/banners/delete/{id}', [$bannerController,'delete'],['isAdmin']);

$router->addRoute('/stores', [$storeController, 'index'],['isAdmin']);
$router->addRoute('/stores/create', [$storeController, 'create'],['isAdmin']);
// $router->addRoute('/stores/{id}', [$storeController, 'show'],['isAdmin']);
$router->addRoute('/stores/edit/{id}', [$storeController, 'edit'],['isAdmin']);
$router->addRoute('/stores/delete/{id}', [$storeController, 'delete'],['isAdmin']);
$router->addRoute('/stores/showStore', [$storeController,'showStore'],['isUser']);

$router->addRoute('/location/provinces', [$locationController, 'getProvinces'], ['isAdmin']);
$router->addRoute('/location/districts/{province_id}', [$locationController, 'getDistricts'], ['isAdmin']);
$router->addRoute('/location/wards/{district_id}', [$locationController, 'getWards'], ['isAdmin']);


$router->addRoute('/favorites', [$favoriteController, 'index'], ['isUser']);
$router->addRoute('/favorites/create/{idProduct}', [$favoriteController,'create'], ['isUser']);
$router->addRoute('/favorites/delete/{idFavorite}', [$favoriteController,'deleteFavorite'], ['isUser']);


$router->addRoute('/admin', [$orderController,'revenue'],['isAdmin']);

$router->addRoute('/comments', [$commentController,'index'], ['isAdmin']);
$router->addRoute('/comments/create', [$commentController,'create'], ['isAdmin']);
$router->addRoute('/comments/edit/{id}', [$commentController,'edit'], ['isAdmin']);
$router->addRoute('/comments/delete/{id}', [$commentController,'delete'], ['isAdmin']);
$router->addRoute('/comments/deleteComment/{id}/{idProduct}', [$commentController,'removeComment'], ['isUser']);
$router->addRoute('/comments/delete_pic_comment/{idComment}/{idCommentMedia}', [$commentController,'deletePicComment'], ['isAdmin']);
$router->addRoute('/comments/addCommentUser/{idProduct}', [$commentController,'addCommentUser'], ['isUser']);
$router->addRoute('/comments/editCommentUser', [$commentController,'updateCommentUser'], ['isUser']);
$router->addRoute('/comments/toggleLikeComment', [$commentController,'toggleLikeComment'], ['isUser']);
$router->addRoute('/comments/getLikeCount/{commentId}', [$commentController,'getLikeCount'], ['isUser']);
$router->addRoute('/comments/checkLike/{commentId}', [$commentController,'checkLike'], ['isUser']);

$router->addRoute('/products/{idProduct}', [$commentController,'getCommentByProduct'], ['isUser']);
$router->dispatch();
?>