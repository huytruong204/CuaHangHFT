<?php
include_once __DIR__ . '/../Model/UserModel.php';
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
                // tạo session đơn giản
                if(session_status() !== PHP_SESSION_ACTIVE) session_start();
                $_SESSION['user_id'] = $user->getUser_id();
                $_SESSION['user_name'] = $user->getUser_name();
                header('Location: index.php?page=Home');
                exit;
            } else {
                $auth_error = 'Tên đăng nhập hoặc mật khẩu không đúng.';
            }
        }
        // show view with $auth_error available
        return require_once "./View/SignIn/index.php";
    }
}
?>