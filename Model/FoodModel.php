<?php
include_once __DIR__ .'/../core/BaseModel.php';
include_once __DIR__ .'/../core/Validator.php';
class FoodModel extends BaseModel
{
        public const TB_NAME = "foods";
        protected $food_id;
        protected $category_id;
        protected $food_name;
        protected $description;
        protected $price;
        protected $image_url;
        protected $status;
        protected $created_at;

        public function __construct($data = [])
        {
                parent::__construct(self::TB_NAME);
                if (!empty($data)) {
                        $this->food_id     = $data['food_id'] ?? null;
                        $this->category_id = $data['category_id'] ?? null;
                        $this->food_name   = $data['food_name'] ?? null;
                        $this->description = $data['description'] ?? null;
                        $this->price       = $data['price'] ?? null;
                        $this->image_url   = $data['image_url'] ?? null;
                        $this->status      = $data['status'] ?? null;
                        $this->created_at  = $data['created_at'] ?? null;
                }
        }

        public function getAll($offset, $rows_per_page, $where_clauses, $sort_price = 'desc')
        {
                try {
                        $list_foods = [];
                        $sql = "SELECT foods.*, categories.category_name 
                                FROM " . self::TB_NAME . " 
                                JOIN categories ON " . self::TB_NAME . ".category_id = categories.category_id";
                        $sql_clauses_arr = [];
                        $values = [];
                        if (!empty($where_clauses)) {
                                foreach ($where_clauses as $column => $value) {
                                        if ($column == 'foods.food_name') {
                                                $sql_clauses_arr[] = "$column LIKE ?";
                                                $values[] = "%$value%";
                                        } else {
                                                $sql_clauses_arr[] = "$column = ?";
                                                $values[] = $value;
                                        }
                                }
                                $sql .= " WHERE " . implode(" AND ", $sql_clauses_arr);
                        }

                        $sort_direction = (strtolower($sort_price) === 'asc') ? 'ASC' : 'DESC';

                        if (!empty($_GET['price_sort'])) {
                                $sql .= " ORDER BY foods.price $sort_direction";
                        } else {
                                $sql .= " ORDER BY foods.created_at DESC";
                        }

                       if ($rows_per_page > 0) {
                                $sql .= " LIMIT $offset, $rows_per_page";
                        }

                        $stmt = $this->db->prepare($sql);

                        $stmt->execute($values);

                        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

                        foreach ($data as $value) {
                                $value['category_id'] = $value['category_name'];
                                $list_foods[] = new FoodModel($value);
                        }

                        return $list_foods;
                } catch (PDOException $e) {
                        $this->error_message = "Lỗi: " . $e->getMessage();
                        return [];
                }
        }
        public function CountRows($where_clauses)
        {
                try {
                        $sql = "SELECT COUNT(*) FROM " . $this->table_name . " JOIN categories ON " . $this->table_name . ".category_id = categories.category_id";

                        $sql_clauses_arr = [];
                        $values = [];

                        if (!empty($where_clauses)) {
                                foreach ($where_clauses as $column => $value) {
                                        if ($column == 'foods.food_name') {
                                                $sql_clauses_arr[] = "$column LIKE ?";
                                                $values[] = "%$value%";
                                        } else {
                                                $sql_clauses_arr[] = "$column = ?";
                                                $values[] = $value;
                                        }
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
        public function getDetail($food_id)
        {
                try {
                        $stmt = $this->db->prepare("SELECT foods.*, categories.category_name FROM " . self::TB_NAME . " join categories on " . self::TB_NAME . ".category_id = categories.category_id WHERE food_id = ?");
                        $stmt->execute([$food_id]);
                        $data = $stmt->fetch(PDO::FETCH_ASSOC);
                        $data['category_id'] = $data['category_name'];
                        $foods = new FoodModel($data);
                        return $foods;
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

                if ($err = Validator::is_isset($data->food_name, "Tên món ăn không tồn tại"))
                        $errors['food_name'] = $err;
                elseif ($err = Validator::required($data->food_name, "Tên món ăn không được để trống"))
                        $errors['food_name'] = $err;

                if ($err = Validator::is_isset($data->description, "Mô tả không tồn tại"))
                        $errors['description'] = $err;
                elseif ($err = Validator::required($data->description, "Mô tả không được để trống"))
                        $errors['description'] = $err;

                if ($err = Validator::is_isset($data->price, "Giá bán không tồn tại"))
                        $errors['price'] = $err;
                elseif ($err = Validator::required($data->price, "Giá bán không được để trống"))
                        $errors['price'] = $err;
                elseif ($err = Validator::numeric($data->price, "Giá bán phải là số"))
                        $errors['price'] = $err;

                return $errors;
        }

        public function getFood_id()
        {
                return $this->food_id;
        }


        public function setFood_id($food_id)
        {
                $this->food_id = $food_id;

                return $this;
        }

        public function getCategory_id()
        {
                return $this->category_id;
        }


        public function setCategory_id($category_id)
        {
                $this->category_id = $category_id;

                return $this;
        }

        public function getFood_name()
        {
                return $this->food_name;
        }

        public function setFood_name($food_name)
        {
                $this->food_name = $food_name;

                return $this;
        }

        public function getDescription()
        {
                return $this->description;
        }


        public function setDescription($description)
        {
                $this->description = $description;

                return $this;
        }

        public function getPrice()
        {
                return $this->price;
        }


        public function setPrice($price)
        {
                $this->price = $price;

                return $this;
        }

        public function getImage_url()
        {
                return $this->image_url;
        }

        public function setImage_url($image_url)
        {
                $this->image_url = $image_url;

                return $this;
        }

        public function getStatus()
        {
                return $this->status;
        }


        public function setStatus($status)
        {
                $this->status = $status;

                return $this;
        }

        public function getCreated_at()
        {
                return $this->created_at;
        }
}
