<div class="container mt-80 min-h-70vh">
    <h2 class="text-center text-uppercase fw-bold mb-30">Lịch sử đơn hàng</h2>
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
            <ul class="nav nav-tabs mb-20 tabs-underline">
                <li class="<?= ($stt == '') ? 'active' : '' ?>">
                    <a href="index.php?page=Order">Tất cả</a>
                </li>
                <?php foreach($status_map as $key => $status):?>
                    <li class="<?= ($stt == $key) ? 'active' : '' ?>">
                    <a href="index.php?page=Order&status=<?= $key ?>"><?= $status ?></a>
                </li>
                <?php endforeach; ?>
            </ul>
            <?php if (!empty($orders)): ?>
                <div class="table-responsive card-white box-shadow-md rounded-8">
                    <table class="table table-hover">
                        <thead>
                            <tr class="tr-bg-muted">
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

                                $payMethod = $order->getPaymentMethod();
                                $payText = ($payMethod == 'banking') ? 'Chuyển khoản' : 'Tiền mặt';
                                ?>
                                <tr>
                                    <td><strong>#<?= $order->getOrderId() ?></strong></td>

                                    <td><?= date('d/m/Y H:i', strtotime($order->getCreatedAt())) ?></td>

                                    <td class="text-orange bold">
                                        <?= number_format($order->getTotal_money(), 0, ',', '.') ?>đ
                                    </td>
                                    <td class="text-center">
                                        <span class="label label-small"><?= $payText ?></span>
                                    </td>
                                    <td>
                                        <span class="label label-small">
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
                <div class="text-center card-white p-50 rounded-8">
                    <img src="https://cdn-icons-png.flaticon.com/512/2038/2038854.png" width="100" class="opacity-50 mb-20">
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