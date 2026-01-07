<?php

class UserController
{
    private $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
    }

    public function Index()
    {
        if (!SessionManager::exists('user_id')) {
            header('Location: index.php?page=SignIn');
            exit;
        }
        $user = $this->userModel->getDetail(SessionManager::get('user_id'));
        $msg = SessionManager::flash("success");
        return require_once "./View/User/Index.php";
    }
    public function Update()
    {
        if (!SessionManager::exists('user_id')) {
            header('Location: index.php?page=SignIn');
            exit;
        }

        $user_id = SessionManager::get('user_id');
        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $full_name = trim($_POST['full_name'] ?? '');
            $phone_number = trim($_POST['phone_number'] ?? '');
            $address = trim($_POST['address'] ?? '');
            $city = trim($_POST['city'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            // Validate using UserModel (only required fields for update)
            $tempUser = new UserModel([
                'user_name' => 'temp', // Skip username validation on update
                'password' => $password ?: 'temp', // Skip password validation if not changed
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'address' => $address,
                'city' => $city,
                'email' => $email
            ]);

            $validationErrors = $tempUser->validate($tempUser);
            // Only keep validation errors for fields we care about in update
            $relevantFields = ['full_name', 'phone_number', 'address', 'city'];
            foreach ($validationErrors as $field => $error) {
                if (in_array($field, $relevantFields)) {
                    $errors[] = $error;
                }
            }

            $updateData = [
                'full_name' => $full_name,
                'phone_number' => $phone_number,
                'address' => $address,
                'city' => $city
            ];

            // email validation & include
            if (!empty($email)) {
                if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    $errors[] = 'Email không hợp lệ.';
                } elseif (!preg_match('/^[a-zA-Z0-9._%+\-]+@example\.com$/', $email)) {
                    $errors[] = 'Email phải có đuôi @example.com';
                } else {
                    $existing = $this->userModel->getByEmail($email);
                    if ($existing && $existing->getUser_id() != $user_id) {
                        $errors[] = 'Email đã được sử dụng bởi tài khoản khác.';
                    } else {
                        $updateData['email'] = $email;
                    }
                }
            } else {
                $errors[] = 'Email không được để trống.';
            }

            // handle password change if provided
            if (!empty($password)) {
                $updateData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // handle avatar upload
            if (isset($_FILES['avatar_url']) && !empty($_FILES['avatar_url']['name'])) {
                $upload = Upload_file::Upload_image($_FILES['avatar_url'], __DIR__ . '/../assets/img/avatars/');
                if ($upload['status']) {
                    // Delete old avatar if exists
                    $currentUser = $this->userModel->getDetail($user_id);
                    if ($currentUser && !empty($currentUser->getAvatar_url())) {
                        $oldAvatar = __DIR__ . '/../assets/img/avatars/' . $currentUser->getAvatar_url();
                        if (file_exists($oldAvatar)) {
                            unlink($oldAvatar);
                        }
                    }
                    $updateData['avatar_url'] = $upload['file_name'];
                } else {
                    $errors[] = 'Ảnh đại diện: ' . $upload['message'];
                }
            }

            if (empty($errors)) {
                $ok = $this->userModel->Update($updateData, 'user_id', $user_id);
                if ($ok) {
                    // refresh session username if changed
                    if (!empty($updateData['user_name'])) {
                        SessionManager::set('user_name', $updateData['user_name']);
                    }
                    SessionManager::flash('success', 'Cập nhật thông tin thành công!');
                    header('Location: index.php?page=User');
                    exit;
                } else {
                    $errors[] = $this->userModel->error_message ?: 'Cập nhật thất bại.';
                }
            }
        }

        // on error or not POST, show edit view with $errors available
        $user = $this->userModel->getDetail($user_id);
        return require_once "./View/User/Index.php";
    }

    public function Logout()
    {
        SessionManager::destroy();
        header('Location: index.php?page=SignIn');
        exit;
    }
}
