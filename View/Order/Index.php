<div class="container" style="margin-top: 80px; min-height: 70vh; ">
    <h2 class="text-center text-uppercase fw-bold" style="margin-bottom: 30px; color: #333;">Lịch sử đơn hàng</h2>
    <?php if (!empty($msg)): ?>
        <div id="cart-notification" class="success-popup">
            <div class="popup-content">
                <div class="icon-box">
                    <span>&#10003;</span>
                </div>
                <h3>Thành công!</h3>
                <p><?= $msg ?></p>
                <button onclick="closePopup()">Đóng</button>
            </div>
        </div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <?php
            ?>
            <ul class="nav nav-tabs" style="margin-bottom: 20px; font-weight: bold; border-bottom: 2px solid #e65100;">
                <li class="<?= ($stt == 'all') ? 'active' : '' ?>">
                    <a href="index.php?page=Order" style="color: #333;">Tất cả</a>
                </li>

                <li class="<?= ($stt == 'wait') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=wait" style="color: #f0ad4e;">Chờ xác nhận</a>
                </li>

                <li class="<?= ($stt == 'confirmed') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=confirmed" style="color: #337ab7;">Đã xác nhận</a>
                </li>

                <li class="<?= ($stt == 'preparing') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=preparing" style="color: #5bc0de;">Đang chuẩn bị</a>
                </li>

                <li class="<?= ($stt == 'wait_ship') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=wait_ship" style="color: #607d8b;">Chờ shipper</a>
                </li>

                <li class="<?= ($stt == 'shipping') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=shipping" style="color: #e65100;">Đang giao</a>
                </li>

                <li class="<?= ($stt == 'delivered') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=delivered" style="color: #5cb85c;">Đã giao</a>
                </li>

                <li class="<?= ($stt == 'cancelled') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=cancelled" style="color: #d9534f;">Đã hủy</a>
                </li>

                <li class="<?= ($stt == 'refund') ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=refund" style="color: #999;">Hoàn tiền</a>
                </li>
            </ul>
            <?php if (!empty($orders)): ?>
                <div class="table-responsive" style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <table class="table table-hover">
                        <thead>
                            <tr style="background-color: #f9f9f9;">
                                <th>Mã đơn</th>
                                <th>Ngày đặt</th>
                                <th>Tổng tiền</th>
                                <th class="text-center">Thanh toán</th>
                                <th>Trạng thái</th>
                                <th class="text-center">Hành động</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            foreach ($orders as $order): ?>
                                <?php
                                $statusText = $order->getStatus();
                                $statusClass = 'label-default';

                                switch ($statusText) {
                                    case 'Chờ xác nhận':
                                        $statusClass = 'label-warning';
                                        break;
                                    case 'Đã xác nhận':
                                        $statusClass = 'label-primary';
                                        break;
                                    case 'Đang chuẩn bị':
                                        $statusClass = 'label-info';
                                        break;
                                    case 'Chờ shipper':
                                        $statusClass = 'label-default';
                                        break;
                                    case 'Đang giao hàng':
                                        $statusClass = 'label-warning';
                                        break;
                                    case 'Đã giao hàng':
                                        $statusClass = 'label-success';
                                        break;
                                    case 'Đã hủy':
                                        $statusClass = 'label-danger';
                                        break;
                                    case 'Hoàn tiền':
                                        $statusClass = 'label-primary';
                                        break;
                                }

                                $payMethod = $order->getPaymentMethod();
                                $payText = ($payMethod == 'banking') ? 'Chuyển khoản' : 'Tiền mặt';
                                $payBadge = ($payMethod == 'banking') ? 'label-info' : 'label-default';
                                ?>
                                <tr>
                                    <td><strong>#<?= $order->getOrderId() ?></strong></td>

                                    <td><?= date('d/m/Y H:i', strtotime($order->getCreatedAt())) ?></td>

                                    <td style="color:#e65100;font-weight:bold;">
                                        <?= number_format($order->getTotal_money(), 0, ',', '.') ?>đ
                                    </td>
                                    <td class="text-center">
                                        <span class="label <?= $payBadge ?>" style="font-size: 13px; opacity: 0.8;"><?= $payText ?></span>
                                    </td>
                                    <td>
                                        <span class="label <?= $statusClass ?>" style="font-size:13px;padding:5px 10px;">
                                            <?= $statusText ?>
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <a href="index.php?page=Order&action=Detail&order_id=<?= $order->getOrderId() ?>"
                                            class="btn btn-sm btn-primary btn-outline">
                                            <i class="glyphicon glyphicon-eye-open"></i> Xem chi tiết
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center" style="padding: 50px; background: white; border-radius: 8px;">
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="100" style="opacity: 0.5; margin-bottom: 20px;">
                    <p class="text-muted">Bạn chưa có đơn hàng nào.</p>
                    <a href="index.php?page=Food" class="btn btn-primary">Đặt món ngay</a>
                </div>
            <?php endif; ?>
        </div>
        <?php if (isset($total_pages) && $total_pages > 1):
            $params = $_GET;
            unset($params['p']);
            $query_str = http_build_query($params);
        ?>
            <div class="text-center mb-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <?php
                        $prev_disabled = ($current_page <= 1) ? 'disabled' : '';
                        $prev_page = $current_page - 1;
                        $link_prev = "<a class='page-link ' href='index.php?$query_str&p=$prev_page' aria-label='Previous'>
                                <span aria-hidden='true' class='glyphicon glyphicon-chevron-left'></span>
                            </a>";
                        if (!empty($prev_disabled))
                            $link_prev = "<a class='page-link' aria-label='Previous'> <span aria-hidden='true' class='glyphicon glyphicon-chevron-left'></span></a>";

                        echo "
                        <li class='page-item $prev_disabled'>
                            $link_prev
                        </li>";
                        ?>

                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                            $active = ($i == $current_page) ? 'active' : '';
                            echo "
                            <li class='page-item $active'>
                                <a class='page-link' href='index.php?$query_str&p=$i'>$i</a>
                            </li>";
                        }
                        ?>
                        <?php
                        $next_disabled = ($current_page >= $total_pages) ? 'disabled' : '';
                        $next_page = $current_page + 1;
                        $link_next = "<a class='page-link ' href='index.php?$query_str&p=$next_page' aria-label='Next'>
                                <span aria-hidden='true' class='glyphicon glyphicon-chevron-right'></span>
                            </a>";
                        if (!empty($next_disabled))
                            $link_next = "<a class='page-link' aria-label='Next'>
                                <span aria-hidden='true' class='glyphicon glyphicon-chevron-right'></span>
                            </a>";

                        echo "
                        <li class='page-item $next_disabled '>
                            $link_next
                        </li>";
                        ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>
    </div>
</div>
</div>
<script>
    function closePopup() {
        var popup = document.getElementById("cart-notification");
        if (popup) {
            popup.style.display = "none";
        }
    }

    setTimeout(function() {
        closePopup();
    }, 3000);
</script>