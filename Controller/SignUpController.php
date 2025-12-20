<?php
class SignUpController{
    public function Index(){
        return require_once "./View/SignUp/index.php";
    }

    public function register(){
        $register_error = '';
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            $user_name = trim($_POST['user_name'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $full_name = trim($_POST['full_name'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');

            // Basic validation
            if ($user_name === '') $errors[] = 'Tên đăng nhập không được để trống.';
            if ($password === '') $errors[] = 'Mật khẩu không được để trống.';
            if ($password !== $confirm) $errors[] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            if ($full_name === '') $errors[] = 'Họ và tên không được để trống.';
            if ($phone_number === '') $errors[] = 'Số điện thoại không được để trống.';
            if ($address === '') $errors[] = 'Địa chỉ không được để trống.';
            if ($city === '') $errors[] = 'Tỉnh/Thành phố không được để trống.';

            $userModel = new UserModel();
            // Check username exists
            if (!$errors){
                $existing = $userModel->getByUserName($user_name);
                if ($existing) $errors[] = 'Tên đăng nhập đã tồn tại.';
            }

            $avatar_file_name = '';
            if (!$errors && isset($_FILES['avatar_url']) && !empty($_FILES['avatar_url']['name'])){
                $upload = Helper::Upload_image($_FILES['avatar_url'], __DIR__ . '/../img/avatars/');
                if ($upload['status']){
                    $avatar_file_name = $upload['file_name'];
                } else {
                    $errors[] = 'Ảnh đại diện: ' . $upload['message'];
                }
            }

            if (empty($errors)){
                $data = [];
                $data['user_name'] = $user_name;
                $data['password'] = $password; // createUser will hash
                $data['full_name'] = $full_name;
                $data['phone_number'] = $phone_number;
                $data['address'] = $address;
                $data['city'] = $city;
                $data['avatar_url'] = $avatar_file_name;
                $data['is_active'] = 1;

                $newId = $userModel->createUser($data);
                if ($newId){
                    SessionManager::flash('success', 'Đăng ký thành công! Vui lòng đăng nhập.');
                    header('Location: index.php?page=SignIn');
                    exit;
                } else {
                    $register_error = $userModel->error_message ?: 'Lỗi khi tạo tài khoản.';
                }
            }
        }

        return require_once "./View/SignUp/index.php";
    }
}
?>