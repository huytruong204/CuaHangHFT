<?php
include_once __DIR__ ."/../Helper/SessionManager.php";
class CartModel
{
    public $food_id;
    public $food_name;
    public $quantity;
    public $image_url;
    public $price;

    public function __construct($food_id,  $food_name,  $quantity,  $image_url,  $price)
    {
        $this->food_id = $food_id;
        $this->food_name = $food_name;
        $this->quantity = $quantity;
        $this->image_url = $image_url;
        $this->price = $price;
    }

    public static function getCart()
    {
        return SessionManager::get('cart', []);
    }
    public static function add(CartModel $item){
        $cart = self::getCart();
        if(isset($cart[$item->food_id])){
            $cart[$item->food_id]->quantity += $item->quantity; 
        }else{
            $cart[$item->food_id] = $item;
        }
        SessionManager::set('cart', $cart);
    }
    public static function update($food_id, $new_qty)
    {
        $cart = self::getCart();
        
        if (isset($cart[$food_id])) {
            if ($new_qty > 0) {
                $cart[$food_id]->quantity = $new_qty;
            } else {
                unset($cart[$food_id]);
            }
            SessionManager::set('cart', $cart);
        }
    }
    public static function remove($food_id)
    {
        $cart = self::getCart();
        if (isset($cart[$food_id])) {
            unset($cart[$food_id]);
            SessionManager::set('cart', $cart);
        }
    }
    public static function getTotal()
    {
        $cart = self::getCart();
        $total = 0;
        foreach ($cart as $item) {
            $total += $item->price * $item->quantity;
        }
        return $total;
    }
    public static function clear()
    {
        SessionManager::remove('cart');
    }
}
