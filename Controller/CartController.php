<?php
include_once 'Model/CartModel.php';
class CartController
{
    public function Index(){
        $cart_items = CartModel::getCart();
        $total_amount = CartModel::getTotal();
        include_once "View/Cart/Index.php";
    }
	
    public function AddToCart(){
        if($_SERVER['REQUEST_METHOD'] == "POST"){
            if(isset($_POST['food_id'], $_POST['food_name'], $_POST['quantity'], $_POST['image_url'], $_POST['price'])) {
                
                $cart = new CartModel(
                    $_POST['food_id'], 
                    $_POST['food_name'], 
                    $_POST['quantity'], 
                    $_POST['image_url'], 
                    $_POST['price']
                );
                CartModel::add($cart);
                echo "Đã thêm vào giỏ hàng thành công!";
                header('Location: index.php?page=Food');
            } else {
                echo "Thiếu dữ liệu gửi lên!";
            }
        }
    }
    public function DeleteToCart(){
        $food_id = isset($_GET['food_id']) ? $_GET['food_id'] : '';
        if(!empty($food_id)){
            CartModel::remove($food_id);
            header('Location: index.php?page=Cart');
        }
    }
}
?>