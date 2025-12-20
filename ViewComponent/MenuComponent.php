<?php 
    include_once "Model/CategoryModel.php";
    include_once "Helper/SessionManager.php";
    
    class MenuComponent{
        public $categoryModel;
        public function __construct()
        {
            $this->categoryModel = new CategoryModel();
        }
        public function Index() {
            $list_cat = $this->categoryModel->getAllCategories();
            include_once "View/Component/Menu/Index.php";
        }
    }
?>