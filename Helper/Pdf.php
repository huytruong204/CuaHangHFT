<?php

require_once "../tfpdf/tfpdf.php";
include_once "../Model/OrderModel.php";
include_once "../Model/OrderItemModel.php";
include_once '../Model/InvoiceModel.php';

class InvoicePDF extends TFPDF {
    function Header() {

        $this->AddFont('DejaVu', '', 'DejaVuSans.ttf', true);
        $this->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true); 
        $this->SetFont('DejaVu', 'B', 16);
        $this->Cell(0, 10, 'HÓA ĐƠN BÁN HÀNG', 0, 1, 'C');
        $this->Ln(5);
    }

    function Footer() {
        $this->SetY(-15);
        $this->SetFont('DejaVu', '', 8);
        $this->Cell(0, 10, 'Trang ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    function currency_format($number) {
        return number_format($number, 0, ',', '.') . ' đ';
    }
}
if ($_SERVER['REQUEST_METHOD'] !== "POST") 
{   
    header("Location: Location: index.php?page=orderAdmin");
    exit();
}
$order_id = $_POST['order_id'];
$invoiceModel = new InvoiceModel();
$invoiceArr = $invoiceModel->getByOrderId($order_id);
$orderModel = new OrderModel();
$orderArr = $orderModel->getOrderById($order_id);
$orderItem = new OrderItemModel();
$items = $orderItem->getOrderItems($order_id);
$pdf = new InvoicePDF();
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->AddFont('DejaVu', '', 'DejaVuSans.ttf', true);
$pdf->SetFont('DejaVu', '', 11);

// --- Phần 1: Thông tin chung ---
$pdf->SetFontSize(10);

$pdf->Cell(0, 6, 'Mã hóa đơn: ' . ($invoiceArr['invoice_id'] ?? ''), 0, 1);
$pdf->Cell(0, 6, 'Mã đơn hàng: ' . ($orderArr['order_id'] ?? ''), 0, 1);
$pdf->Cell(0, 6, 'Ngày phát hành: ' . ($invoiceArr['issued_date'] ?? date('Y-m-d H:i:s')), 0, 1);
$pdf->Ln(5);

// --- Phần 2: Thông tin khách hàng ---
$pdf->SetFont('DejaVu', 'B', 12);
$pdf->Cell(0, 8, 'Thông tin khách hàng', 0, 1);

$pdf->SetFont('DejaVu', '', 11);
// In theo dòng: Label bên trái, nội dung bên phải
$pdf->Cell(30, 6, 'Họ tên:', 0, 0);
$pdf->Cell(0, 6, $orderArr['full_name'] ?? '', 0, 1);

$pdf->Cell(30, 6, 'SĐT:', 0, 0);
$pdf->Cell(0, 6, $orderArr['phone_number'] ?? '', 0, 1);

$pdf->Cell(30, 6, 'Địa chỉ:', 0, 0);
$fullAddress = ($orderArr['address'] ?? '') . ', ' . ($orderArr['city'] ?? '');
// Dùng MultiCell cho địa chỉ vì có thể dài
$pdf->MultiCell(0, 6, $fullAddress); 
$pdf->Ln(5);

// --- Phần 3: Bảng sản phẩm ---
$pdf->SetFont('DejaVu', 'B', 12);
$pdf->Cell(0, 8, 'Chi tiết món ăn', 0, 1);

// Header bảng
$pdf->SetFont('DejaVu', '', 10);
$pdf->SetFillColor(240, 240, 240); // Nền xám nhạt

// Chiều rộng các cột: STT, Tên món, SL, Đơn giá, Thành tiền
// Tổng chiều rộng A4 ~ 190mm
$w = [10, 80, 20, 40, 40];

$pdf->Cell($w[0], 8, 'STT', 1, 0, 'C', true);
$pdf->Cell($w[1], 8, 'Món ăn', 1, 0, 'C', true);
$pdf->Cell($w[2], 8, 'SL', 1, 0, 'C', true);
$pdf->Cell($w[3], 8, 'Đơn giá', 1, 0, 'R', true);
$pdf->Cell($w[4], 8, 'Thành tiền', 1, 1, 'R', true);

$stt = 1;
foreach ($items as $item) {
    $totalItem = $item['quantity'] * $item['price_at_purchase'];
    
    $pdf->Cell($w[0], 7, $stt++, 1, 0, 'C');
    $pdf->Cell($w[1], 7, $item['food_name'], 1, 0, 'L');
    $pdf->Cell($w[2], 7, $item['quantity'], 1, 0, 'C');
    $pdf->Cell($w[3], 7, $pdf->currency_format($item['price_at_purchase']), 1, 0, 'R');
    $pdf->Cell($w[4], 7, $pdf->currency_format($totalItem), 1, 1, 'R');
}

$pdf->SetFont('DejaVu', 'B', 10);
$pdf->Cell($w[0] + $w[1] + $w[2] + $w[3], 8, 'Tổng tiền', 1, 0, 'R');
$pdf->Cell($w[4], 8, $pdf->currency_format($orderArr['total_money']), 1, 1, 'R');
$pdf->Ln(5);

$pdf->SetFont('DejaVu', 'B', 12);
$pdf->Cell(0, 8, 'Thông tin giao hàng', 0, 1);

$pdf->SetFont('DejaVu', '', 11);
$pdf->Cell(30, 6, 'Shipper:', 0, 0);
$pdf->Cell(0, 6, ($orderArr['shipper_name'] ?? 'Chưa có') . ' - ' . ($orderArr['shipper_phone'] ?? ''), 0, 1);


$payment_method = $orderArr['payment_method'] ?? 'COD'; 
$money_to_collect = 0;

if (strtolower($payment_method) == 'cod') {
    $money_to_collect = $orderArr['total_money'];
} else {
    $money_to_collect = 0;
}

$order_status = $orderArr['status'] ?? '';
$payment_method = strtolower($orderArr['payment_method'] ?? 'cod');

$pdf->SetFont('DejaVu', 'B', 11);

if ($order_status === 'Đang giao hàng' && $payment_method === 'cod') {
    $pdf->Cell(30, 6, 'Cần thu:', 0, 0);
    $pdf->Cell(0, 6, $pdf->currency_format($orderArr['total_money']), 0, 1);
}
elseif ($order_status === 'Đã giao hàng') {
    $pdf->Cell(30, 6, 'Đã thu:', 0, 0);
    $pdf->Cell(0, 6, $pdf->currency_format($orderArr['total_money']), 0, 1);
}
else {
    $pdf->Cell(0, 6, 'Thanh toán: Đã hoàn tất', 0, 1);
}



$pdf->Ln(2);
$pdf->SetFont('DejaVu', '', 11); 
$note = !empty($orderArr['note']) ? $orderArr['note'] : 'Không có ghi chú';

$pdf->Cell(30, 6, "Ghi chú: ", 0, 0);
$pdf->SetFont('DejaVu', '', 11); 
$pdf->MultiCell(0, 6, $note);

// Xuất file
$pdf->Output();
?>