<?php
include_once __DIR__ . '/UserModel.php';

class UserAdminModel extends UserModel {
    // Sử dụng INNER JOIN để lấy thông tin chi tiết vai trò của người dùng
    public function getAllUsersWithRoles($offset, $rows_per_page, $where_clauses) {
        try {
            // Câu lệnh SQL lấy user và gộp các vai trò thành chuỗi (Admin, Staff,...)
            $sql = "SELECT u.*, GROUP_CONCAT(r.role_name SEPARATOR ', ') as roles_list 
                    FROM " . self::TB_NAME . " u
                    LEFT JOIN user_role ur ON u.user_id = ur.user_id
                    LEFT JOIN roles r ON ur.role_id = r.role_id";

            $values = [];
            if (!empty($where_clauses)) {
                $sql .= " WHERE u.user_name LIKE ? OR u.full_name LIKE ?";
                $values = ["%{$where_clauses['keyword']}%", "%{$where_clauses['keyword']}%"];
            }

            $sql .= " GROUP BY u.user_id ORDER BY u.created_at DESC LIMIT $offset, $rows_per_page";
            
            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
            return [];
        }
    }

    // Override CountRows để xử lý keyword search
    public function CountRows($where_clauses)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM " . self::TB_NAME;
            $values = [];
            
            if (!empty($where_clauses) && isset($where_clauses['keyword'])) {
                $sql .= " WHERE user_name LIKE ? OR full_name LIKE ?";
                $values = ["%{$where_clauses['keyword']}%", "%{$where_clauses['keyword']}%"];
            }

            $stmt = $this->db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchColumn();
        } catch (PDOException $e) {
            return 0;
        }
    }
}