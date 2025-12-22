<?php
class OrderController
{
    public $orderModel;
    public $orderItemModel;
    const STATUS_MAP = [
            'wait'        => 'Chờ xác nhận',
            'confirmed'   => 'Đã xác nhận',
            'preparing'   => 'Đang chuẩn bị',
            'wait_ship'   => 'Chờ shipper',
            'shipping'    => 'Đang giao hàng',
            'delivered'   => 'Đã giao hàng',
            'cancelled'   => 'Đã hủy',
            'refund'      => 'Hoàn tiền'
        ];
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    public function Index()
    {
        $rows_per_page = 4;
        $current_page = isset($_GET['p']) ? $_GET['p'] : 1;
        $status_map =self::STATUS_MAP;
        $stt = isset($_GET['status']) ? $_GET['status'] : '';
        $where_clauses = [
            'orders.user_id' => SessionManager::get('user_id'),
            'orders.status'  => $status_map[$stt] ?? ''
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

    public function Detail()
    {
        if (!isset($_GET['order_id'])) {
            header("Location: index.php?page=Order");
            exit();
        }
        $status_map =self::STATUS_MAP;
        $order_id = $_GET['order_id'];
        $order = $this->orderModel->getOrderById($order_id);
        $items =  $this->orderItemModel->getOrderItems($order_id);
        // load any existing reviews by this user for items in the order
        include_once __DIR__ . '/../Model/ReviewModel.php';
        $reviewModel = new ReviewModel();
        $current_user = SessionManager::get('user_id');
        $userReviews = [];
        if (!empty($current_user) && is_array($items)) {
            foreach ($items as $it) {
                $r = $reviewModel->getByUserOrderFood($current_user, $it['food_id'], $order_id);
                if ($r) $userReviews[$it['food_id']] = $r;
            }
        }
        $msg = SessionManager::flash('success');
        $error = SessionManager::flash('error');
        include_once "View/Order/Detail.php";
    }

    public function Cancel()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
            
            if (empty($order_id)) {
                SessionManager::flash('error', 'Không tìm thấy đơn hàng.');
                header("Location: index.php?page=Order");
                exit();
            }

            $order = $this->orderModel->getOrderById($order_id);
            $current_user_id = SessionManager::get('user_id');

            if (!$order || $order['user_id'] != $current_user_id) {
                SessionManager::flash('error', 'Bạn không có quyền hủy đơn hàng này.');
                header("Location: index.php?page=Order");
                exit();
            }

            $allow_cancel_status = [
                self::STATUS_MAP['wait'],      
                self::STATUS_MAP['confirmed'] 
            ];

            if (in_array($order['status'], $allow_cancel_status)) {
                $data = ['status' => self::STATUS_MAP['cancelled']]; 
                
                $result = $this->orderModel->Update($data, 'order_id', $order_id);

                if ($result) {
                    SessionManager::flash('success', 'Đã hủy đơn hàng thành công.');
                } else {
                    SessionManager::flash('error', 'Lỗi hệ thống, vui lòng thử lại.');
                }
            } else {
                SessionManager::flash('error', 'Đơn hàng đã được xử lý hoặc đang giao, không thể hủy.');
            }

            header("Location: index.php?page=Order&action=detail&order_id=$order_id");
            exit();
        }
    }
}
