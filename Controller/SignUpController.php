<?php
include_once __DIR__ . '/../Model/UserModel.php';
include_once __DIR__ . '/../Model/RoleModel.php';
include_once __DIR__ . '/../Model/UserRoleModel.php';
include_once __DIR__ . '/../Helper/Upload_file.php';
include_once __DIR__ . '/../Helper/SessionManager.php';

class SignUpController
{
    public function Index()
    {
        return require_once "./View/SignUp/index.php";
    }

    public function register()
    {
        $register_error = '';
        $errors = [];
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $user_name = trim($_POST['user_name'] ?? '');
            $password = $_POST['password'] ?? '';
            $confirm = $_POST['confirm_password'] ?? '';
            $email = trim($_POST['email'] ?? '');
            $full_name = trim($_POST['full_name'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');

            // Validate using UserModel
            $tempUser = new UserModel([
                'user_name' => $user_name,
                'password' => $password,
                'email' => $email,
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'address' => $address,
                'city' => $city
            ]);

            $validationErrors = $tempUser->validate($tempUser);
            $errors = array_values($validationErrors); // Convert to indexed array

            // Check password confirmation
            if ($password !== $confirm) {
                $errors[] = 'Mật khẩu và xác nhận mật khẩu không khớp.';
            }

            $userModel = new UserModel();
            // Check username exists
            if (empty($errors)) {
                $existing = $userModel->getByUserName($user_name);
                if ($existing) $errors[] = 'Tên đăng nhập đã tồn tại.';
            }

            // validate email
            if (empty($errors)) {
                if (empty($email)) {
                    $errors[] = 'Email không được để trống.';
                } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Email không hợp lệ.';
                } else {
                    $existingEmail = $userModel->getByEmail($email);
                    if ($existingEmail) $errors[] = 'Email đã được sử dụng.';
                }
            }

            $avatar_file_name = '';
            if (!$errors && isset($_FILES['avatar_url']) && !empty($_FILES['avatar_url']['name'])) {
                $upload = Upload_file::Upload_image($_FILES['avatar_url'], __DIR__ . '/../assets/img/avatars/');
                if ($upload['status']) {
                    $avatar_file_name = $upload['file_name'];
                } else {
                    $errors[] = 'Ảnh đại diện: ' . $upload['message'];
                }
            }

            if (empty($errors)) {
                $data = [];
                $data['user_name'] = $user_name;
                $data['password'] = $password; // createUser will hash
                $data['email'] = $email;
                $data['full_name'] = $full_name;
                $data['phone_number'] = $phone_number;
                $data['address'] = $address;
                $data['city'] = $city;
                $data['avatar_url'] = $avatar_file_name;
                $data['is_active'] = 1;

                $newId = $userModel->createUser($data);
                if ($newId) {
                    // Tự động gán vai trò customer cho người dùng mới
                    $roleModel = new RoleModel();
                    $userRoleModel = new UserRoleModel();

                    // Lấy role_id của customer
                    $customerRole = $roleModel->getByRoleName('customer');
                    if ($customerRole) {
                        $userRoleModel->assignRole($newId, $customerRole->getRole_id());
                    }

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
