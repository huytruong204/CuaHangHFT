<div class="container-fluid pt-4 px-4">

    <div class="bg-secondary text-center rounded p-4">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <h3 class="mb-0 text-primary">Quản lý đơn hàng</h3>
            <div></div>
        </div>
        <?php if (!empty($msg_success)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg_success) ?></div>
        <?php endif; ?>
        <?php if (!empty($msg_error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($msg_error) ?></div>
        <?php endif; ?>
        <form action="index.php" method="GET" class="mb-4">
            <input type="hidden" name="page" value="OrderAdmin">
            <div class="row g-2">
                <div class="col-md-4">
                    <select class="form-select" name="status">
                        <option value="">-- Tất cả trạng thái --</option>
                        <?php
                        foreach ($status_map as $key => $label):
                            $is_selected = (isset($_GET['status']) && $_GET['status'] === $key) ? 'selected' : '';
                        ?>
                            <option value="<?= $key ?>" <?= $is_selected ?>>
                                <?= $label ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="col-md-2 d-flex gap-1">
                    <button type="submit" class="btn btn-primary w-100"><i class="fa fa-filter"></i> Lọc</button>
                    <a href="index.php?page=OrderAdmin" class="btn btn-outline-light" title="Xóa lọc"><i class="fa fa-sync"></i></a>
                </div>
            </div>
        </form>

        <div class="table-responsive">
            <table class="table table-hover align-middle text-start">
                <thead>
                    <tr>
                        <th scope="col" class="width-100">Mã ĐH</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Ngày đặt</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col" class="text-center width-150">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($orders)): ?>
                        <tr>
                            <td colspan="6" class="text-center py-5 text-muted">
                                <i class="fa fa-file-invoice fa-3x mb-3"></i>
                                <p>Không tìm thấy đơn hàng nào.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($orders as $order): ?>
                            <?php
                            // Xử lý màu sắc Badge
                            $statusColor = 'secondary';
                            switch ($order->getStatus()) {
                                case 'Chờ xác nhận':
                                    $statusColor = 'warning text-dark';
                                    break;
                                case 'Đã xác nhận':
                                    $statusColor = 'info text-dark';
                                    break;
                                case 'Đang chuẩn bị':
                                case 'Chờ shipper':
                                    $statusColor = 'primary';
                                    break;
                                case 'Đang giao hàng':
                                    $statusColor = 'primary';
                                    break;
                                case 'Đã giao hàng':
                                    $statusColor = 'success';
                                    break;
                                case 'Đã hủy':
                                case 'Hoàn tiền':
                                    $statusColor = 'danger';
                                    break;
                            }
                            ?>
                            <tr>
                                <td class="fw-bold">#<?= $order->getOrderId() ?></td>
                                <td>
                                    <span class="fw-bold"><?= $order->getUserId() ?></span>
                                </td>
                                <td><?= date('d/m/Y H:i', strtotime($order->getCreatedAt() ?? 'now')) ?></td>
                                <td class="text-danger fw-bold">
                                    <?= number_format($order->getTotal_money(), 0, ',', '.') ?>đ
                                </td>
                                <td>
                                    <span class="badge bg-<?= $statusColor ?>">
                                        <?= $order->getStatus() ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-center gap-2">
                                            <a href="index.php?page=orderAdmin&action=Detail&order_id=<?= $order->getOrderId() ?>"
                                                class="btn btn-sm btn-outline-info btn-sm-wide minw-110" title="Xem chi tiết">
                                                <i class="fa fa-eye"></i>
                                                <span class="ml-6">Chi tiết</span>
                                            </a>
                                        <?php if ($order->getStatus() === 'Đã xác nhận'): ?>
                                            <a href="index.php?page=OrderAdmin&action=PrintView&order_id=<?= $order->getOrderId() ?>" target="_blank" class="btn btn-sm btn-outline-success btn-sm-wide minw-90" title="In hóa đơn">
                                                <i class="fa fa-print"></i>
                                                <span class="ml-6">In</span>
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if (isset($total_pages) && $total_pages > 1):
            $params = $_GET;
            unset($params['p']);
            $query_str = http_build_query($params);
        ?>
            <div class="d-flex justify-content-center mt-4">
                <nav aria-label="Page navigation">
                    <ul class="pagination mb-0">
                        <?php
                        $prev_disabled = ($current_page <= 1) ? 'disabled' : '';
                        $prev_page = $current_page - 1;
                        echo "
                        <li class='page-item $prev_disabled'>
                            <a class='page-link' href='index.php?$query_str&p=$prev_page' aria-label='Previous'>
                                <span aria-hidden='true'>&laquo;</span>
                            </a>
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
                        echo "
                        <li class='page-item $next_disabled'>
                            <a class='page-link' href='index.php?$query_str&p=$next_page' aria-label='Next'>
                                <span aria-hidden='true'>&raquo;</span>
                            </a>
                        </li>";
                        ?>
                    </ul>
                </nav>
            </div>
        <?php endif; ?>

    </div>
</div>