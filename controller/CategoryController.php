<?php
require_once "model/CategoryModel.php";
require_once "view/helpers.php";

class CategoryController {
    private $categoryModel;

    public function __construct() {
        $this->categoryModel = new CategoryModel();
    }

    public function index() {
        $categories = $this->categoryModel->getAllCategories();
        //compact: gom bien dien thanh array
        renderView("view/categories/category_list.php", compact('categories'), "Category List");
    }

    public function show($id) {
        $category = $this->categoryModel->getCategoryById($id);
        renderView("view/categories/category_detail.php", compact('category'), "Category Detail");
    }

    public function create() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name']);
    
            if (empty($name)) {
                renderView("view/categories/category_create.php", [
                    'error' => 'Category name is required!'
                ], "Create Category");
            } else {
                $this->categoryModel->createCategory($name);
                echo "<script>alert('Create category successfully!');
                window.location.href='/categories';
                </script>";
            }
        } else {
            renderView("view/categories/category_create.php", [], "Create Category");
        }
    }
    

    public function edit($id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = $_POST['name'];

            $this->categoryModel->updateCategory($id, $name);
            header("Location: /categories");
        } else {
            $category = $this->categoryModel->getCategoryById($id);
            renderView("view/categories/category_edit.php", compact('category'), "Edit Category");
        }
    }

    public function delete($id) {
        $this->categoryModel->deleteCategory($id);
        echo"<script>
        confirm('Bạn có chắc chắn muốn xóa không?')
        if(confirm){
            alert('Delete category successfully!')
                    window.location.href='/categories'
        }else{
            alert('Delete category fail!')
                    window.location.href='/categories'
        }
        </script>";
        // header("Location: /categories");
    }
}