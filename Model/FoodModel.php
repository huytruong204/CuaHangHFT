<?php
include_once '../core/BaseModel.php';
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

        public function __construct($food_id = null,  $category_id = null,  $food_name = null,  $description = null,  $price = null,  $image_url = null,  $status = null, $created_at=null)
        {
                parent::__construct(self::TB_NAME);
                $this->food_id = $food_id;
                $this->category_id = $category_id;
                $this->food_name = $food_name;
                $this->description = $description;
                $this->price = $price;
                $this->image_url = $image_url;
                $this->status = $status;
                $this->created_at = $created_at;
        }

        public function getAll()
        {
                try {
                        $list_foods = [];
                        $stmt = $this->db->query("SELECT * FROM " . self::TB_NAME . " join categories on " . self::TB_NAME . ".category_id = categories.category_id WHERE status = 1");
                        $stmt->setFetchMode(PDO::FETCH_ASSOC);
                        while ($row = $stmt->fetch()) {
                                $list_foods[] = new FoodModel($row['food_id'], $row['category_name'], $row['food_name'], $row['description'], $row['price'], $row['image_url'], $row['status'], $row['created_at']);
                        }
                        return $list_foods;
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
