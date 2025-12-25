<?php
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
        // if (empty(SessionManager::get('user_name'))) {
        //     header("Location: index.php?page=SignIn&action=login");
        //     exit();
        // }
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
                } elseif ($page == 'Home') {
                    header("Location: index.php");
                } else {
                    header("Location: index.php?page=Food");
                }
                exit();
            } else {
                echo "Thiếu dữ liệu gửi lên!";
            }
        } else {
            header('Location: index.php?page=Cart');
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
        } else {
            header('Location: index.php?page=Cart');
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

    public function Checkout()
    {
        if (empty(SessionManager::get('user_name'))) {
            SessionManager::set('redirect_after_login', 'index.php?page=Cart&action=Checkout');
            header("Location: index.php?page=SignIn&action=login");
            exit();
        }
        $cart_items = CartModel::getCart();
        $total_amount = CartModel::getTotal();
        $user_model = new UserModel();
        $user = $user_model->getByUserName(SessionManager::get('user_name'));

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $cart_items = CartModel::getCart();
            try {
                $order = new OrderModel();
                $db = $order->getDb();
                $db->beginTransaction();

                $payment_status = $_POST['payment_method'] == 'cod' ? 0 : 1;
                $data = [
                    'note' => $_POST['note'] ?? '',
                    'user_id' => SessionManager::get('user_id'),
                    'fullname' => $_POST['fullname'] ?? '',
                    'phone_number' => $_POST['phone_number'] ?? '',
                    'address' => $_POST['address'] ?? '',
                    'total_money' => CartModel::getTotal(),
                    'payment_method' => $_POST['payment_method'] ?? '',
                    'payment_status' => $payment_status,
                    'status' => 'Chờ xác nhận',
                ];

                $errors = $order->validateUser(new OrderModel($data));

                if (empty($errors)) {
                    $order_id = $order->Insert($data);
                    $orderItemModel = new BaseModel('order_items');
                    foreach ($cart_items as $item) {
                        $itemData = [
                            'order_id' => $order_id,
                            'food_id' => $item->food_id,
                            'quantity' => $item->quantity,
                            'price_at_purchase' => $item->price
                        ];
                        $orderItemModel->Insert($itemData);
                    }
                    $db->commit();
                    CartModel::clear();
                    SessionManager::flash('success', 'Đặt hàng thành công! Mã đơn: #' . $order_id);
                    header('Location: index.php?page=Order');
                    exit();
                }
            } catch (PDOException $e) {
                $db->getDb()->rollBack();
                SessionManager::flash('error', 'Có lỗi xảy ra: ' . $e->getMessage());
            }
        }
        include_once "./View/Cart/Checkout.php";
    }
}
