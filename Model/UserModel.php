<?php
include_once __DIR__ . '/../core/BaseModel.php';
include_once __DIR__ . '/../core/Validator.php';
class UserModel extends BaseModel
{
    public const TB_NAME = "users";
    protected $user_id;
    protected $username;
    protected $password;
    protected $full_name;
    protected $phone_number;
    protected $address;
    protected $city;
    protected $avatar_url;
    protected $is_active;
    protected $created_at;

    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);
        if (!empty($data)) {
            $this->user_id      = $data['user_id'] ?? null;
            $this->username     = $data['username'] ?? null;
            $this->password     = $data['password'] ?? null;
            $this->full_name    = $data['full_name'] ?? null;
            $this->phone_number = $data['phone_number'] ?? null;
            $this->address      = $data['address'] ?? null;
            $this->city         = $data['city'] ?? null;
            $this->avatar_url   = $data['avatar_url'] ?? null;
            $this->is_active    = $data['is_active'] ?? null;
            $this->created_at   = $data['created_at'] ?? null;
        }
    }
}