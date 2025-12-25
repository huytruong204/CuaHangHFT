<div class="container min-h-70vh" style="margin-top: 20px">
    <h2 class="text-center text-uppercase fw-bold mb-30">Lịch sử đơn hàng</h2>

    <?php if (!empty($msg)): ?>
        <div id="cart-notification" class="success-popup">
            <div class="popup-content">
                <div class="icon-box"><span>&#10003;</span></div>
                <h3>Thành công!</h3>
                <p><?= $msg ?></p>
                <button onclick="closePopup()">Đóng</button>
            </div>
        </div>
    <?php endif; ?>
    <?php if (!empty($error)): ?>
        <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card-white box-shadow-sm rounded-8 p-15 mb-20">
                <form action="index.php" method="GET" class="form-inline" style="display: flex; gap: 10px; flex-wrap: wrap; align-items: flex-end;">
                    <input type="hidden" name="page" value="Order">

                    <div class="form-group">
                        <label for="search_id" class="sr-only">Mã đơn</label>
                        <input type="text" class="form-control" name="search_id" id="search_id"
                            value="<?= isset($_GET['search_id']) ? htmlspecialchars($_GET['search_id']) : '' ?>"
                            placeholder="Nhập mã đơn hàng...">
                    </div>

                    <div class="form-group">
                        <select name="status" class="form-control">
                            <option value="">-- Tất cả trạng thái --</option>
                            <?php foreach ($status_map as $key => $status_label): ?>
                                <option value="<?= $key ?>" <?= ($stt == $key) ? 'selected' : '' ?>>
                                    <?= $status_label ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="fs-12" style="display:block; margin-bottom: 2px;">Từ ngày:</label>
                        <input type="date" class="form-control" name="date_from"
                            value="<?= isset($_GET['date_from']) ? $_GET['date_from'] : '' ?>">
                    </div>

                    <div class="form-group">
                        <label class="fs-12" style="display:block; margin-bottom: 2px;">Đến ngày:</label>
                        <input type="date" class="form-control" name="date_to"
                            value="<?= isset($_GET['date_to']) ? $_GET['date_to'] : '' ?>">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary btn-orange">
                            <i class="glyphicon glyphicon-search"></i> Lọc
                        </button>
                        <a href="index.php?page=Order" class="btn btn-default">Xóa lọc</a>
                    </div>
                </form>
            </div>
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
                            <?php foreach ($orders as $order): ?>
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
                                        <span class="label label-small"><?= $statusText ?></span>
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
                    <p class="text-muted">Không tìm thấy đơn hàng nào phù hợp.</p>
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