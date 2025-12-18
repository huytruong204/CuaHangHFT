<?php
include_once __DIR__ . '/../../Model/CategoryModel.php';

class CategoryAdminController
{
    public $categoryModel;

    public function __construct()
    {
        $this->categoryModel = new CategoryModel();
    }

    public function Index()
    {
        $rows_per_page = 10;
        $current_page = isset($_GET['p']) ? (int)$_GET['p'] : 1;

        $where_clauses = [
            'category_name' => $_GET['keyword'] ?? ''
        ];
        $where_clauses = array_filter($where_clauses, function ($value) {
            return ($value !== null && $value !== false && $value !== '');
        });

        $count_rows = $this->categoryModel->CountRows($where_clauses);
        $total_pages = ($rows_per_page > 0) ? ceil($count_rows / $rows_per_page) : 1;

        $offset = ($current_page - 1) * $rows_per_page;

        $list_categories = $this->categoryModel->getAll($offset, $rows_per_page, $where_clauses);

        include_once "View/CategoryAdmin/Index.php";
    }

    public function CreateGet()
    {
        include_once "View/CategoryAdmin/Create.php";
    }

    public function CreatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $data = [
                'category_name' => trim($_POST['category_name'] ?? ''),
                'description'   => trim($_POST['description'] ?? ''),
            ];
            $errors = $this->categoryModel->validate(new CategoryModel($data));
            if (empty($errors)) {
                $result = $this->categoryModel->Insert($data);
                if ($result) {
                    echo "<script>alert('Thêm thành công danh mục $data[category_name]'); window.location.href = 'index.php?page=CategoryAdmin';</script>";
                    exit;
                } else {
                    $dbError = $this->categoryModel->error_message;
                    echo "<script>alert('$dbError')</script>";
                }
            } else {
                include_once "View/CategoryAdmin/Create.php";
            }
        }
    }

    public function UpdateGet()
    {
        if (!isset($_GET['category_id'])) {
            echo "<script>alert('Không tồn tại category_id: $_GET[category_id]')</script>";
            exit;
        }
        $category_id = $_GET['category_id'];
        $category = $this->categoryModel->getDetail($category_id);
        include_once "View/CategoryAdmin/Update.php";
    }

    public function UpdatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $category_id = $_POST['category_id'];
            $data = [
                'category_name' => trim($_POST['category_name'] ?? ''),
                'description'   => trim($_POST['description'] ?? ''),
            ];
            $errors = $this->categoryModel->validate(new CategoryModel($data));
            if (empty($errors)) {
                $result = $this->categoryModel->Update($data, 'category_id', $category_id);
                if ($result) {
                    echo "<script>alert('Cập nhật thành công danh mục $data[category_name]'); window.location.href = 'index.php?page=CategoryAdmin';</script>";
                    exit;
                } else {
                    $dbError = $this->categoryModel->error_message;
                    echo "<script>alert('$dbError')</script>";
                }
            }
            $category = $this->categoryModel->getDetail($category_id);
            include_once "View/CategoryAdmin/Update.php";
        }
    }

    public function Delete()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $category_id = $_POST['category_id'];
            $result = $this->categoryModel->getDetail($category_id);
            if (empty($result)) {
                echo "<script>alert('Lỗi: Không tìm thấy {$category_id} danh mục này.'); window.location.href = 'index.php?page=CategoryAdmin';</script>";
            }
            $deleteResult = $this->categoryModel->Delete('category_id', $category_id);
            if ($deleteResult) {
                echo "<script>alert('Đã xóa thành công!'); window.location.href = 'index.php?page=CategoryAdmin';</script>";
            } else {
                echo "<script>alert('Lỗi: Không thể xóa danh mục này'); window.location.href = 'index.php?page=CategoryAdmin';</script>";
            }
        } else{
            header("Location: index.php?page=CategoryAdmin");
        }
    }
}