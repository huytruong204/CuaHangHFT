<?php
include_once "../Model/OrderModel.php";
include_once "../Model/OrderItemModel.php";
include_once "../Helper/SessionManager.php";
include_once "../Model/UserRoleModel.php";
include_once '../Model/InvoiceModel.php';

class OrderAdminController
{
    public $orderModel;
    public $orderItemModel;
    public $userRoleModel;
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
        $this->userRoleModel = new UserRoleModel();
    }

    public function Index()
    {
        $rows_per_page = 4;
        $current_page = isset($_GET['p']) ? $_GET['p'] : 1;

        $stt = isset($_GET['status']) ? $_GET['status'] : '';
        $where_clauses = [
            'orders.status'  => self::STATUS_MAP[$stt] ?? '',
        ];

        $where_clauses = array_filter($where_clauses);

        $count_rows = $this->orderModel->CountRows($where_clauses);
        $total_pages = ceil($count_rows / $rows_per_page);

        $offset = ($current_page - 1) * $rows_per_page;
        $sort_price = $_GET['price_sort'] ?? 'desc';
        $orders = $this->orderModel->getAll($offset, $rows_per_page, $where_clauses, $sort_price);
        $status_map = self::STATUS_MAP;
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
                return [$s['preparing'], $s['cancelled']];

            case $s['preparing']:
                return [$s['wait_ship'], $s['cancelled']];

            case $s['wait_ship']:
                return [$s['shipping'], $s['cancelled']];

            case $s['shipping']:
                return [$s['delivered'], $s['cancelled']];

            case $s['delivered']:
                return [$s['refund']];

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

        include_once "View/OrderAdmin/Detail.php";
    }
    public function UpdateStatus()
    {

        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $order_id = isset($_POST['order_id']) ? $_POST['order_id'] : '';
            $stt = isset($_POST['status']) ? $_POST['status'] : '';
            $shipper_id =  isset($_POST['shipper_id']) ? $_POST['shipper_id'] : '';
            if (empty($order_id) || empty($stt)) {
                SessionManager::flash('error', "Lỗi null");
                header("Location: index.php?page=OrderAdmin");
                exit();
            }
            $order = $this->orderModel->getOrderById($order_id);
            if ($stt !== $order['status']) {
                $allowed = $this->getAllowedTransitions($order['status']);

                if (!in_array($stt, $allowed)) {
                    SessionManager::flash('error', "Không thể chuyển từ '$order[status]' sang '$stt'. Sai quy trình!");
                    header("Location: index.php?page=orderAdmin&action=detail&order_id=$order_id");
                    exit();
                }
            }
            $paystt = '';
            if ($stt === self::STATUS_MAP['delivered']) {
                $paystt = ($order['payment_status'] == 0) ? 1 : '';
            }

            $data['status'] = $stt;
            $data['payment_status'] = $paystt;
            $data['shipper_id'] = $shipper_id;
            $update_stt = $this->orderModel->Update(array_filter($data), 'order_id', $order_id);
            if ($update_stt) {
                SessionManager::flash('success', "Cập nhật trạng thái đơn hàng #$order_id thành công");
                header("Location: index.php?page=OrderAdmin");
                exit();
            } else {
                $dbError = $this->orderModel->error_message;
                SessionManager::flash('error', "Lỗi CSDL: $dbError");
                header("Location: index.php?page=OrderAdmin");
                exit();
            }
        }
    }

    /**
     * Admin printable invoice view (browser print) under OrderAdmin.
     */
    public function PrintView()
    {
        $order_id = $_GET['order_id'] ?? '';
        if (empty($order_id)) {
            header('Location: index.php?page=OrderAdmin');
            exit();
        }

        $order = $this->orderModel->getOrderById($order_id);
        if (!$order) {
            SessionManager::flash('error', 'Không tìm thấy đơn hàng.');
            header('Location: index.php?page=OrderAdmin');
            exit();
        }

        $items = $this->orderItemModel->getOrderItems($order_id);

        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->getByOrderId($order_id);
        if (!$invoice) {
            $final_amount = $order['total_money'] ?? 0;
            $newId = $invoiceModel->Insert(['order_id' => $order_id, 'final_amount' => $final_amount]);
            if ($newId) {
                $invoice = $invoiceModel->getById($newId);
            }
        }

        $msg_success = SessionManager::flash('success');
        $msg_error = SessionManager::flash('error');

        include_once "View/OrderAdmin/PrintInvoice.php";
    }
}
