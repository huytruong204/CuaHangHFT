<?php 
    
    class MenuComponent{
        public $categoryModel;
        public function __construct()
        {
            $this->categoryModel = new CategoryModel();
        }
        public function Index() {
            $list_cat = $this->categoryModel->getAllCategories();
            $exists_id = SessionManager::exists('user_id');
            $name = SessionManager::get('user_name', 'Người dùng');
            $count = CartModel::getCountCart();
            $user = null;
            if ($exists_id) {
                $user = (new UserModel())->getDetail(SessionManager::get('user_id'));
            }
            include_once "View/Component/Menu/Index.php";
        }
    }
?>