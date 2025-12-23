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
        $rows_per_page = 1;
        $current_page = isset($_GET['p']) ? $_GET['p'] : 1;

        $where_clauses = [
            'foods.food_name' => $_GET['keyword'] ?? '',
            'foods.category_id' => $_GET['cat_filter'] ?? '',
        ];
        $where_clauses = array_filter($where_clauses);

        $count_rows = $this->foodModel->CountRows($where_clauses);
        $total_pages = ceil($count_rows / $rows_per_page);

        $offset = ($current_page - 1) * $rows_per_page;
        $sort_price = $_GET['price_sort'] ?? 'desc';
        $list_foods = $this->foodModel->getAll($offset, $rows_per_page, $where_clauses, $sort_price);

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
        
        include_once "View/Food/Detail.php";
    }
}
