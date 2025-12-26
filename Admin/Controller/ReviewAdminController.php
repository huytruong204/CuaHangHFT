<?php

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

        // Validate date inputs: ensure start_date <= end_date
        $msg_error = '';
        $start_raw = isset($_GET['start_date']) ? trim($_GET['start_date']) : '';
        $end_raw = isset($_GET['end_date']) ? trim($_GET['end_date']) : '';
        if ($start_raw !== '' && $end_raw !== '') {
            if (strtotime($start_raw) > strtotime($end_raw)) {
                // Swap and set message
                $tmp = $start_raw;
                $start_raw = $end_raw;
                $end_raw = $tmp;
                $msg_error = 'Ngày bắt đầu không được lớn hơn ngày kết thúc. Đã hoán đổi tự động.';
            }
        }

        // Keyword can match food name or user full_name
        if (!empty($_GET['keyword'])) {
            $kw = '%' . trim($_GET['keyword']) . '%';
            $filters[] = "(f.food_name LIKE ? OR u.full_name LIKE ?)"; $params[] = $kw; $params[] = $kw;
        }

        if (isset($_GET['rating']) && $_GET['rating'] !== '') {
            $filters[] = "r.rating = ?";
            $params[] = (int)$_GET['rating'];
        }

        if (!empty($start_raw)) {
            $filters[] = "r.created_at >= ?";
            $params[] = $start_raw . ' 00:00:00';
        }
        if (!empty($end_raw)) {
            $filters[] = "r.created_at <= ?";
            $params[] = $end_raw . ' 23:59:59';
        }

        $where_sql = '';
        if (!empty($filters)) {
            $where_sql = ' AND ' . implode(' AND ', $filters);
        }

        // Use model methods for count and list (moved SQL into model)
        $filters = [];
        if (!empty($_GET['keyword'])) $filters['keyword'] = $_GET['keyword'];
        if (isset($_GET['rating']) && $_GET['rating'] !== '') $filters['rating'] = $_GET['rating'];
        if (!empty($start_raw)) $filters['start_date'] = $start_raw;
        if (!empty($end_raw)) $filters['end_date'] = $end_raw;

        // expose possible message to view
        if (!empty($msg_error)) {
            $GLOBALS['msg_error'] = $msg_error;
        }

        $total_rows = $this->reviewModel->countForAdmin($filters);
        $total_pages = ($rows_per_page > 0) ? ceil($total_rows / $rows_per_page) : 1;

        $reviews = $this->reviewModel->getListForAdmin($filters, $offset, $rows_per_page);

        include_once "View/ReviewAdmin/Index.php";
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
