<?php
include_once __DIR__ . '/../Model/UserModel.php';
include_once __DIR__ . '/../Helper/Upload_file.php';

class UserController{
    public function Index(){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['user_id'])){
            header('Location: index.php?page=SignIn');
            exit;
        }
        $userModel = new UserModel();
        $user = $userModel->getDetail($_SESSION['user_id']);
        return require_once "./View/User/Index.php";
    }

    public function Edit(){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['user_id'])){
            header('Location: index.php?page=SignIn');
            exit;
        }
        $userModel = new UserModel();
        $user = $userModel->getDetail($_SESSION['user_id']);
        return require_once "./View/User/Edit.php";
    }

    public function Update(){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        if (!isset($_SESSION['user_id'])){
            header('Location: index.php?page=SignIn');
            exit;
        }

        $userModel = new UserModel();
        $user_id = $_SESSION['user_id'];
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $full_name = trim($_POST['full_name'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $password = $_POST['password'] ?? '';

            if ($full_name === '') $errors[] = 'Họ và tên không được để trống.';
            if ($phone_number === '') $errors[] = 'Số điện thoại không được để trống.';

            $updateData = [];
            $updateData['full_name'] = $full_name;
            $updateData['phone_number'] = $phone_number;
            $updateData['address'] = $address;
            $updateData['city'] = $city;

            // handle password change if provided
            if (!empty($password)){
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // handle avatar upload
            if (isset($_FILES['avatar_url']) && !empty($_FILES['avatar_url']['name'])){
                $upload = Helper::Upload_image($_FILES['avatar_url'], __DIR__ . '/../img/avatars/');
                if ($upload['status']){
                    $updateData['avatar_url'] = $upload['file_name'];
                } else {
                    $errors[] = 'Ảnh đại diện: ' . $upload['message'];
                }
            }

            if (empty($errors)){
                $ok = $userModel->Update($updateData, 'user_id', $user_id);
                if ($ok){
                    // refresh session username if changed
                    if (!empty($updateData['user_name'])){
                        $_SESSION['user_name'] = $updateData['user_name'];
                    }
                    header('Location: index.php?page=User');
                    exit;
                } else {
                    $errors[] = $userModel->error_message ?: 'Cập nhật thất bại.';
                }
            }
        }

        // on error or not POST, show edit view with $errors available
        $user = $userModel->getDetail($user_id);
        return require_once "./View/User/Edit.php";
    }

    public function Logout(){
        if(session_status() !== PHP_SESSION_ACTIVE) session_start();
        session_unset();
        session_destroy();
        header('Location: index.php?page=Home');
        exit;
    }
}

?>