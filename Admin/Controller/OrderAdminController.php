<?php
include_once "../Model/OrderModel.php";
include_once "../Model/OrderItemModel.php";
include_once "../Helper/SessionManager.php";
include_once "../Model/UserRoleModel.php";

class OrderAdminController
{
    public $orderModel;
    public $orderItemModel;
    public $userRoleModel;
    const STATUS_MAP = [
        'wait'        => 'Chờ xác nhận',
        'confirmed'   => 'Đã xác nhận',
        'shipping'    => 'Đang giao hàng',
        'delivered'   => 'Đã giao hàng',
        'cancelled'   => 'Đã hủy',
        'refund'      => 'Hoàn tiền'
    ];
    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
        $this->userRoleModel = new UserRoleModel();
    }

    public function Index()
    {
        $rows_per_page = 4;
        $current_page = isset($_GET['p']) ? $_GET['p'] : 1;
        $status_map = self::STATUS_MAP;

        $stt = isset($_GET['status']) ? $_GET['status'] : '';
        $search_id = isset($_GET['search_id']) ? trim($_GET['search_id']) : '';
        $date_from = isset($_GET['date_from']) ? $_GET['date_from'] : '';
        $date_to = isset($_GET['date_to']) ? $_GET['date_to'] : '';
        $where_clauses = [
            'orders.status'  => $status_map[$stt] ?? '',
            'search_id' => $search_id,
            'date_from' => $date_from,
            'date_to' => $date_to,
        ];
        $where_clauses = array_filter($where_clauses);

        $count_rows = $this->orderModel->CountRows($where_clauses);
        $total_pages = ceil($count_rows / $rows_per_page);

        $offset = ($current_page - 1) * $rows_per_page;
        $sort_price = $_GET['price_sort'] ?? 'desc';
        $orders = $this->orderModel->getAll($offset, $rows_per_page, $where_clauses, $sort_price);
        $msg_success = SessionManager::flash('success');
        $msg_error = SessionManager::flash('error');

        include_once "View/OrderAdmin/Index.php";
    }

    private function GetAllowedTransitions($currentStatus)
    {
        $s = self::STATUS_MAP;

        switch ($currentStatus) {
            case $s['wait']:
                return [$s['confirmed'], $s['cancelled']];

            case $s['confirmed']:
                return [$s['shipping'], $s['cancelled']];

            case $s['shipping']:
                return [$s['delivered'], $s['cancelled']];

            case $s['delivered']:
            case $s['cancelled']:
            case $s['refund']:
                return [];

            default:
                return [];
        }
    }

    public function Detail()
    {
        if (!isset($_GET['order_id'])) {
            header("Location: index.php?page=orderAdmin");
            exit;
        }

        $id = $_GET['order_id'];
        $order = $this->orderModel->getOrderById($id);

        $old_input = isset($_SESSION['old_input']) ? $_SESSION['old_input'] : null;
        if ($old_input) {
            SessionManager::remove('old_input');
        }

        $display_status = isset($old_input['status']) ? $old_input['status'] : $order['status'];
        $display_shipper = isset($old_input['shipper_id']) ? $old_input['shipper_id'] : ($order['shipper_id'] ?? '');

        $allowed_statuses = $this->getAllowedTransitions($order['status']);

        if (!empty($allowed_statuses)) {
            array_unshift($allowed_statuses, $order['status']);
        } else {
            $allowed_statuses = [$order['status']];
        }
        $allowed_statuses = array_unique($allowed_statuses);

        $shippers = $this->userRoleModel->getUsersByRole(3);
        if (!$order || !$shippers) {
            header("Location: index.php?page=orderAdmin");
            exit;
        }
        $order_items = $this->orderItemModel->getOrderItems($id);
        $error = SessionManager::flash('error');
        include_once "View/OrderAdmin/Detail.php";
    }
    public function UpdateStatus()
    {
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $order_id   = $_POST['order_id'] ?? '';
            $stt        = $_POST['status'] ?? '';
            $shipper_id = !empty($_POST['shipper_id']) ? $_POST['shipper_id'] : null;

            if (empty($order_id) || empty($stt)) {
                SessionManager::flash('error', "Dữ liệu không hợp lệ.");
                header("Location: index.php?page=OrderAdmin");
                exit();
            }

            $order = $this->orderModel->getOrderById($order_id);

            if ($stt !== $order['status']) {
                $allowed = $this->getAllowedTransitions($order['status']);
                if (!in_array($stt, $allowed)) {
                    SessionManager::flash('error', "Sai quy trình! Không thể chuyển từ '{$order['status']}' sang '$stt'.");
                    SessionManager::set('old_input', $_POST);
                    header("Location: index.php?page=orderAdmin&action=detail&order_id=$order_id");
                    exit();
                }
            }

            $data = [
                'status' => $stt,
                'shipper_id' => $shipper_id
            ];

            if ($stt === self::STATUS_MAP['delivered'] && $order['payment_status'] == 0) {
                $data['payment_status'] = 1;
            }

            $error = [];
            if ($stt !== self::STATUS_MAP['cancelled']) {
                $tempModel = new OrderModel($data);
                $error = $this->orderModel->validate($tempModel);
            }

            if (!empty($error)) {
                $er_msg = implode('<br>', $error);
                SessionManager::flash('error', $er_msg);
                SessionManager::set('old_input', $_POST);
                header("Location: index.php?page=OrderAdmin&action=Detail&order_id=" . $order_id);
                exit();
            }

            $update_stt = $this->orderModel->Update($data, 'order_id', $order_id);

            if ($update_stt) {
                SessionManager::flash('success', "Cập nhật trạng thái #$order_id thành công");
                header("Location: index.php?page=OrderAdmin");
                exit();
            } else {
                SessionManager::flash('error', "Lỗi CSDL: " . $this->orderModel->error_message);
                header("Location: index.php?page=OrderAdmin");
                exit();
            }
        }
    }
}
