<?php
// Printable invoice view. UTF-8 and simple print CSS to use browser's print dialog.
// Expects $order (array or object), $items (array), $invoice (array) to be set.
$orderArr = is_array($order) ? $order : (array)$order;
$invoiceArr = is_array($invoice) ? $invoice : (array)$invoice;
$invoice_no = $invoiceArr['invoice_id'] ?? ('INV-' . ($orderArr['order_id'] ?? '') . '-' . date('YmdHis'));
?>
<!doctype html>
<html lang="vi">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Hóa đơn <?= htmlspecialchars($invoice_no) ?></title>
    <style>
        body { font-family: Arial, Helvetica, "Noto Sans", "DejaVu Sans", sans-serif; color:#111; padding:20px; }
        .invoice { max-width:800px; margin:0 auto; }
        h1, h2, h3 { margin:8px 0; }
        table { width:100%; border-collapse:collapse; margin-top:10px; }
        th, td { padding:6px 8px; border:1px solid #ddd; text-align:left; }
        .no-border { border: none; }
        .right { text-align:right; }
        @media print {
            button#printBtn { display:none; }
        }
    </style>
</head>
<body>
<div class="invoice">
    <div style="display:flex;justify-content:space-between;align-items:center;">
        <div>
            <h2>HÓA ĐƠN BÁN HÀNG</h2>
            <div>Mã hóa đơn: <strong><?= htmlspecialchars($invoice_no) ?></strong></div>
            <div>Mã đơn hàng: <strong><?= htmlspecialchars($orderArr['order_id'] ?? '') ?></strong></div>
            <div>Ngày phát hành: <strong><?= htmlspecialchars($invoiceArr['issued_date'] ?? date('Y-m-d H:i:s')) ?></strong></div>
        </div>
    </div>

    <h3>Thông tin khách hàng</h3>
    <table>
        <tr><td class="no-border" style="width:150px">Họ tên</td><td class="no-border"><?= htmlspecialchars($orderArr['full_name'] ?? '') ?></td></tr>
        <tr><td class="no-border">SĐT</td><td class="no-border"><?= htmlspecialchars($orderArr['phone_number'] ?? '') ?></td></tr>
        <tr><td class="no-border">Địa chỉ</td><td class="no-border"><?= htmlspecialchars(($orderArr['address'] ?? '') . (!empty($orderArr['city']) ? ', ' . $orderArr['city'] : '')) ?></td></tr>
    </table>

    <h3>Chi tiết sản phẩm</h3>
    <table>
        <thead>
            <tr><th>STT</th><th>Sản phẩm</th><th>Số lượng</th><th class="right">Đơn giá</th><th class="right">Thành tiền</th></tr>
        </thead>
        <tbody>
        <?php $i=1; foreach ($items as $it): ?>
            <tr>
                <td style="width:40px"><?= $i++ ?></td>
                <td><?= htmlspecialchars($it['food_name'] ?? '') ?></td>
                <td style="width:80px"><?= htmlspecialchars($it['quantity'] ?? '') ?></td>
                <td class="right"><?= isset($it['price_at_purchase']) ? number_format($it['price_at_purchase'],0,',','.') . ' đ' : '' ?></td>
                <td class="right"><?= (isset($it['price_at_purchase']) && isset($it['quantity'])) ? number_format($it['price_at_purchase'] * $it['quantity'],0,',','.') . ' đ' : '' ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="4" class="right"><strong>Tổng tiền</strong></td>
                <td class="right"><strong><?= number_format($orderArr['total_money'] ?? 0,0,',','.') ?> đ</strong></td>
            </tr>
        </tfoot>
    </table>

    <h3>Người giao hàng</h3>
    <table>
        <tr><td class="no-border" style="width:150px">Shipper</td><td class="no-border"><?= htmlspecialchars($orderArr['shipper_name'] ?? 'Chưa có') ?></td></tr>
        <tr><td class="no-border">SĐT shipper</td><td class="no-border"><?= htmlspecialchars($orderArr['shipper_phone'] ?? '') ?></td></tr>
    </table>

    <h3>Ghi chú của khách hàng</h3>
    <div style="padding:10px;border:1px solid #e6e6e6;border-radius:6px;background:#fafafa;">
        <?= !empty($orderArr['note']) ? nl2br(htmlspecialchars($orderArr['note'])) : '<span class="small">Không có ghi chú</span>' ?>
    </div>

    <div style="margin-top:18px;text-align:right;">
        <button id="printBtn" onclick="window.print()" style="padding:8px 14px;border-radius:6px;background:#0d6efd;color:#fff;border:none;">In hóa đơn</button>
    </div>
</div>
</body>
</html>
