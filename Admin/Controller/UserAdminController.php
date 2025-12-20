<?php
include_once __DIR__ . "/../../Model/UserAdminModel.php";
include_once __DIR__ . "/../../Model/RoleModel.php";
include_once __DIR__ . "/../../Model/UserRoleModel.php";
include_once __DIR__ . "/../../Helper/SessionManager.php";
include_once __DIR__ . "/../../Helper/Upload_file.php";

class UserAdminController {
    private $userAdminModel;
    private $roleModel;
    private $userRoleModel;

    public function __construct() {
        $this->userAdminModel = new UserAdminModel();
        $this->roleModel = new RoleModel();
        $this->userRoleModel = new UserRoleModel();
        $this->ensureDefaultRoles();
        // Guard đã được xử lý ở Admin/index.php
    }

    // Đảm bảo luôn có 3 vai trò cơ bản
    private function ensureDefaultRoles(): void
    {
        $defaults = ['admin', 'customer', 'shipper'];
        foreach ($defaults as $role_name) {
            if (!$this->roleModel->getByRoleName($role_name)) {
                $this->roleModel->Insert(['role_name' => $role_name]);
            }
        }
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
            // Chỉ cho phép sửa vai trò
            if (empty($user_id)) {
                echo "<script>alert('Thiếu user_id'); window.location.href='index.php?page=UserAdmin';</script>";
                exit;
            }

            // Cập nhật phân quyền (Xóa cũ - Thêm mới) - chỉ 1 vai trò
            $this->userRoleModel->removeAllRoles($user_id);
            $selected_role = $_POST['role'] ?? null; // Đổi từ roles[] thành role
            if ($selected_role) {
                $this->userRoleModel->assignRole($user_id, $selected_role);
            }

            SessionManager::flash('success', 'Cập nhật vai trò thành công!');
            echo "<script>window.location.href='index.php?page=UserAdmin';</script>";
            exit;
        }
    }

    public function ToggleStatus() {
        $user_id = $_GET['user_id'];
        $current_status = $_GET['status'];
        $new_status = ($current_status == 1) ? 0 : 1;
        
        $this->userAdminModel->Update(['is_active' => $new_status], 'user_id', $user_id);
        // Dùng JS redirect để tránh lỗi headers đã gửi
        echo "<script>window.location.href='index.php?page=UserAdmin';</script>";
    }
}