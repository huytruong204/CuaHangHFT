<?php
include_once __DIR__ . '/../core/BaseModel.php';
include_once __DIR__ . '/../core/Validator.php';
class UserModel extends BaseModel
{
    public const TB_NAME = "users";
    protected $user_id;
    protected $user_name;
    protected $password;
    protected $full_name;
    protected $phone_number;
    protected $address;
    protected $email;
    protected $city;
    protected $avatar_url;
    protected $is_active;
    protected $created_at;

    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);
        if (!empty($data)) {
            $this->user_id      = $data['user_id'] ?? null;
            $this->user_name    = $data['user_name'] ?? $data['username'] ?? null;
            $this->password     = $data['password'] ?? null;
            $this->email        = $data['email'] ?? null;
            $this->full_name    = $data['full_name'] ?? null;
            $this->phone_number = $data['phone_number'] ?? null;
            $this->address      = $data['address'] ?? null;
            $this->city         = $data['city'] ?? null;
            $this->avatar_url   = $data['avatar_url'] ?? null;
            $this->is_active    = $data['is_active'] ?? null;
            $this->created_at   = $data['created_at'] ?? null;
        }
    }

    public function getByEmail($email)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . self::TB_NAME . " WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data) return new UserModel($data);
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    // Check if email exists (boolean)
    public function checkEmailExists($email)
    {
        return $this->getByEmail($email) !== null;
    }

    // Save password reset token with expiry (minutes)
    public function saveToken($email, $token, $minutes = 30)
    {
        try {
            $expires_at = (new DateTime())->add(new DateInterval('PT' . intval($minutes) . 'M'))->format('Y-m-d H:i:s');
            $stmt = $this->db->prepare("INSERT INTO password_resets (email, token, expires_at, created_at) VALUES (?, ?, ?, NOW())");
            $stmt->execute([$email, $token, $expires_at]);
            return true;
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
            return false;
        }
    }

    // Verify token and return row (email, token, expires_at) or false
    public function verifyToken($token)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM password_resets WHERE token = ? LIMIT 1");
            $stmt->execute([$token]);
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$row) return false;
            $now = new DateTime();
            $expires = new DateTime($row['expires_at']);
            if ($expires < $now) return false;
            return $row;
        } catch (PDOException $e) {
            return false;
        }
    }

    // Update password for given email and delete tokens
    public function updatePassword($email, $newPassword)
    {
        try {
            $hashed = password_hash($newPassword, PASSWORD_DEFAULT);
            $stmt = $this->db->prepare("UPDATE " . self::TB_NAME . " SET password = ? WHERE email = ?");
            $stmt->execute([$hashed, $email]);
            // remove any tokens for this email
            $del = $this->db->prepare("DELETE FROM password_resets WHERE email = ?");
            $del->execute([$email]);
            return true;
        } catch (PDOException $e) {
            $this->error_message = $e->getMessage();
            return false;
        }
    }

    public function getAll($offset, $rows_per_page, $where_clauses)
    {
        try {
            $users = [];
            $sql = "SELECT * FROM " . self::TB_NAME;

            $sql_clauses_arr = [];
            $values = [];
            if (!empty($where_clauses)) {
                foreach ($where_clauses as $column => $value) {
                    if ($column == 'user_name' || $column == 'full_name') {
                        $sql_clauses_arr[] = "$column LIKE ?";
                        $values[] = "%$value%";
                    } else {
                        $sql_clauses_arr[] = "$column = ?";
                        $values[] = $value;
                    }
                }
                $sql .= " WHERE " . implode(" AND ", $sql_clauses_arr);
            }

            $sql .= " ORDER BY created_at DESC";

            $sql .= " LIMIT $offset, $rows_per_page";

            $stmt = $this->db->prepare($sql);

            $stmt->execute($values);

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach ($results as $row) {
                $users[] = new UserModel($row);
            }
            return $users;
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

    public function getDetail($user_id)
    {
        try {
            $sql = "SELECT * FROM " . self::TB_NAME . " WHERE user_id = ? LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([$user_id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $user = new UserModel($data);
            return $user;
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
            return [];
        }
    }

    public function getByUserName($user_name)
    {
        try {
            $stmt = $this->db->prepare("SELECT * FROM " . self::TB_NAME . " WHERE user_name = ? LIMIT 1");
            $stmt->execute([$user_name]);
            $data = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($data)
                return new UserModel($data);
            return null;
        } catch (PDOException $e) {
            return null;
        }
    }

    public function authenticate($user_name, $password)
    {
        $user = $this->getByUserName($user_name);
        if (!$user) return false;

        // Kiểm tra tài khoản có bị khóa không
        if ($user->getIs_active() == 0) {
            return 'locked';
        }

        if (password_verify($password, $user->getPassword())) {
            return $user;
        }
        return false;
    }

    public function createUser($data)
    {
        // Hash password nếu có
        if (isset($data['password']) && !empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        // Gọi Insert() từ BaseModel
        return $this->Insert($data);
    }

    public function getUser_id()
    {
        return $this->user_id;
    }

    public function validate($data)
    {
        $errors = [];
        if ($err = Validator::is_isset($data->user_name, "Tên đăng nhập không tồn tại"))
            $errors['user_name'] = $err;
        elseif ($err = Validator::required($data->user_name, "Tên đăng nhập không được để trống"))
            $errors['user_name'] = $err;

        if ($err = Validator::is_isset($data->password, "Mật khẩu không tồn tại"))
            $errors['password'] = $err;
        elseif ($err = Validator::required($data->password, "Mật khẩu không được để trống"))
            $errors['password'] = $err;

        if ($err = Validator::is_isset($data->full_name, "Họ và tên không tồn tại"))
            $errors['full_name'] = $err;
        elseif ($err = Validator::required($data->full_name, "Họ và tên không được để trống"))
            $errors['full_name'] = $err;

        if ($err = Validator::is_isset($data->phone_number, "Số điện thoại không tồn tại"))
            $errors['phone_number'] = $err;
        elseif ($err = Validator::required($data->phone_number, "Số điện thoại không được để trống"))
            $errors['phone_number'] = $err;
        elseif ($err = Validator::numeric($data->phone_number, "Số điện thoại phải là số"))
            $errors['phone_number'] = $err;

        if ($err = Validator::is_isset($data->address, "Địa chỉ không tồn tại"))
            $errors['address'] = $err;
        elseif ($err = Validator::required($data->address, "Địa chỉ không được để trống"))
            $errors['address'] = $err;

        if ($err = Validator::is_isset($data->city, "Tỉnh/Thành phố không tồn tại"))
            $errors['city'] = $err;
        elseif ($err = Validator::required($data->city, "Tỉnh/Thành phố không được để trống"))
            $errors['city'] = $err;

        return $errors;
    }

    public function getUser_name()
    {
        return $this->user_name;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function getFull_name()
    {
        return $this->full_name;
    }

    public function getPhone_number()
    {
        return $this->phone_number;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getAddress()
    {
        return $this->address;
    }

    public function getCity()
    {
        return $this->city;
    }

    public function getAvatar_url()
    {
        return $this->avatar_url;
    }

    public function getIs_active()
    {
        return $this->is_active;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setUser_id($user_id)
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function setUser_name($user_name)
    {
        $this->user_name = $user_name;

        return $this;
    }

    public function setPassword($password)
    {
        $this->password = $password;

        return $this;
    }

    public function setFull_name($full_name)
    {
        $this->full_name = $full_name;

        return $this;
    }

    public function setPhone_number($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    public function setAddress($address)
    {
        $this->address = $address;

        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function setAvatar_url($avatar_url)
    {
        $this->avatar_url = $avatar_url;

        return $this;
    }

    public function setIs_active($is_active)
    {
        $this->is_active = $is_active;

        return $this;
    }
}
