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
    <link rel="stylesheet" href="../../assets/css/style.css">
</head>
<body class="print-invoice">
<div class="invoice">
    <div class="invoice-header">
        <div>
            <h2>HÓA ĐƠN BÁN HÀNG</h2>
            <div>Mã hóa đơn: <strong><?= htmlspecialchars($invoice_no) ?></strong></div>
            <div>Mã đơn hàng: <strong><?= htmlspecialchars($orderArr['order_id'] ?? '') ?></strong></div>
            <div>Ngày phát hành: <strong><?= htmlspecialchars($invoiceArr['issued_date'] ?? date('Y-m-d H:i:s')) ?></strong></div>
        </div>
    </div>

    <h3>Thông tin khách hàng</h3>
    <table>
        <tr><td class="no-border width-150">Họ tên</td><td class="no-border"><?= htmlspecialchars($orderArr['full_name'] ?? '') ?></td></tr>
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
                <td class="width-40"><?= $i++ ?></td>
                <td><?= htmlspecialchars($it['food_name'] ?? '') ?></td>
                <td class="width-80"><?= htmlspecialchars($it['quantity'] ?? '') ?></td>
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
        <tr><td class="no-border width-150">Shipper</td><td class="no-border"><?= htmlspecialchars($orderArr['shipper_name'] ?? 'Chưa có') ?></td></tr>
        <tr><td class="no-border">SĐT shipper</td><td class="no-border"><?= htmlspecialchars($orderArr['shipper_phone'] ?? '') ?></td></tr>
    </table>

    <h3>Ghi chú của khách hàng</h3>
    <div class="note-box">
        <?= !empty($orderArr['note']) ? nl2br(htmlspecialchars($orderArr['note'])) : '<span class="text-small">Không có ghi chú</span>' ?>
    </div>

    <div class="" style="margin-top:18px;text-align:right;">
        <button id="printBtn" onclick="window.print()" class="btn-print">In hóa đơn</button>
    </div>
</div>
</body>
</html>
