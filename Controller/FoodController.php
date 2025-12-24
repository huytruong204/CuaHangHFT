<?php

class FoodController
{
    public $foodModel;
    public function __construct()
    {
        $this->foodModel = new FoodModel();
    }

    public function Index()
    {
        $rows_per_page = -1;
        $offset = 0;

        $where_clauses = [
            'foods.food_name' => $_GET['keyword'] ?? '',
            'foods.category_id' => $_GET['cat_filter'] ?? '',
        ];
        $where_clauses = array_filter($where_clauses);

        $sort_price = $_GET['price_sort'] ?? 'desc';

        $all_foods = $this->foodModel->getAll($offset, $rows_per_page, $where_clauses, $sort_price);
        $grouped_foods = [];
        if (!empty($all_foods)) {
            foreach ($all_foods as $food) {
                $cat_name = $food->getCategory_id();
                $grouped_foods[$cat_name][] = $food;
            }
        }

        $cat = new CategoryModel();
        $list_cat = $cat->getAllCategories();

        $msg = SessionManager::flash('success');
        include_once "View/Food/Index.php";
    }
    public function Detail()
    {
        if (!isset($_GET['food_id'])) {
            header("Location: index.php?page=Food");
            exit();
        }
        $msg = SessionManager::flash('success');
        $food_id = $_GET['food_id'];
        $food = $this->foodModel->getDetail($food_id);
        $price_format = number_format($food->getPrice(), 0, ',', '.') . ' đ';
        $reviewModel = new ReviewModel();
        $reviews = [];
        $ratingInfo = ['avg' => 0.0, 'count' => 0];
        if (!empty($food_id)) {
            $reviews = $reviewModel->getReviewsByFood($food_id);
            $ratingInfo = $reviewModel->getAvgRatingByFood($food_id);
        }
        include_once "View/Food/Detail.php";
    }
}
