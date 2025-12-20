<?php
include_once __DIR__ . '/../Model/UserRoleModel.php';

class SignInController{
    public function Index(){
        return require_once "./View/SignIn/index.php";
    }

    public function login(){
        $auth_error = '';
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user_name = $_POST['user_name'] ?? '';
            $password = $_POST['password'] ?? '';

            $userModel = new UserModel();
            $user = $userModel->authenticate($user_name, $password);
            if ($user){
                SessionManager::set('user_id', $user->getUser_id());
                SessionManager::set('user_name', $user->getUser_name());
                SessionManager::set('avatar_url', $user->getAvatar_url());
                
                // Lấy vai trò của người dùng
                $userRoleModel = new UserRoleModel();
                $roles = $userRoleModel->getRolesByUser($user->getUser_id());
                $roleName = !empty($roles) ? strtolower($roles[0]['role_name']) : 'customer';
                SessionManager::set('user_role', $roleName);
                
                SessionManager::flash('success', 'Đăng nhập thành công!');
                
                // Chuyển hướng dựa trên vai trò
                if ($roleName === 'admin') {
                    header('Location: ./Admin/index.php?page=HomeAdmin');
                } else {
                    header('Location: index.php?page=Food');
                }
                exit;
            } else {
                $auth_error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            }
        }
        // show view with $auth_error available
        return require_once "./View/SignIn/index.php";
    }

    public function logout(){
        SessionManager::destroy();
        header('Location: index.php?page=Home');
        exit;
    }
}
?>