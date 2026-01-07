<?php

class FoodAdminController
{
    public $foodModel;
    public $catModel;
    public function __construct()
    {
        $this->foodModel = new FoodModel();
        $this->catModel = new CategoryModel();
    }

    public function Index()
    {
        $rows_per_page = 10;
        $current_page = isset($_GET['p']) ? $_GET['p'] : 1;
        $where_clauses = [
            'foods.food_name' => $_GET['keyword'] ?? '',
            'foods.category_id' => $_GET['cat_filter'] ?? '',
            'foods.status' => $_GET['status_filter'] ?? '',
        ];

        $where_clauses = array_filter($where_clauses, function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });
        $count_rows = $this->foodModel->CountRows($where_clauses);
        $total_pages = ceil($count_rows / $rows_per_page);
        $offset = ($current_page - 1) * $rows_per_page;
        $sort_price = $_GET['price_sort'] ?? 'desc';
        $list_foods = $this->foodModel->getAll($offset, $rows_per_page, $where_clauses, $sort_price);
        $list_cat = $this->catModel->getAllCategories();
        include_once "View/FoodAdmin/Index.php";
    }


    public function Create()
    {
        $list_cat = $this->catModel->getAllCategories();
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'category_id' => $_POST['category_id'] ?? '',
                'food_name'   => trim($_POST['food_name'] ?? ''),
                'description' => trim($_POST['description'] ?? ''),
                'price'       => trim($_POST['price']) ?? '',
                'status'      => $_POST['status'] ?? '',
            ];
            $errors = $this->foodModel->validate(new FoodModel($data));
            if (empty($errors)) {
                $upload_img = Upload_file::Upload_image($_FILES['image_url'],  "../assets/img/img_foods/");
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
        }
        include_once "View/FoodAdmin/Create.php";
    }

    public function Detail()
    {
        if (!isset($_GET['food_id'])) {
            echo "<script>alert('Khônng tồn tại food_id: $_GET[food_id]')</script>";
            exit;
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
            echo "<script>alert('Không tồn tại food_id: $_GET[food_id]')</script>";
            exit;
        }
        $list_cat = $this->catModel->getAllCategories();
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
                'status'      => $_POST['status'] ?? '',
                'image_url'   => $_POST['old_image'] ?? ''
            ];
            $path = "../assets/img/img_foods/";
            if (!empty($_FILES['image_url']['name'])) {
                $upload_img = Upload_file::Upload_image($_FILES['image_url'], $path);
                if ($upload_img['status'] == true) {
                    $image_old = $path . $data['image_url'];
                    if (file_exists($image_old)) {
                        unlink($image_old);
                    }
                    $data['image_url'] = $upload_img['file_name'];
                } else {
                    $errors['image_url'] = $upload_img['message'];
                    $food = new FoodModel($data);
                    include_once "View/FoodAdmin/Update.php";
                    return;
                }
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
                        window.location.href = 'index.php?page=FoodAdmin&action=UpdateGet&food_id=$food_id';
                      </script>";
                    exit;
                } else {
                    $dbError = $this->foodModel->error_message;
                    echo "<script>alert('Lỗi CSDL: $dbError')</script>";
                }
            }
            $food = $food_update;
            $list_cat = $this->catModel->getAllCategories();
            include_once "View/FoodAdmin/Update.php";
        }
    }
    public function Delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $food_id = $_POST['food_id'];
            $food = $this->foodModel->getDetail($food_id);
            if (empty($food)) {
                echo "<script>alert('Lỗi: Không tìm thấy {$food_id} món ăn này.'); window.location.href='index.php?page=FoodAdmin';</script>";
            }
            $path = "../assets/img/img_foods/" . $food->getImage_url();
            if (file_exists($path)) {
                unlink($path);
            }
            $result = $this->foodModel->Delete('food_id', $food_id);
            if ($result) {
                echo "<script>alert('Đã xóa thành công!'); window.location.href='index.php?page=FoodAdmin';</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể xóa món ăn này.'); window.location.href='index.php?page=FoodAdmin';</script>";
            }
        } else {
            header("Location: index.php?page=FoodAdmin");
        }
    }
}
