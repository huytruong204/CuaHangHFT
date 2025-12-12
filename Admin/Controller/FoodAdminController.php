<?php
include_once "../Model/FoodModel.php";

class FoodAdminController
{
    public function Index()
    {
        return require_once "View/FoodAdmin/Create.php";
    }


    public function Create()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $food = new FoodModel();
            $data = [
                'food_id' => "F001",
                'category_id' => "DM001",
                'food_name'   => "Gà rán",
                'description' => "Ngon, giòn",
                'price'       => 36000000,
                'status'      => 1,
                'image_url' => "ga_ran.jpg"
            ];
            $result = $food->Insert($data);
            if ($result) {
                echo "Thêm thành công {$data['food_id']}";
            } else {
                $dbError = $food->error_message;
                echo "Lỗi Database: " . $dbError;
            }
        }
    }
}
?>