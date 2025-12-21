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
}
