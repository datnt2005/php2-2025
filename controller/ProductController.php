<?php
require_once "model/ProductModel.php";
require_once "model/ProductItemModel.php";
require_once "model/PicProductModel.php";
require_once "model/CategoryModel.php";
require_once "model/SizeModel.php";
require_once "model/ColorModel.php";
require_once "model/BannerModel.php";

// require_once ;
require_once "view/helpers.php";

class ProductController {
    private $productModel;
    private $categoryModel;
    private $productItemModel;
    private $picProductModel;
    private $sizeModel;
    private $colorModel;
    private $bannerModel;
    public function __construct() {
        $this->productModel = new ProductModel();
        $this->categoryModel = new CategoryModel();
        $this->productItemModel = new ProductItemModel();
        $this->picProductModel = new PicProductModel();
        $this->sizeModel = new SizeModel();
        $this->colorModel = new ColorModel();
        $this->bannerModel = new BannerModel();
    }

    public function home() {    
        $products = $this->productModel->getAllProducts();
        renderViewUser("view/user/home.php",  compact('products'), "Product List");
    }
    public function index() {
        $products = $this->productModel->getAllProducts();
        renderViewAdmin("view/admin/products/product_list.php",  compact('products'), "Product List");
    }

    public function shop() {
        $products = $this->productModel->getAllProducts();
        $categories = $this->categoryModel->getAllCategories();
        $productItems = $this->productItemModel->getAllProductItems();
        $sizes = $this->sizeModel->getAllSizes();
        $colors = $this->colorModel->getAllColors();
        $relatedProducts = $this->productModel->relativeProduct($categories[0]['id']);
        $banners = $this->bannerModel->getAllBanners();
        renderViewUser("view/user/shop.php",  compact('products', 'categories', 'productItems', 'sizes', 'colors', 'relatedProducts', 'banners'), "Product List");
    }
    public function show($id) {
        $product = $this->productModel->getProductById($id);
        $productItems = $this->productItemModel->getProductItemByIdProduct($id);
        $sizes = $this->sizeModel->getAllSizes();
        $colors = $this->colorModel->getAllColors();
        $picProducts = $this->picProductModel->getPicProductByIdProduct($id);
        $relatedProducts = $this->productModel->relativeProduct($id);
        renderViewUser("view/user/product_detail.php", compact('product', 'productItems', 'sizes', 'colors', 'picProducts', 'relatedProducts'), "Product Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $variants = $_POST['variants']; // Mảng biến thể
            $image = $_FILES['image'];
    
            // Lưu sản phẩm
            $productId = $this->productModel->createProduct($name, $description, $category_id);
    

            
            // Lưu các biến thể
            foreach ($variants as $variant) {
                $idSize = $variant['size'];
                $idColor = $variant['color'];
                $price = $variant['price'];
                $quantityProduct = $variant['quantity'];
                $sku = $variant['sku'];
    
                $this->productItemModel->createProductItem($productId,$quantityProduct,$price, $idColor, $idSize, $sku);
            }
            // Lưu hình anh
            //nếu hình ảnh không có thi không lưu vô dữ liệu
            if (empty($image['tmp_name'][0])) {
                header("Location: /products");
                exit;
            }else{
                foreach ($image['tmp_name'] as $index => $tmpName) {
                $imagePath = "uploads/" . $image['name'][$index];
                move_uploaded_file($tmpName, $imagePath);
                $this->picProductModel->createPicProduct($productId, $imagePath);
            }
            header("Location: /products");
            exit;
            }

        } else {
            $categories = $this->categoryModel->getAllCategories();
            $sizes = $this->sizeModel->getAllSizes();
            $colors = $this->colorModel->getAllColors();
    
            renderViewAdmin("view/admin/products/product_create.php", compact('categories', 'sizes', 'colors'), "Create Product");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Lấy dữ liệu từ form
            $name = $_POST['name'];
            $description = $_POST['description'];
            $category_id = $_POST['category_id'];
            $variants = $_POST['variants']; // Mảng biến thể từ form
            $image = $_FILES['image'];
    
            // Cập nhật thông tin sản phẩm
            $this->productModel->updateProduct($id, $name, $description, $category_id);
    
            // Xóa và thêm lại các biến thể sản phẩm
            $this->productItemModel->deleteProductItemByIdProduct($id); // Xóa biến thể cũ
            foreach ($variants as $variant) {
                $idSize = $variant['size'];
                $idColor = $variant['color'];
                $price = $variant['price'];
                $quantityProduct = $variant['quantity'];
                $sku = $variant['sku'];
    
                $this->productItemModel->createProductItem($id, $quantityProduct, $price, $idColor, $idSize, $sku);
            }
            
            if(!empty($image['tmp_name'][0])){
                // Xóa và cập nhật hình ảnh
            $this->picProductModel->deletePicProductByIdProduct($id); // Xóa ảnh cũ
            foreach ($image['tmp_name'] as $index => $tmpName) {
                if (!empty($tmpName)) {
                    $imagePath = "uploads/" . uniqid() . "_" . $image['name'][$index];
                    move_uploaded_file($tmpName, $imagePath);
                    $this->picProductModel->createPicProduct($id, $imagePath);
                }
            }
            }else{
                $image = $this->picProductModel->getPicProductByIdProduct($id);
            }
            
    
            // Điều hướng sau khi cập nhật thành công
            header("Location: /products");
            exit;
        } else {
            // Lấy dữ liệu để hiển thị trên form
            $product = $this->productModel->getProductById($id);
            $categories = $this->categoryModel->getAllCategories();
            $sizes = $this->sizeModel->getAllSizes();
            $colors = $this->colorModel->getAllColors();
            $variants = $this->productItemModel->getProductItemByIdProduct($id); // Biến thể sản phẩm
            $images = $this->picProductModel->getPicProductByIdProduct($id);
    
            // Render form chỉnh sửa
            renderViewAdmin("view/admin/products/product_edit.php", compact('product', 'categories', 'sizes', 'colors', 'variants' , 'images'), "Edit Product");
        }
    }
    
    

