<?php
require_once "../tfpdf/tfpdf.php";
include_once "../Model/OrderModel.php";
include_once "../Model/OrderItemModel.php";

class InvoicePDF extends TFPDF {
    // Hàm vẽ đường gạch đứt (để giống hóa đơn in nhiệt)
    function DashedLine($x1, $y1, $x2, $y2, $width = 1, $nb = 15) {
        $this->SetLineWidth($width);
        $longueur = $x2 - $x1;
        $hauteur = $y2 - $y1;
        $ratio = $longueur / $nb;
        for ($i = 0; $i < $nb; $i++) {
            if ($i % 2 === 0) {
                $this->Line($x1 + ($ratio * $i), $y1, $x1 + ($ratio * ($i + 1)), $y1);
            }
        }
        $this->SetLineWidth(0.2); // Reset về mặc định
    }

    function Header() {
        // Logo (Nếu có thì uncomment dòng dưới)
        // $this->Image('logo.png', 90, 5, 30); 
        // $this->Ln(20); 

        $this->AddFont('DejaVu', '', 'DejaVuSans.ttf', true);
        $this->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true); 

        // Tên cửa hàng
        $this->SetFont('DejaVu', 'B', 15);
        $this->Cell(0, 8, 'HFT FOOD', 0, 1, 'C');
        
        // Địa chỉ & SĐT 
        $this->SetFont('DejaVu', '', 9);
        $this->MultiCell(0, 5, "Địa chỉ: ....", 0, 'C');
        $this->Cell(0, 5, 'Điện thoại: ....', 0, 1, 'C');
        
        $this->Ln(3);
    }

    function Footer() {
        $this->SetY(137);
        $this->SetFont('DejaVu', 'I', 9); // Chữ nghiêng
        $this->Cell(0, 10, 'Cảm ơn và hẹn gặp lại!', 0, 0, 'C');
    }

    // Format số: 13,000 (không có chữ đ để giống ảnh)
    function currency_format($number) {
        return number_format($number, 0, ',', '.'); 
    }
}

// --- Xử lý Logic ---
if ($_SERVER['REQUEST_METHOD'] !== "POST") {   
    header("Location: index.php?page=orderAdmin");
    exit();
}

$order_id = $_POST['order_id'];
$orderModel = new OrderModel();
$orderArr = $orderModel->getOrderById($order_id);
$orderItem = new OrderItemModel();
$items = $orderItem->getOrderItems($order_id);


$pdf = new InvoicePDF('P', 'mm', 'A4');

$pdf->SetMargins(70, 10, 70); 
$pdf->AliasNbPages();
$pdf->AddPage();

$pdf->AddFont('DejaVu', '', 'DejaVuSans.ttf', true);
$pdf->AddFont('DejaVu', 'B', 'DejaVuSans-Bold.ttf', true);
$pdf->AddFont('DejaVu', 'I', 'DejaVuSans-Oblique.ttf', true);

// --- TIÊU ĐỀ ---
$pdf->SetFont('DejaVu', 'B', 13);
$pdf->Cell(0, 10, 'HÓA ĐƠN TẠM TÍNH', 0, 1, 'C');

$pdf->SetFont('DejaVu', '', 10);
$pdf->Cell(0, 5, 'Số HĐ: Hóa đơn ' . $order_id, 0, 1, 'C');

// Ngày tháng
$date = date_create($orderArr['created_at']); 
$day = date_format($date, 'd');
$month = date_format($date, 'm');
$year = date_format($date, 'Y');
$pdf->Cell(0, 5, "Ngày $day tháng $month năm $year", 0, 1, 'C');
$pdf->Ln(4);

// --- KHÁCH HÀNG ---
$pdf->SetFont('DejaVu', '', 10);
$pdf->Cell(25, 5, 'Khách hàng:', 0, 0);
$pdf->Cell(0, 5, $orderArr['full_name'] ?? 'Khách lẻ', 0, 1);

$pdf->Cell(25, 5, 'SĐT:', 0, 0);
$pdf->Cell(0, 5, $orderArr['phone_number'] ?? '', 0, 1);

$pdf->Cell(25, 5, 'Địa chỉ:', 0, 0);
$pdf->Cell(0, 5, $orderArr['address'] ?? '-', 0, 1); 

// Kẻ đường ngăn cách đậm
$pdf->Ln(2);
$pdf->SetLineWidth(0.4);
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 70, $pdf->GetY()); 
$pdf->SetLineWidth(0.2);
$pdf->Ln(1);

// --- DANH SÁCH MÓN ---
// Header nhỏ
$pdf->SetFont('DejaVu', 'B', 9);
$pdf->Cell(25, 6, 'Đơn giá', 0, 0, 'L');
$pdf->Cell(20, 6, 'SL', 0, 0, 'C');
$pdf->Cell(25, 6, 'Thành tiền', 0, 1, 'R');

// Kẻ đường ngăn cách mỏng
$pdf->Line($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 70, $pdf->GetY());
$pdf->Ln(2);

$pdf->SetFont('DejaVu', '', 10);

foreach ($items as $item) {
    $totalItem = $item['quantity'] * $item['price_at_purchase'];
    
    // Dòng 1: Tên món
    $pdf->SetFont('DejaVu', '', 10);
    $pdf->MultiCell(0, 5, $item['food_name']);
    
    // Dòng 2: Giá ... SL ... Thành tiền
    $pdf->SetFont('DejaVu', '', 10);
    $pdf->Cell(25, 5, $pdf->currency_format($item['price_at_purchase']), 0, 0, 'L');
    $pdf->Cell(20, 5, $item['quantity'], 0, 0, 'C');
    $pdf->Cell(25, 5, $pdf->currency_format($totalItem), 0, 1, 'R');
    
    // Nét đứt ngăn cách
    $y = $pdf->GetY();
    $pdf->DashedLine($pdf->GetX(), $y + 1, $pdf->GetX() + 70, $y + 1, 0.1, 25);
    $pdf->Ln(3);
}

// --- TỔNG KẾT ---
$pdf->Ln(2);
$pdf->SetFont('DejaVu', 'B', 10);

// Tổng tiền hàng
$pdf->Cell(40, 6, 'Tổng tiền hàng:', 0, 0, 'R');
$pdf->Cell(30, 6, $pdf->currency_format($orderArr['total_money']), 0, 1, 'R');

// Chiết khấu
$pdf->Cell(40, 6, 'Chiết khấu :', 0, 0, 'R');
$pdf->Cell(30, 6, '0', 0, 1, 'R');

// Tổng thanh toán
$pdf->SetFont('DejaVu', 'B', 12);
$pdf->Cell(40, 8, 'Tổng thanh toán:', 0, 0, 'R');
$pdf->Cell(30, 8, $pdf->currency_format($orderArr['total_money']), 0, 1, 'R');

$pdf->Ln(2);
$note = !empty($orderArr['note']) ? $orderArr['note'] : 'Không có ghi chú';

$pdf->DashedLine($pdf->GetX(), $pdf->GetY(), $pdf->GetX() + 70, $pdf->GetY(), 0.1, 30);
$pdf->Ln(2);

$pdf->SetFont('DejaVu', 'B', 10);
$pdf->Cell(17, 5, "Ghi chú: ", 0, 0);

$pdf->SetFont('DejaVu', '', 10);
$pdf->MultiCell(0, 5, $note);


$pdf->Output();
?>