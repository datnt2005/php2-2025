<?php
require_once "model/BannerModel.php";
require_once "view/helpers.php";

class BannerController {
    private $bannerModel;

    public function __construct() {
        $this->bannerModel = new bannerModel();
    }


    public function index() {
        $banners = $this->bannerModel->getAllBanners();
        //compact: gom bien dien thanh array
        renderViewAdmin("view/admin/banners/banner_list.php", compact('banners'), "banner List");
    }

    // public function showBanner() {
    //     $banner = $this->bannerModel->getBannerById($id);
    //     renderViewAdmin("view/admin/banners/banner_list.php", compact('banner'), "banner List");
    // }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $image = $_FILES['image'];
            $status = 1;
    
            // Kiểm tra xem file có được tải lên không
            if ($image['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'uploads/';
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                $fileType = mime_content_type($image['tmp_name']);
    
                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['error'] = "Chỉ chấp nhận tệp JPG, PNG, GIF!";
                    header("Location: /banners/create");
                    exit;
                }
    
                // Tạo tên file mới để tránh trùng lặp
                $fileExt = pathinfo($image['name'], PATHINFO_EXTENSION);
                $fileName = time() . '_' . uniqid() . '.' . $fileExt;
                $uploadFile = $uploadDir . $fileName;
    
                // Di chuyển file upload vào thư mục
                if (move_uploaded_file($image['tmp_name'], $uploadFile)) {
                    $imagePath = $uploadFile;
                } else {
                    $_SESSION['error'] = "Lỗi khi tải ảnh!";
                    header("Location: /banners/create");
                    exit;
                }
            } else {
                $_SESSION['error'] = "Vui lòng chọn ảnh!";
                header("Location: /banners/create");
                exit;
            }
    
            // Kiểm tra tiêu đề banner
            if (empty($title)) {
                renderViewAdmin("view/admin/banners/banner_create.php", [
                    'error' => 'Banner title is required!'
                ], "Create Banner");
            } else {
                // Thêm vào database
                $this->bannerModel->createBanner($title, $imagePath, $status);
                echo "<script>alert('Create banner successfully!');
                window.location.href='/banners';</script>";
            }
        } else {
            renderViewAdmin("view/admin/banners/banner_create.php", [], "Create Banner");
        }
    }
    
    

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $title = trim($_POST['title']);
            $image = $_FILES['image'];
            $status = $_POST['status'];
            $this->bannerModel->updateBanner($id, $title, $image, $status);
            header("Location: /banners");
        } else {
            $banner = $this->bannerModel->getBannerById($id);
            renderViewAdmin("view/admin/banners/banner_edit.php", compact('banner'), "Edit banner");
        }
    }

    public function delete($id) {
        $this->bannerModel->deleteBanner($id);
        echo"<script>
        confirm('Bạn có chắc chắn muốn xóa không?')
        if(confirm){
            alert('Delete banner successfully!')
                    window.location.href='/banners'
        }else{
            alert('Delete banner fail!')
                    window.location.href='/banners'
        }
        </script>";
        // header("Location: /banners");
    }
}