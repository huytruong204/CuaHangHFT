<?php
class OrderController
{
    public $orderModel;
    public $orderItemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function Index()
    {
        $rows_per_page = 4;
        $current_page = isset($_GET['p']) ? $_GET['p'] : 1;
        $where_clauses = [
            'orders.user_id' => 1 //$_SESSION['user_id'],
        ];

        $where_clauses = array_filter($where_clauses);

        $count_rows = $this->orderModel->CountRows($where_clauses);
        $total_pages = ceil($count_rows / $rows_per_page);

        $offset = ($current_page - 1) * $rows_per_page;
        $sort_price = $_GET['price_sort'] ?? 'desc';
        $orders = $this->orderModel->getAll($offset, $rows_per_page, $where_clauses, $sort_price);
        $msg = SessionManager::flash('success');
        include_once "View/Order/Index.php";
    }

    public function Detail(){
        if (!isset($_GET['order_id'])) {
            header("Location: index.php?page=Order");
            exit();
        }
        $order_id = $_GET['order_id'];
        $order = $this->orderModel->getOrderById($order_id);
    
        $items =  $this->orderItemModel->getOrderItems($order_id);
        include_once "View/Order/Detail.php";
    }
}
