<?php
require_once "model/ColorModel.php";
require_once "view/helpers.php";

class ColorController {
    private $colorModel;

    public function __construct() {
        $this->colorModel = new ColorModel();
    }

    public function index() {
        $colors = $this->colorModel->getAllColors();
        //compact: gom bien dien thanh array
        renderView("view/colors/color_list.php", compact('colors'), "colors List");
    }

    public function show($id) {
        $color = $this->colorModel->getColorById($id);
        renderView("view/colors/color_detail.php", compact('color'), "color Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameColor = $_POST['nameColor'];

            $this->colorModel->createColor($nameColor);
            echo "<script>alert('Create Color successfully!')
            window.location.href='/colors'
            </script>";
            // header("Location: /categories");
        } else {
            renderView("view/colors/color_create.php", [], "Create color");
        }
    }

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $nameColor = $_POST['nameColor'];

            $this->colorModel->updateColor($id, $nameColor);
            header("Location: /colors");
        } else {
            $color = $this->colorModel->getColorById($id);
            renderView("view/colors/color_edit.php", compact('color'), "Edit color");
        }
    }

    public function delete($id) {
        $this->colorModel->deleteColor($id);
        echo"<script>
        confirm('Bạn có chắc chắn muốn xóa không?')
        if(confirm){
            alert('Delete Color successfully!');
            window.location.href='/colors'
        }else{
            alert('Delete color fail!')
                    window.location.href='/colors'
        }
        </script>";
        // header("Location: /categories");
    }
}