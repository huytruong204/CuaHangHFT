<?php
include_once __DIR__ . '/../Model/ReviewModel.php';
include_once __DIR__ . '/../Model/OrderModel.php';
include_once __DIR__ . '/../Model/FoodModel.php';
include_once __DIR__ . '/../Helper/SessionManager.php';

class ReviewController
{
    private $reviewModel;
    private $orderModel;
    private $foodModel;

    public function __construct()
    {
        $this->reviewModel = new ReviewModel();
        $this->orderModel = new OrderModel();
        $this->foodModel = new FoodModel();
    }

    // Show review form
    public function Index()
    {
        $product_id = $_GET['product_id'] ?? '';
        $order_id = $_GET['order_id'] ?? '';

        // Ensure user is logged in via model helper
        $user_id = $this->reviewModel->requireLogin();

        // Delegate business validation (order ownership/status/item/duplicate) to model
        $check = ['user_id' => $user_id, 'food_id' => $product_id, 'order_id' => $order_id];
        $errors = $this->reviewModel->validate($check, 'view');
        if (!empty($errors)) {
            // if duplicate review exists, allow user to view/edit their review instead of redirecting
            if (isset($errors['duplicate'])) {
                $existing = $this->reviewModel->getByUserOrderFood($user_id, $product_id, $order_id);
                if ($existing) {
                    $review = $existing;
                    $food = $this->foodModel->getDetail($product_id);
                    $mode = 'view';
                    include_once __DIR__ . '/../View/Review/Index.php';
                    return;
                }
            }
            SessionManager::flash('error', array_values($errors)[0]);
            header("Location: index.php?page=Order&action=Detail&order_id=$order_id");
            exit;
        }

        $food = $this->foodModel->getDetail($product_id);

        include_once __DIR__ . '/../View/Review/Index.php';
    }

    // Handle review submission
    public function Create()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: index.php?page=Order');
            exit;
        }

        $user_id = $this->reviewModel->requireLogin();

        $product_id = $_POST['product_id'] ?? '';
        $order_id = $_POST['order_id'] ?? '';
        $rating = isset($_POST['rating']) ? (int)$_POST['rating'] : 0;
        $comment = trim($_POST['comment'] ?? '');

        // prepare data and delegate validation to model
        

        $data = [
            'user_id' => $user_id,
            'food_id' => $product_id,
            'order_id' => $order_id,
            'rating' => $rating,
            'comment' => $comment
        ];

        // Delegate validation+create to model; model will redirect on success
        $result = $this->reviewModel->createAndRedirect($data);
        if (!$result['success']) {
            $errors = $result['errors'];
            $food = $this->foodModel->getDetail($product_id);
            $old = ['rating' => $rating, 'comment' => $comment];
            include_once __DIR__ . '/../View/Review/Index.php';
            exit;
        }
    }

    // Show edit form for an existing review (user-facing)
    public function Edit()
    {
        $review_id = $_GET['review_id'] ?? '';
        if (empty($review_id)) {
            header('Location: index.php?page=Order'); exit;
        }
        $user_id = $this->reviewModel->requireLogin();
        $review = $this->reviewModel->getById($review_id);
        if (!$review || $review['user_id'] != $user_id) {
            SessionManager::flash('error','Không tìm thấy đánh giá hoặc bạn không có quyền.');
            header('Location: index.php?page=Order'); exit;
        }
        $food = $this->foodModel->getDetail($review['food_id']);
        $mode = 'edit';
        include_once __DIR__ . '/../View/Review/Index.php';
    }

    // Handle update of an existing review
    public function Update()
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') { header('Location: index.php?page=Order'); exit; }
        // debug hook: capture that Update was invoked
        SessionManager::flash('__debug_update_called', true);
        $user_id = $this->reviewModel->requireLogin();
        $review_id = $_POST['review_id'] ?? '';
        if (empty($review_id)) { SessionManager::flash('error','Thiếu review_id'); header('Location: index.php?page=Order'); exit; }
        // ensure ownership
        $existing = $this->reviewModel->getById($review_id);
        if (!$existing || $existing['user_id'] != $user_id) { SessionManager::flash('error','Không có quyền sửa.'); header('Location: index.php?page=Order'); exit; }

        $data = ['rating' => isset($_POST['rating']) ? (int)$_POST['rating'] : $existing['rating'], 'comment' => trim($_POST['comment'] ?? '')];
        $res = $this->reviewModel->Update(array_filter($data, function($v){ return $v !== null; }), 'review_id', $review_id);
        if ($res) {
            SessionManager::flash('success','Cập nhật đánh giá thành công');
            // After updating, redirect back to the order detail page so user returns to their order
            $order_id = $existing['order_id'] ?? ($_POST['order_id'] ?? '');
            if (!empty($order_id)) {
                header('Location: index.php?page=Order&action=Detail&order_id=' . urlencode($order_id));
            } else {
                header('Location: index.php?page=Order');
            }
            exit;
        } else {
            $food = $this->foodModel->getDetail($existing['food_id']);
            $review = $this->reviewModel->getById($review_id);
            $mode = 'edit';
            $errors = ['db' => $this->reviewModel->error_message];
            include_once __DIR__ . '/../View/Review/Index.php';
            exit;
        }
    }
}
