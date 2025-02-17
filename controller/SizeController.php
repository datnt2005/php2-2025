<?php
require_once "model/SizeModel.php";
require_once "view/helpers.php";

class SizeController {
    private $sizeModel;

    public function __construct() {
        $this->sizeModel = new SizeModel();
    }

    public function index() {
        $sizes = $this->sizeModel->getAllSizes();
        //compact: gom bien dien thanh array
        renderView("view/sizes/size_list.php", compact('sizes'), "Sizes List");
    }

    public function show($id) {
        $size = $this->sizeModel->getSizeById($id);
        renderView("view/sizes/size_detail.php", compact('size'), "Size Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameSize = $_POST['nameSize'];

            $this->sizeModel->createSize($nameSize);
            echo "<script>alert('Create size successfully!')
            window.location.href='/sizes'
            </script>";
            // header("Location: /categories");
        } else {
            renderView("view/sizes/size_create.php", [], "Create size");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameSize = $_POST['nameSize'];

            $this->sizeModel->updateSize($id, $nameSize);
            header("Location: /sizes");
        } else {
            $size = $this->sizeModel->getSizeById($id);
            renderView("view/sizes/size_edit.php", compact('size'), "Edit Size");
        }
    }

    public function delete($id) {
        $this->sizeModel->deleteSize($id);
        echo"<script>
        confirm('Bạn có chắc chắn muốn xóa không?')
        if(confirm){
            alert('Delete size successfully!');
            window.location.href='/sizes'
        }else{
            alert('Delete size fail!')
                    window.location.href='/sizes'
        }
        </script>";
        // header("Location: /categories");
    }
}