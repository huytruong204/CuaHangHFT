<?php
include_once __DIR__ . "/../../Model/UserAdminModel.php";
include_once __DIR__ . "/../../Model/RoleModel.php";
include_once __DIR__ . "/../../Model/UserRoleModel.php";
include_once __DIR__ . "/../../Helper/SessionManager.php";

class UserAdminController {
    private $userAdminModel;
    private $roleModel;
    private $userRoleModel;

    public function __construct() {
        $this->userAdminModel = new UserAdminModel();
        $this->roleModel = new RoleModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function Index() {
        $rows_per_page = 10;
        $current_page = $_GET['p'] ?? 1;
        $offset = ($current_page - 1) * $rows_per_page;
        $where = isset($_GET['keyword']) ? ['keyword' => $_GET['keyword']] : [];
        
        $list_users = $this->userAdminModel->getAllUsersWithRoles($offset, $rows_per_page, $where);
        $total_rows = $this->userAdminModel->CountRows($where);
        $total_pages = ceil($total_rows / $rows_per_page);

        include_once "View/UserAdmin/Index.php";
    }

    public function UpdateGet()
    {
        if (!isset($_GET['user_id'])) {
            echo "<script>alert('Không tồn tại user_id'); window.location.href='index.php?page=UserAdmin';</script>";
            exit;
        }

        $user_id = $_GET['user_id'];
        // Lấy thông tin chi tiết user
        $user = $this->userAdminModel->getDetail($user_id); 
        
        // Lấy danh sách tất cả vai trò để chọn
        $list_roles = $this->roleModel->getAllRoles(); 
        
        // Lấy danh sách ID các vai trò mà user này đang có
        $user_roles_data = $this->userRoleModel->getRolesByUser($user_id);
        $current_role_ids = array_column($user_roles_data, 'role_id');

        include_once "View/UserAdmin/Update.php";
    }

    public function UpdatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $user_id = $_POST['user_id'] ?? '';
            
            // 1. Chuẩn bị dữ liệu cập nhật thông tin cơ bản
            $data = [
                'full_name'    => trim($_POST['full_name'] ?? ''),
                'phone_number' => trim($_POST['phone_number'] ?? ''),
                'address'      => trim($_POST['address'] ?? ''),
                'city'         => trim($_POST['city'] ?? ''),
                'is_active'    => $_POST['is_active'] ?? 1,
                'avatar_url'   => $_POST['old_avatar'] ?? ''
            ];

            // 2. Xử lý tải lên ảnh đại diện mới nếu có
            $path = "../img/avatars/";
            if (!empty($_FILES['avatar_url']['name'])) {
                $upload_img = Helper::Upload_image($_FILES['avatar_url'], $path);
                if ($upload_img['status'] == true) {
                    // Xóa ảnh cũ nếu tồn tại
                    if (!empty($data['avatar_url']) && file_exists($path . $data['avatar_url'])) {
                        unlink($path . $data['avatar_url']);
                    }
                    $data['avatar_url'] = $upload_img['file_name'];
                } else {
                    $errors['avatar_url'] = $upload_img['message'];
                }
            }

            // 3. Kiểm tra dữ liệu hợp lệ (Sử dụng Model để validate)
            $user_obj = new UserModel($data);
            $errors = $this->userAdminModel->validate($user_obj);
            // Lưu ý: Loại bỏ lỗi password và user_name vì form này chỉ cập nhật thông tin phụ
            unset($errors['password'], $errors['user_name']);

            if (empty($errors)) {
                // 4. Cập nhật thông tin cơ bản vào bảng users
                $result = $this->userAdminModel->Update($data, 'user_id', $user_id);

                if ($result) {
                    // 5. Cập nhật phân quyền (Xóa cũ - Thêm mới)
                    $this->userRoleModel->removeAllRoles($user_id); // Hàm removeAllRoles bạn vừa thêm
                    $selected_roles = $_POST['roles'] ?? [];
                    foreach ($selected_roles as $role_id) {
                        $this->userRoleModel->assignRole($user_id, $role_id);
                    }

                    echo "<script>
                            alert('Cập nhật người dùng thành công!'); 
                            window.location.href = 'index.php?page=UserAdmin';
                        </script>";
                    exit;
                } else {
                    $dbError = $this->userAdminModel->error_message;
                    echo "<script>alert('Lỗi CSDL: $dbError')</script>";
                }
            }

            // Nếu có lỗi, quay lại view cũ với dữ liệu đã nhập
            $user = new UserModel($data);
            $user->setUser_id($user_id);
            $list_roles = $this->roleModel->getAllRoles();
            $current_role_ids = $_POST['roles'] ?? [];
            include_once "View/UserAdmin/Update.php";
        }
    }

    public function ToggleStatus() {
        $user_id = $_GET['user_id'];
        $current_status = $_GET['status'];
        $new_status = ($current_status == 1) ? 0 : 1;
        
        $this->userAdminModel->Update(['is_active' => $new_status], 'user_id', $user_id);
        header("Location: index.php?page=UserAdmin");
    }
}