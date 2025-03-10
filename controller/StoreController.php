<?php
require_once "model/StoreModel.php";
require_once "model/ProvinceModel.php";
require_once "model/DistrictModel.php";
require_once "model/WardModel.php";

require_once "view/helpers.php";

class StoreController {
    private $storeModel;
    private $provinceModel;
    private $districtModel;
    private $wardModel;
    public function __construct() {
        $this->storeModel = new storeModel();
        $this->provinceModel = new ProvinceModel();
        $this->wardModel = new WardModel();
        $this->districtModel = new DistrictModel();
    }

    public function index() {
        $stores = $this->storeModel->getAllStores();
        //compact: gom bien dien thanh array
        renderViewAdmin("view/admin/stores/store_list.php", compact('stores'), "store List");
    }

    // public function show($id) {
    //     $store = $this->storeModel->getStoreById($id);
    //     renderViewAdmin("view/admin/stores/store_detail.php", compact('store'), "store Detail");
    // }


    public function showStore() {
        $stores = $this->storeModel->getAllStores();
        $province = $this->provinceModel->getAllProvinces();
        renderViewUser("view/user/store.php", compact("stores", "provinces"),"Store");
    }
    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
            $description = trim($_POST['description']);
            $address = trim($_POST['address']);
            $open_time = trim($_POST['open_time']);
            $close_time = trim($_POST['close_time']);
            $phone_number = trim($_POST['phone_number']);
            $district_id = trim($_POST['district_id']);
            $province_id = trim($_POST['province_id']);
            $ward_id = trim($_POST['ward_id']);
    
            if (empty($name)) {
                $_SESSION['error'] = 'Vui lòng nhập tên cửa hàng';
                return;
            }

                $this->storeModel->createStore($name, $description, $address, $open_time, $close_time, $phone_number, $province_id, $district_id, $ward_id);
                $_SESSION["success"] = "Tạo cửa hàng thành công";
                header("Location: /stores");
            
        } else {
            $provinces = $this->provinceModel->getAllProvinces();
            renderViewAdmin("view/admin/stores/store_create.php", compact('provinces'), "Create store");
        }
    }
    

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];
            $description = $_POST['description'];
            $address = $_POST['address'];
            $open_time = $_POST['open_time'];
            $close_time = $_POST['close_time'];
            $phone_number = $_POST['phone_number'];
            $district_id = $_POST['district_id'];
            $ward_id = $_POST['ward_id'];
            $province_id = $_POST['province_id'];
            if (empty($name)) {
                $_SESSION['error'] = 'Vui lòng nhập tên cửa hàng';
                return;
            }
            $this->storeModel->updateStore($id, $name, $description, $address, $open_time, $close_time, $phone_number, $province_id, $district_id, $ward_id);
            $_SESSION['success'] = 'Cập nhật thành công';
            header("Location: /stores");
        } else {
            $store = $this->storeModel->getStoreById($id);
            renderViewAdmin("view/admin/stores/store_edit.php", compact('store'), "Edit store");
        }
    }

    public function delete($id) {
        $this->storeModel->deleteStore($id);
        echo"<script>
        confirm('Bạn có chắc chắn muốn xóa không?')
        if(confirm){
            alert('Delete store successfully!')
                    window.location.href='/stores'
        }else{
            alert('Delete store fail!')
                    window.location.href='/stores'
        }
        </script>";
    }
}