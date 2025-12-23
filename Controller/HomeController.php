<?php
class HomeController
{
    public function Index()
    {
        $msg = SessionManager::flash("success");
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

        // prepare combo foods for gallery (up to 4 items)
        // use categories.category_name to avoid coupling to numeric id
        $comboFoods = $fm->getAll(0, 4, ['categories.category_name' => 'Combo', 'foods.status' => 1]);

        // determine combo category id for nav active state
        $comboCatId = null;
        if (!empty($list_cat)) {
            foreach ($list_cat as $c) {
                if (strtolower(trim($c->getCategory_name())) === 'combo') {
                    $comboCatId = $c->getCategory_id();
                    break;
                }
            }
        }

        return require_once "./View/Home/Index.php";
    }
}
