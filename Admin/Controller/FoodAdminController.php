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
                if ($upload_img['status'] == true) {
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
                } else {
                    $errors['image_url'] = $upload_img['message'];
                }
            }
            include_once "View/FoodAdmin/Create.php";
        }
    }

    public function Detail()
    {
        if (!isset($_GET['food_id'])) {
            echo "<script>alert('Khônng tồn tại food_id: $_GET[food_id]')</script>";
        }
        $food_id = $_GET['food_id'];
        $food = $this->foodModel->getDetail($food_id);
        $price_format = number_format($food->getPrice(), 0, ',', '.') . ' VNĐ';
        $status_badge = ($food->getStatus() == 1)
            ? '<span class="badge bg-success rounded-pill px-3">Đang bán</span>'
            : '<span class="badge bg-danger rounded-pill px-3">Ngừng bán</span>';
        include_once "View/FoodAdmin/Detail.php";
    }

    public function UpdateGet()
    {
        if (!isset($_GET['food_id'])) {
            echo "<script>alert('Khônng tồn tại food_id: $_GET[food_id]')</script>";
            exit;
        }
        $food_id = $_GET['food_id'];
        $food = $this->foodModel->getDetail($food_id);
        include_once "View/FoodAdmin/Update.php";
    }
    public function UpdatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'food_id'     => trim($_POST['food_id'] ?? ''),
                'category_id' => $_POST['category_id'] ?? '',
                'food_name'   => trim($_POST['food_name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price'       => trim($_POST['price']) ?? '',
                'status'      => $_POST['status'] ?? ''
            ];

            if (!empty($_FILES['image_url']['name'])) {
                $upload_img = Helper::Upload_image($_FILES['image_url'], "../assets/img/img_foods/");

                if ($upload_img['status'] == true) {
                    $data['image_url'] = $upload_img['file_name'];
                } else {
                    $errors['image_url'] = $upload_img['message'];
                    $food = new FoodModel($data);
                    include_once "View/FoodAdmin/Update.php";
                    return;
                }
            } else {
                $data['image_url'] = $_POST['old_image'] ?? '';
            }

            $food_update = new FoodModel($data);
            $errors = $this->foodModel->validate($food_update);

            if (empty($errors)) {
                $food_id = $data['food_id'];
                unset($data['food_id']);
                $result = $this->foodModel->Update($data, 'food_id', $food_id);
                if ($result) {
                    echo "<script>
                        alert('Cập nhật thành công món ăn: {$data['food_name']}'); 
                        window.location.href = 'index.php?page=FoodAdmin';
                      </script>";
                    exit;
                } else {
                    $dbError = $this->foodModel->error_message;
                    echo "<script>alert('Lỗi CSDL: $dbError')</script>";
                }
            }
            $food = $food_update;
            include_once "View/FoodAdmin/Update.php";
        }
    }
}
