<?php
include_once __DIR__ . '/../core/BaseModel.php';
include_once __DIR__ . '/../core/Validator.php';
class CategoryModel extends BaseModel
{
    public const TB_NAME = "categories";
    protected $category_id;
    protected $category_name;
    protected $description;
    protected $created_at;

    public function __construct($data = [])
    {
        parent::__construct(self::TB_NAME);
        if (!empty($data)) {
            $this->category_id   = $data['category_id'] ?? null;
            $this->category_name = $data['category_name'] ?? null;
            $this->description   = $data['description'] ?? null;
            $this->created_at    = $data['created_at'] ?? null;
        }
    }
    
    public function getAllCategories()
    {
        try {
            $categories = [];
            $sql = "SELECT * FROM " . self::TB_NAME . " ORDER BY created_at DESC";

            $stmt = $this->db->prepare($sql);

            $stmt->execute();

            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            foreach ($results as $row) {
                $categories[] = new CategoryModel($row);
            }
            return $categories;
        } catch (PDOException $e) {
            $this->error_message= "Lỗi: " . $e->getMessage();
            return [];
        }
    }

    public function getAll($offset, $rows_per_page, $where_clauses)
    {
        try {
            $categories = [];
            $sql = "SELECT * FROM " . self::TB_NAME;

            $sql_clauses_arr = [];
            $values = [];
            if (!empty($where_clauses)) {
                foreach ($where_clauses as $column => $value) {
                    if ($column == 'category_name' || $column == 'categories.category_name') {
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
                $categories[] = new CategoryModel($row);
            }
            return $categories;
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
    
    public function getDetail($category_id)
    {
        try {
            $sql = "SELECT * FROM " . self::TB_NAME . " WHERE category_id = ? LIMIT 1";

            $stmt = $this->db->prepare($sql);

            $stmt->execute([$category_id]);

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $categories = new CategoryModel($data);
            return $categories;
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
    public function validate($data)
    {
        $errors = [];
        if ($err = Validator::is_isset($data->category_name, "Tên danh mục không tồn tại"))
            $errors['category_name'] = $err;
        elseif ($err = Validator::required($data->category_name, "Tên danh mục không được để trống"))
            $errors['category_name'] = $err;

        if ($err = Validator::is_isset($data->description, "Mô tả không tồn tại"))
            $errors['description'] = $err;
        elseif ($err = Validator::required($data->description, "Mô tả không được để trống"))
            $errors['description'] = $err;
        return $errors;
    }
    
    public function getCategory_id()
    {
        return $this->category_id;
    }

    public function getCategory_name()
    {
        return $this->category_name;
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function getCreated_at()
    {
        return $this->created_at;
    }

    public function setCategory_id($category_id)
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function setCategory_name($category_name)
    {
        $this->category_name = $category_name;

        return $this;
    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}
?>