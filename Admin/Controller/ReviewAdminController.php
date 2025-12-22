<?php
include_once __DIR__ . '/../../Model/ReviewModel.php';
include_once __DIR__ . '/../../Model/FoodModel.php';
include_once __DIR__ . '/../../Model/UserModel.php';
include_once __DIR__ . '/../../Helper/SessionManager.php';

class ReviewAdminController
{
    private $reviewModel;
    private $foodModel;
    private $userModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->foodModel = new FoodModel();
        $this->userModel = new UserModel();
    }

    public function Index()
    {
        $rows_per_page = 10;
        $current_page = isset($_GET['p']) ? max(1, (int)$_GET['p']) : 1;
        $offset = ($current_page - 1) * $rows_per_page;

        $filters = [];
        $params = [];

        // Keyword can match food name or user full_name
        if (!empty($_GET['keyword'])) {
            $kw = '%' . trim($_GET['keyword']) . '%';
            $filters[] = "(f.food_name LIKE ? OR u.full_name LIKE ?)"; $params[] = $kw; $params[] = $kw;
        }

        if (isset($_GET['rating']) && $_GET['rating'] !== '') {
            $filters[] = "r.rating = ?";
            $params[] = (int)$_GET['rating'];
        }

        if (!empty($_GET['start_date'])) {
            $filters[] = "r.created_at >= ?";
            $params[] = $_GET['start_date'] . ' 00:00:00';
        }
        if (!empty($_GET['end_date'])) {
            $filters[] = "r.created_at <= ?";
            $params[] = $_GET['end_date'] . ' 23:59:59';
        }

        $where_sql = '';
        if (!empty($filters)) {
            $where_sql = ' AND ' . implode(' AND ', $filters);
        }

        // Use model methods for count and list (moved SQL into model)
        $filters = [];
        if (!empty($_GET['keyword'])) $filters['keyword'] = $_GET['keyword'];
        if (isset($_GET['rating']) && $_GET['rating'] !== '') $filters['rating'] = $_GET['rating'];
        if (!empty($_GET['start_date'])) $filters['start_date'] = $_GET['start_date'];
        if (!empty($_GET['end_date'])) $filters['end_date'] = $_GET['end_date'];

        $total_rows = $this->reviewModel->countForAdmin($filters);
        $total_pages = ($rows_per_page > 0) ? ceil($total_rows / $rows_per_page) : 1;

        $reviews = $this->reviewModel->getListForAdmin($filters, $offset, $rows_per_page);

        include_once "View/ReviewAdmin/Index.php";
    }

    public function UpdateGet()
    {
        if (!isset($_GET['review_id'])) {
            echo "<script>alert('Không tồn tại review_id'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        }
        $review_id = $_GET['review_id'];
        $review = $this->reviewModel->getById($review_id);
        if (!$review) {
            echo "<script>alert('Không tìm thấy đánh giá.'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        }
        include_once "View/ReviewAdmin/Update.php";
    }

    public function UpdatePost()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=ReviewAdmin');
            exit;
        }

        $review_id = $_POST['review_id'] ?? '';
        if (empty($review_id)) {
            echo "<script>alert('Thiếu review_id'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        }

        $data = [
            'rating' => isset($_POST['rating']) ? (int)$_POST['rating'] : null,
            'comment' => trim($_POST['comment'] ?? '')
        ];

        $result = $this->reviewModel->Update(array_filter($data, function($v){ return $v !== null; }), 'review_id', $review_id);
        if ($result) {
            SessionManager::flash('success', 'Cập nhật đánh giá thành công');
            echo "<script>window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        } else {
            $dbError = $this->reviewModel->error_message;
            echo "<script>alert('Lỗi CSDL: $dbError'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        }
    }

    public function Delete()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=ReviewAdmin');
            exit;
        }
        $review_id = $_POST['review_id'] ?? '';
        if (empty($review_id)) {
            echo "<script>alert('Thiếu review_id'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        }

        $deleteResult = $this->reviewModel->Delete('review_id', $review_id);
        if ($deleteResult) {
            echo "<script>alert('Đã xóa đánh giá.'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        } else {
            $dbError = $this->reviewModel->error_message;
            echo "<script>alert('Lỗi khi xóa: $dbError'); window.location.href='index.php?page=ReviewAdmin';</script>";
            exit;
        }
    }
}
