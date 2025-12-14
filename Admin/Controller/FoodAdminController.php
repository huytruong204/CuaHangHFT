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

    public function CreateGet(){
        include_once "View/FoodAdmin/Create.php";
    }
    
    public function CreatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'food_id' => "F001",
                'category_id' => "DM001",
                'food_name'   => "Gà rán",
                'description' => "Ngon, giòn",
                'price'       => 36000000,
                'status'      => 1,
                'image_url' => "ga_ran.jpg"
            ];
            $result = $this->foodModel->Insert($data);
            if ($result) {
                echo "Thêm thành công {$data['food_id']}";
            } else {
                $dbError = $this->foodModel->error_message;
                echo "Lỗi Database: " . $dbError;
            }
        }
    }
}
?>