<?php
    class HomeController{
        public function Index(){
            // Prepare data for the home view to avoid view-level model loading
            include_once __DIR__ . '/../Model/CategoryModel.php';
            include_once __DIR__ . '/../Model/FoodModel.php';

            $cm = new CategoryModel();
            $list_cat = $cm->getAllCategories();

            $current_page = isset($_GET['p']) ? intval($_GET['p']) : 1;

            $list_foods = [];
            $fm = new FoodModel();

            if (!empty($_GET['cat_filter'])) {
                $catFilter = $_GET['cat_filter'];
                // load foods for this category (up to 3 items)
                $list_foods = $fm->getAll(0, 3, ['foods.category_id' => $catFilter]);
            } else {
                // default: load recent 6 foods for initial listing
                $list_foods = $fm->getAll(0, 3, []);
            }

            return require_once "./View/Home/Index.php";
        }
    }

?>