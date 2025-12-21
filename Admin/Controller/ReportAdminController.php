<?php
include_once "../Model/OrderModel.php";
include_once "../Model/OrderItemModel.php";
include_once "../Model/InvoiceModel.php";

class ReportAdminController
{
    public $orderModel;
    public $orderItemModel;

    public function __construct()
    {
        $this->orderModel = new OrderModel();
        $this->orderItemModel = new OrderItemModel();
    }

    /**
     * Render report page.
     * GET params:
     *  - granularity: day|month|year (default: day)
     *  - start_date, end_date: optional (YYYY-MM-DD)
     */
    public function Index()
    {
        $granularity = $_GET['granularity'] ?? 'day';
        $start_date = $_GET['start_date'] ?? '';
        $end_date = $_GET['end_date'] ?? '';

        // Determine default range based on granularity
        $today = date('Y-m-d');
        if (empty($end_date)) $end_date = $today . ' 23:59:59';
        else $end_date = $end_date . ' 23:59:59';

        // Enforce minimum start date (2025-01-01)
        $min_start_dt = '2025-01-01 00:00:00';

        if (empty($start_date)) {
            if ($granularity === 'month') {
                $start_date = date('Y-m-01', strtotime('-11 months')) . ' 00:00:00';
            } elseif ($granularity === 'year') {
                $start_date = date('Y-01-01', strtotime('-4 years')) . ' 00:00:00';
            } else {
                $start_date = date('Y-m-d', strtotime('-29 days')) . ' 00:00:00';
            }
        } else {
            $start_date = $start_date . ' 00:00:00';
        }

        // Clamp to minimum allowed date
        if (strtotime($start_date) < strtotime($min_start_dt)) {
            $start_date = $min_start_dt;
        }

        // Also ensure end_date is not before min
        if (strtotime($end_date) < strtotime($min_start_dt)) {
            $end_date = date('Y-m-d H:i:s');
        }

        $db = $this->orderModel->getDb();

        // Only consider delivered orders for revenue and top items
        $status_delivered = 'Đã giao hàng';

        // Revenue aggregation SQL
        switch ($granularity) {
            case 'month':
                $period_expr = "DATE_FORMAT(o.created_at, '%Y-%m')";
                break;
            case 'year':
                $period_expr = "YEAR(o.created_at)";
                break;
            case 'day':
            default:
                $period_expr = "DATE(o.created_at)";
                break;
        }

        $revenue_sql = "SELECT $period_expr AS period, SUM(o.total_money) AS revenue
            FROM orders o
            WHERE o.status = ? AND o.created_at BETWEEN ? AND ?
            GROUP BY period
            ORDER BY period ASC";

        $stmt = $db->prepare($revenue_sql);
        $stmt->execute([$status_delivered, $start_date, $end_date]);
        $revenue_data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Top selling items
        $top_sql = "SELECT oi.food_id, f.food_name, SUM(oi.quantity) AS qty_sold, SUM(oi.quantity * oi.price_at_purchase) AS total_sales
            FROM order_items oi
            JOIN orders o ON oi.order_id = o.order_id
            JOIN foods f ON oi.food_id = f.food_id
            WHERE o.status = ? AND o.created_at BETWEEN ? AND ?
            GROUP BY oi.food_id
            ORDER BY qty_sold DESC
            LIMIT 20";

        $stmt2 = $db->prepare($top_sql);
        $stmt2->execute([$status_delivered, $start_date, $end_date]);
        $top_items = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        // Pass data to view
        $granularity_options = ['day' => 'Ngày', 'month' => 'Tháng', 'year' => 'Năm'];
        include_once __DIR__ . '/../View/ReportAdmin/Index.php';
    }
}
