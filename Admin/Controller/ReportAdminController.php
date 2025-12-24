<?php
include_once "../Model/OrderModel.php";
include_once "../Model/OrderItemModel.php";

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

        // Detect whether the user explicitly provided both dates
        $user_provided_start = isset($_GET['start_date']) && $_GET['start_date'] !== '';
        $user_provided_end = isset($_GET['end_date']) && $_GET['end_date'] !== '';
        $show_results = false;

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

        // If user-provided range has start > end, swap and inform via $msg_error
        $msg_error = '';
        if ($user_provided_start && $user_provided_end) {
            if (strtotime($start_date) > strtotime($end_date)) {
                // Swap
                $tmp = $start_date;
                $start_date = $end_date;
                $end_date = $tmp;
                $msg_error = 'Ngày bắt đầu không được lớn hơn ngày kết thúc. Đã hoán đổi tự động.';
            }
        }

        // Only consider delivered orders for revenue and top items
        $status_delivered = 'Đã giao hàng';

        // Only fetch results when user explicitly provided both start and end dates
        if ($user_provided_start && $user_provided_end) {
            $show_results = true;
            $revenue_data = $this->orderModel->getRevenueData($status_delivered, $start_date, $end_date, $granularity);
            $top_items = $this->orderModel->getTopItems($status_delivered, $start_date, $end_date, 20);
        } else {
            $revenue_data = [];
            $top_items = [];
        }

        // Pass data to view
        $granularity_options = ['day' => 'Ngày', 'month' => 'Tháng', 'year' => 'Năm'];
        include_once __DIR__ . '/../View/ReportAdmin/Index.php';
    }
}
