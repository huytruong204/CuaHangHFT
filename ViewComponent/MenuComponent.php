<?php 
    class MenuComponent{
        public static function Index() {
            $exists_id = SessionManager::exists('user_id');
            $role_user = SessionManager::get('user_role');
            $count = CartModel::getCountCart();
            $user = '';
            if ($exists_id) {
                $user = (new UserModel())->getDetail(SessionManager::get('user_id'));
            }
            include_once "View/Component/Menu/Index.php";
        }
    }
?>