    public function delete($id) {
        $this->productItemModel->deleteProductItemByIdProduct($id);
        $this->productModel->deleteProduct($id);
        header("Location: /products");
    }

    public function addVariant($id) {
        $product = $this->productModel->getProductById($id);
        renderViewAdmin("view/admin/products/variants/productVariant_create.php", compact('product'), "Product Detail");
    }

    public function listVariant($id) {
        $productItems = $this->productItemModel->getProductItemByIdProduct($id);
        renderViewAdmin("view/admin/products/variants/productVariant_list.php", compact('productItems'), "Product Detail");
    }

    public function filterProduct() {
        $categoryIds = $_GET['category'] ?? [];
        $sortBy = $_GET['sort'] ?? 'newest'; 
        $name = $_GET['search'] ?? null;
        $selectedColors = $_GET['color'] ?? []; 
        $selectedSizes = $_GET['size'] ?? []; 
    
        // Xử lý khoảng giá
        $priceRange = $_GET['price_range'] ?? null;
        $minPrice = null;
        $maxPrice = null;
        if ($priceRange) {
            $priceParts = explode('-', $priceRange);
            $minPrice = isset($priceParts[0]) ? (int) $priceParts[0] : null;
            $maxPrice = isset($priceParts[1]) ? (int) $priceParts[1] : null;
        }

        // Gọi Model để lấy sản phẩm theo bộ lọc
        $products = $this->productModel->getProductByFilters($categoryIds, $minPrice, $maxPrice, $name, $sortBy, $selectedColors, $selectedSizes);
    
        // Lấy danh sách danh mục, kích thước, màu sắc
        $categories = $this->categoryModel->getAllCategories();
        $sizes = $this->sizeModel->getAllSizes();
        $colors = $this->colorModel->getAllColors();
        $banners = $this->bannerModel->getAllBanners();
        renderViewUser("view/user/shop.php", compact('products', 'categories', 'sizes', 'colors', 'sortBy', 'selectedColors', 'selectedSizes', 'categoryIds', 'minPrice', 'maxPrice', 'banners'), "Filtered Product List");
    }
    
}