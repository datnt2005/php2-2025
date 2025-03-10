<?php
require_once "model/ProvinceModel.php";
require_once "model/DistrictModel.php";
require_once "model/WardModel.php";

class LocationController {
    private $provinceModel;
    private $districtModel;
    private $wardModel;

    public function __construct() {
        $this->provinceModel = new ProvinceModel();
        $this->districtModel = new DistrictModel();
        $this->wardModel = new WardModel();
    }

    // Lấy danh sách tỉnh/thành phố
    public function getProvinces() {
        $provinces = $this->provinceModel->getAllProvinces();
        echo json_encode($provinces);
    }

    // Lấy danh sách quận/huyện theo tỉnh
    public function getDistricts($provinceId) {
        if (empty($provinceId)) {
            echo json_encode(["status" => "error", "message" => "Thiếu ID tỉnh"]);
            return;
        }
        $districts = $this->districtModel->getDistrictsByProvince($provinceId);
        echo json_encode($districts);
    }

    // Lấy danh sách phường/xã theo quận
    public function getWards($districtId) {
        if (empty($districtId)) {
            echo json_encode(["status" => "error", "message" => "Thiếu ID quận"]);
            return;
        }
        $wards = $this->wardModel->getWardsByDistrict($districtId);
        echo json_encode($wards);
    }
}
?>
