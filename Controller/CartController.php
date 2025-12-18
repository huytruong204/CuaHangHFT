<?php
include_once 'Model/CartModel.php';
include_once 'Helper/SessionManager.php';
class CartController
{
    public function Index()
    {
        $cart_items = CartModel::getCart();
        $total_amount = CartModel::getTotal();
        include_once "View/Cart/Index.php";
    }

    public function AddToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['food_id'], $_POST['food_name'], $_POST['quantity'], $_POST['image_url'], $_POST['price'], $_POST['page'])) {

                $cart = new CartModel(
                    $_POST['food_id'],
                    $_POST['food_name'],
                    $_POST['quantity'],
                    $_POST['image_url'],
                    $_POST['price']
                );
                CartModel::add($cart);
                SessionManager::flash('success', 'Đã thêm vào giỏ hàng!');
                $page = $_POST['page'];

                if ($page == 'Detail') {
                    header("Location: index.php?page=Food&action=Detail&food_id=$cart->food_id");
                } else {
                    header("Location: index.php?page=Food");
                }
                exit();
            } else {
                echo "Thiếu dữ liệu gửi lên!";
            }
        }
    }
    public function UpdateToCart()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $food_id = isset($_POST['food_id']) ? $_POST['food_id'] : '';
            $new_quantity = isset($_POST['quantity']) ? $_POST['quantity'] : '';
            if (!empty($food_id)) {
                CartModel::update($food_id, $new_quantity);
                header('Location: index.php?page=Cart');
            }
        }
    }
    public function DeleteToCart()
    {
        $food_id = isset($_GET['food_id']) ? $_GET['food_id'] : '';
        if (!empty($food_id)) {
            CartModel::remove($food_id);
            header('Location: index.php?page=Cart');
        }
    }
}
