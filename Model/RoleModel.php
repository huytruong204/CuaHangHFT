<?php
include_once __DIR__ . '/../core/BaseModel.php';
include_once __DIR__ . '/../core/Validator.php';
class RoleModel extends BaseModel
{
    public const TB_NAME = "roles";
    protected $role_id;
    protected $role_name;

    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);
        if (!empty($data)) {
            $this->role_id   = $data['role_id'] ?? null;
            $this->role_name = $data['role_name'] ?? null;
        }
    }

    public function getAll($offset, $rows_per_page, $where_clauses)
    {
        try {
            $roles = [];
            $sql = "SELECT * FROM " . self::TB_NAME;

            $sql_clauses_arr = [];
            $values = [];
            if (!empty($where_clauses)) {
                foreach ($where_clauses as $column => $value) {
                    if ($column == 'role_name') {
                        $sql_clauses_arr[] = "$column LIKE ?";
                        $values[] = "%$value%";
                    } else {
                        $sql_clauses_arr[] = "$column = ?";
                        $values[] = $value;
                    }
                }
                $sql .= " WHERE " . implode(" AND ", $sql_clauses_arr);
            }

            $sql .= " ORDER BY role_id ASC";

            $sql .= " LIMIT $offset, $rows_per_page";

            $stmt = $this->db->prepare($sql);

            $stmt->execute($values);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                $roles[] = new RoleModel($row);
            }
            return $roles;
        } catch (PDOException $e) {
            $this->error_message = "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function getAllRoles()
    {
        try {
            $roles = [];
            $sql = "SELECT * FROM " . self::TB_NAME . " ORDER BY role_id ASC";

            $stmt = $this->db->prepare($sql);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($results as $row) {
                $roles[] = new RoleModel($row);
            }
            return $roles;
        } catch (PDOException $e) {
            $this->error_message = "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function CountRows($where_clauses)
    {
        try {
            $sql = "SELECT COUNT(*) as total FROM " . self::TB_NAME;
            $sql_clauses_arr = [];
            $values = [];
            if (!empty($where_clauses)) {
                foreach ($where_clauses as $column => $value) {
                    $sql_clauses_arr[] = "$column = ?";
                    $values[] = $value;
                }
                $sql .= " WHERE " . implode(" AND ", $sql_clauses_arr);
            }

            $stmt = $this->db->prepare($sql);

            $stmt->execute($values);

            return $stmt->fetchColumn();
        } catch (PDOException $e) {
                return 0;
        }
    }

    public function getDetail($role_id)
    {
        try {
            $sql = "SELECT * FROM " . self::TB_NAME . " WHERE role_id = ? LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([$role_id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($data) {
                $role = new RoleModel($data);
                return $role;
            }
            return null;
        } catch (PDOException $e) {
            $errorCode = isset($e->errorInfo[1]) ? $e->errorInfo[1] : 0;
            switch ($errorCode) {
                case 1054:
                    $this->error_message = "Lỗi SQL: Tên cột không tồn tại.";
                    break;
                case 1146:
                    $this->error_message = "Lỗi SQL: Bảng không tồn tại.";
                    break;
                default:
                    $this->error_message = "Lỗi truy vấn dữ liệu: " . $e->getMessage();
                    break;
            }
            return null;
        }
    }

    public function getByRoleName($role_name)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . self::TB_NAME . " WHERE role_name = ? LIMIT 1");
            $stmt->execute([$role_name]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data)
                return new RoleModel($data);
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function validate($data)
    {
        $errors = [];
        if ($err = Validator::is_isset($data->role_name, "Tên vai trò không tồn tại"))
            $errors['role_name'] = $err;
        elseif ($err = Validator::required($data->role_name, "Tên vai trò không được để trống"))
            $errors['role_name'] = $err;

        return $errors;
    }

    public function getRole_id()
    {
        return $this->role_id;
    }

    public function getRole_name()
    {
        return $this->role_name;
    }

    public function setRole_id($role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }

    public function setRole_name($role_name)
    {
        $this->role_name = $role_name;
        return $this;
    }
}
?>
