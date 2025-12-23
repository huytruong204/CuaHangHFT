<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Đơn hôm nay</p>
                    <h6 class="mb-0"><?php echo $statistics['orders_today'] ?? 0; ?> Đơn</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Doanh thu ngày</p>
                    <h6 class="mb-0"><?php echo number_format($statistics['revenue_day'] ?? 0); ?>đ</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Doanh thu tháng</p>
                    <h6 class="mb-0"><?php echo number_format($statistics['revenue_month'] ?? 0); ?>đ</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Tổng món ăn</p>
                    <h6 class="mb-0"><?= $countFood ?> Món</h6> 
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid pt-4 px-4">
    <div class="bg-secondary text-center rounded p-4">
        <div class="d-flex align-items-center justify-content-between mb-4">
            <h6 class="mb-0">Đơn hàng mới nhất</h6>
            <a href="index.php?page=OrderAdmin">Xem tất cả</a>
        </div>
        <div class="table-responsive">
            <table class="table text-start align-middle table-bordered table-hover mb-0">
                <thead>
                    <tr class="text-dark">
                        <th scope="col">Mã đơn</th>
                        <th scope="col">Ngày đặt</th>
                        <th scope="col">Khách hàng</th>
                        <th scope="col">Tổng tiền</th>
                        <th scope="col">Trạng thái</th>
                        <th scope="col">Hành động</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentOrders)): ?>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td>#<?php echo $order->getOrderId(); ?></td>
                                <td><?php echo date('d M Y', strtotime($order->getCreatedAt())); ?></td>
                                <td><?php echo $order->getUserId(); ?></td> 
                                <td><?php echo number_format($order->getTotal_money()); ?>đ</td>
                                <td>
                                    <?php 
                                        $status = $order->getStatus();
                                        $badgeClass = 'bg-secondary';
                                        $statusText = $status;
                                        switch ($status) {
                                            case 'Chờ xác nhận':
                                                $badgeClass = 'bg-warning text-dark';
                                                break;
                                            case 'Đã xác nhận':
                                                $badgeClass = 'bg-info text-dark';
                                                break;
                                            case 'Đang chuẩn bị':
                                            case 'Chờ shipper':
                                                $badgeClass = 'bg-primary';
                                                break;
                                            case 'Đang giao hàng':
                                                $badgeClass = 'bg-primary';
                                                break;
                                            case 'Đã giao hàng':
                                                $badgeClass = 'bg-success';
                                                break;
                                            case 'Đã hủy':
                                            case 'Hoàn tiền':
                                                $badgeClass = 'bg-danger';
                                                break;
                                        }
                                    ?>
                                    <span class="badge <?php echo $badgeClass; ?>"><?php echo $statusText; ?></span>
                                </td>
                                <td><a class="btn btn-sm btn-primary" href="index.php?page=OrderAdmin&action=Detail&order_id=<?php echo $order->getOrderId(); ?>">Chi tiết</a></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr class="text-center"><td colspan="6">Không có đơn hàng nào.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>