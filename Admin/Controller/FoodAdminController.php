<?php
include_once "../Model/FoodModel.php";
include_once "../Helper/Upload_file.php";
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
            ];
            $errors = $this->foodModel->validate(new FoodModel($data));
            if (empty($errors)) {
                $upload_img = Helper::Upload_image($_FILES['image_url'],  "../assets/img/img_foods/");
                if($upload_img['status'] == true)
                {
                    $img_url = $upload_img['file_name'];
                    $data['image_url'] = $img_url;
                    $result = $this->foodModel->Insert($data);
                    if ($result) {
                        echo "<script>alert('Thêm thành công món ăn $data[food_name]'); window.location.href = 'index.php?page=FoodAdmin';</script>";
                        exit;
                    } else {
                        $dbError = $this->foodModel->error_message;
                        echo "<script>alert('$dbError')</script>";
                    }
                } else{
                    $errors['image_url'] = $upload_img['message'];
                }
            }
            include_once "View/FoodAdmin/Create.php";
        }
    }
}
