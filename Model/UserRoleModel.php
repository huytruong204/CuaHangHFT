<?php
include_once __DIR__ . '/../core/BaseModel.php';
include_once __DIR__ . '/../core/Validator.php';
class UserRoleModel extends BaseModel
{
    public const TB_NAME = "user_role";
    protected $role_id;
    protected $user_id;

    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);
        if (!empty($data)) {
            $this->role_id = $data['role_id'] ?? null;
            $this->user_id = $data['user_id'] ?? null;
        }
    }

    public function assignRole($user_id, $role_id)
    {
        try {
            $insert = ['role_id' => $role_id, 'user_id' => $user_id];
            return $this->Insert($insert);
        } catch (Exception $e) {
            $this->error_message = $e->getMessage();
            return false;
        }
    }

    public function removeRole($user_id, $role_id)
    {
        try {
            $stmt = $this->db->prepare("DELETE FROM " . self::TB_NAME . " WHERE user_id = ? AND role_id = ?");
            $stmt->execute([$user_id, $role_id]);
            return true;
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
            return false;
        }
    }

    public function getRolesByUser($user_id)
    {
        try {
            $sql = "SELECT r.* FROM " . self::TB_NAME . " ur JOIN roles r ON ur.role_id = r.role_id WHERE ur.user_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$user_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
            return [];
        }
    }

    public function getUsersByRole($role_id)
    {
        try {
            $sql = "SELECT u.* FROM " . self::TB_NAME . " ur JOIN users u ON ur.user_id = u.user_id WHERE ur.role_id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$role_id]);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
            return [];
        }
    }

    public function exists($user_id, $role_id)
    {
        try {
            $stmt = $this->db->prepare("SELECT COUNT(*) FROM " . self::TB_NAME . " WHERE user_id = ? AND role_id = ?");
            $stmt->execute([$user_id, $role_id]);
            return $stmt->fetchColumn() > 0;
        } catch (PDOException $e) {
            return false;
        }
    }

    public function validate($data)
    {
        $errors = [];
        if ($err = Validator::is_isset($data->user_id ?? null, "User id không tồn tại"))
            $errors['user_id'] = $err;
        elseif ($err = Validator::required($data->user_id ?? null, "User id không được để trống"))
            $errors['user_id'] = $err;

        if ($err = Validator::is_isset($data->role_id ?? null, "Role id không tồn tại"))
            $errors['role_id'] = $err;
        elseif ($err = Validator::required($data->role_id ?? null, "Role id không được để trống"))
            $errors['role_id'] = $err;

        return $errors;
    }

    public function getRole_id()
    {
        return $this->role_id;
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function setRole_id($role_id)
    {
        $this->role_id = $role_id;
        return $this;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;
        return $this;
    }
}
?>
