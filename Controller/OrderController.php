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

    public function Invoice()
    {
        try {
            $order_id = $_GET['order_id'] ?? '';
            if (empty($order_id)) {
                header('Location: index.php?page=Order');
                exit();
            }

            $order = $this->orderModel->getOrderById($order_id);
            if (!$order) {
                SessionManager::flash('error', 'Không tìm thấy đơn hàng.');
                header('Location: index.php?page=Order');
                exit();
            }

            $items = $this->orderItemModel->getOrderItems($order_id);

            include_once __DIR__ . '/../Model/InvoiceModel.php';
            $invoiceModel = new InvoiceModel();
            $invoice = $invoiceModel->getByOrderId($order_id);

            if (!$invoice) {
                $final_amount = $order['total_money'] ?? 0;
                $newId = $invoiceModel->Insert(['order_id' => $order_id, 'final_amount' => $final_amount]);
                if ($newId) {
                    $invoice = $invoiceModel->getById($newId);
                }
            }

            include_once __DIR__ . '/../Helper/FPDF.php';

            $pdf = new FPDF();
            $pdf->AddPage();
            $pdf->SetFont('Arial','B',14);
            $pdf->Cell(0,10, 'HÓA ĐƠN BÁN HÀNG', 0, 1, 'C');
            $pdf->Ln(4);

            $pdf->SetFont('Arial','',11);
            $invoice_no = $invoice['invoice_id'] ?? ('INV-' . $order_id . '-' . date('YmdHis'));
            $pdf->Cell(40,8, 'Mã hóa đơn:');
            $pdf->Cell(0,8, $invoice_no, 0, 1);
            $pdf->Cell(40,8, 'Mã đơn hàng:');
            $pdf->Cell(0,8, $order_id, 0, 1);
            $pdf->Cell(40,8, 'Ngày phát hành:');
            $pdf->Cell(0,8, $invoice['issued_date'] ?? date('Y-m-d H:i:s'), 0, 1);

            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,8,'Thông tin khách hàng',0,1);
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(40,7,'Họ tên:'); $pdf->Cell(0,7, $order['full_name'] ?? '', 0,1);
            $pdf->Cell(40,7,'SĐT:'); $pdf->Cell(0,7, $order['phone_number'] ?? '', 0,1);
            $pdf->Cell(40,7,'Địa chỉ:'); $pdf->Cell(0,7, ($order['address'] ?? '') . (!empty($order['city']) ? ', ' . $order['city'] : ''), 0,1);

            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,8,'Chi tiết sản phẩm',0,1);
            $pdf->SetFont('Arial','',11);
            foreach ($items as $it) {
                $line = $it['food_name'] . ' x' . $it['quantity'] . ' - ' . number_format($it['price_at_purchase'],0,',','.') . 'đ';
                $pdf->Cell(0,7, $line, 0, 1);
            }

            $pdf->Ln(4);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(40,8,'Tổng tiền:');
            $pdf->Cell(0,8, number_format($order['total_money'] ?? 0,0,',','.') . ' đ',0,1);

            $pdf->Ln(6);
            $pdf->SetFont('Arial','B',12);
            $pdf->Cell(0,8,'Người giao / Vận đơn (tham khảo)',0,1);
            $pdf->SetFont('Arial','',11);
            $pdf->Cell(40,7,'Shipper:'); $pdf->Cell(0,7, $order['shipper_name'] ?? 'Chưa có',0,1);
            $pdf->Cell(40,7,'SĐT shipper:'); $pdf->Cell(0,7, $order['shipper_phone'] ?? '',0,1);
            $pdf->Cell(40,7,'Mã vận đơn:'); $pdf->Cell(0,7, 'AWB'.($order_id),0,1);

            $filename = 'invoice_' . $invoice_no . '.pdf';
            $pdf->Output('I', $filename);
            exit();
        } catch (Throwable $e) {
            echo '<h3>Debug Error (Invoice):</h3>';
            echo '<pre>' . htmlspecialchars($e->getMessage()) . "\n" . htmlspecialchars($e->getTraceAsString()) . '</pre>';
            exit();
        }
    }

    /**
     * Render a printable HTML invoice (browser print).
     * This avoids generating binary PDF and preserves UTF-8 Vietnamese text.
     */
    public function PrintView()
    {
        $order_id = $_GET['order_id'] ?? '';
        if (empty($order_id)) {
            header('Location: index.php?page=Order');
            exit();
        }

        $order = $this->orderModel->getOrderById($order_id);
        if (!$order) {
            SessionManager::flash('error', 'Không tìm thấy đơn hàng.');
            header('Location: index.php?page=Order');
            exit();
        }

        $items = $this->orderItemModel->getOrderItems($order_id);

        include_once __DIR__ . '/../Model/InvoiceModel.php';
        $invoiceModel = new InvoiceModel();
        $invoice = $invoiceModel->getByOrderId($order_id);
        if (!$invoice) {
            $final_amount = $order['total_money'] ?? 0;
            $newId = $invoiceModel->Insert(['order_id' => $order_id, 'final_amount' => $final_amount]);
            if ($newId) {
                $invoice = $invoiceModel->getById($newId);
            }
        }

        // Render HTML printable view
        $msg = SessionManager::flash('success');
        $error = SessionManager::flash('error');
        include_once __DIR__ . '/../View/Order/PrintInvoice.php';
        exit();
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
