<?php
include_once "../Model/FoodModel.php";

class FoodAdminController
{
    public $foodModel;
    public function __construct()
    {
        $this->foodModel = new FoodModel();
    }

    public function Index()
    {
        $list_foods = $this->foodModel->getAll();
        include_once "View/FoodAdmin/Index.php";
    }

    public function CreateGet()
    {
        include_once "View/FoodAdmin/Create.php";
    }

    public function CreatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'food_id'     => trim($_POST['food_id'] ?? ''),     
                'category_id' => $_POST['category_id'] ?? '',
                'food_name'   => trim($_POST['food_name'] ?? ''),    
                'description' => trim($_POST['description'] ?? ''),  
                'price'       => trim($_POST['price']) ?? '',
                'status'      => $_POST['status'] ?? '',
                'image_url'   => 'anh1'
            ];
            $errors = $this->foodModel->validate(new FoodModel($data));
            if (empty($errors)) {
                $result = $this->foodModel->Insert($data);
                if ($result) {
                    echo "<script>alert('Thêm thành công món ăn $data[food_name]'); window.location.href = 'index.php?page=FoodAdmin';</script>";
                    exit;
                } else {
                    $dbError = $this->foodModel->error_message;
                    echo "<script>alert('$dbError')</script>";
                }
            }
            include_once "View/FoodAdmin/Create.php";
        }
    }
}
