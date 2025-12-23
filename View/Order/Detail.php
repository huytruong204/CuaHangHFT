<div class="container mt-80 mb-50">
    
    <div class="mb-20">
        <a href="index.php?page=Order" class="btn btn-default">
            <i class="glyphicon glyphicon-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <?php if (!$order): ?>
        <div class="alert alert-danger">Không tìm thấy đơn hàng này!</div>
    <?php else: ?>
    
     <?php if (!empty($msg)): ?>
            <div class="alert alert-success"><?= htmlspecialchars($msg) ?></div>
        <?php endif; ?>
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger"><?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default box-shadow-sm">
                <div class="panel-heading panel-heading-orange">
                    <h4 class="panel-title">
                        Chi tiết đơn hàng #<?= $order['order_id'] ?>
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover table-no-margin" >
                        <thead>
                            <tr class="tr-bg-muted">
                                <th>Món ăn</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">SL</th>
                                <th class="text-right">Thành tiền</th>
                                <th class="text-center w-120">Đánh giá</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): 
                                $subtotal = $item['price_at_purchase'] * $item['quantity'];
                            ?>
                            <tr>
                                <td class="v-middle">
                                    <div class="media">
                                        <div class="media-left">
                                            <img class="media-object img-food-50" src="assets/img/img_foods/<?= $item['image_url'] ?>">
                                        </div>
                                        <div class="media-body v-middle">
                                            <h5 class="media-heading bold mt-5 fs-14"><?= $item['food_name'] ?></h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center v-middle">
                                    <?= number_format($item['price_at_purchase'], 0, ',', '.') ?>đ
                                </td>
                                <td class="text-center v-middle">
                                    x <?= $item['quantity'] ?>
                                </td>
                                <td class="text-right v-middle bold">
                                    <?= number_format($subtotal, 0, ',', '.') ?>đ
                                </td>
                                
                                <td class="text-center v-middle">
                                    <?php if ($order['status'] == 'Đã giao hàng'): ?>
                                        <?php if (!empty($userReviews) && !empty($userReviews[$item['food_id']])): ?>
                                            <a href="index.php?page=Review&product_id=<?= htmlspecialchars($item['food_id']) ?>&order_id=<?= htmlspecialchars($order['order_id']) ?>" class="btn btn-info btn-xs">
                                                <i class="glyphicon glyphicon-eye-open"></i> Xem lại đánh giá
                                            </a>
                                        <?php else: ?>
                                            <a href="index.php?page=Review&product_id=<?= htmlspecialchars($item['food_id']) ?>&order_id=<?= htmlspecialchars($order['order_id']) ?>" class="btn btn-warning btn-xs">
                                                <i class="glyphicon glyphicon-star"></i> Đánh giá
                                            </a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <button class="btn btn-default btn-xs" disabled title="Chỉ đánh giá khi đã nhận hàng">
                                            <i class="glyphicon glyphicon-star-empty"></i>
                                        </button>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr class="tr-bg-contrast">
                                <td colspan="4" class="text-right border-top-2">
                                    <h4 class="m-0">TỔNG CỘNG:</h4>
                                </td>
                                <td class="text-right border-top-2">
                                    <h3 class="m-0 text-orange">
                                        <?= number_format($order['total_money'], 0, ',', '.') ?>đ
                                    </h3>
                                </td>
                                <td class="border-top-2"></td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4 bg" >
            
            <div class="panel panel-default panel-top-orange">
                <div class="panel-body">
                    <h5 class="bold m-0 p-10 border-bottom-dashed">
                        TRẠNG THÁI ĐƠN HÀNG
                    </h5>
                    <div class="p-15">
                        <span class="label label-status-orange">
                            <?= $order['status'] ?>
                        </span>
                    </div>
                    <p class="text-muted small text-muted-padding"><i class="glyphicon glyphicon-time"></i> Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                    <?php 
                    $cancellable_statuses = ['Chờ xác nhận', 'Đã xác nhận'];
                    
                    if (in_array($order['status'], $cancellable_statuses)): 
                    ?>
                        <div class="p-15">
                            <form action="index.php?page=Order&action=cancel" method="POST" onsubmit="return confirm('Bạn có chắc chắn muốn hủy đơn hàng này không? Hành động này không thể hoàn tác.');">
                                <input type="hidden" name="order_id" value="<?= $order['order_id'] ?>">
                                <button type="submit" class="btn btn-danger btn-block">
                                    <i class="glyphicon glyphicon-trash"></i> Hủy đơn hàng
                                </button>
                            </form>
                            <p class="text-danger small mt-5 italic">
                                Chỉ có thể hủy khi đơn chưa được vận chuyển.
                            </p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="panel panel-default p-15">
                <div class="panel-heading panel-heading-light">
                    <strong class="text-dark"><i class="glyphicon glyphicon-user"></i> Người giao</strong>
                </div>
                <div class="panel-body">
                    <div class="panel-body">
                        <?php if (!empty($order['shipper_name'])): ?>
                            <p class="mb-5">
                                <strong>Họ tên:</strong> 
                                <?= $order['shipper_name'] ?>
                            </p>
                            <p class="mb-5">
                                <strong>Điện thoại:</strong> 
                                <a href="tel:<?= $order['shipper_phone'] ?>"><?= $order['shipper_phone'] ?></a>
                            </p>
                        <?php else: ?>
                            <p class="mb-5 text-muted italic text-center">
                                Đang cập nhật...
                            </p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="panel panel-default p-15">
                <div class="panel-heading panel-heading-light">
                    <strong class="text-dark"><i class="glyphicon glyphicon-user"></i> Người nhận</strong>
                </div>
                <div class="panel-body">
                    <p class="mb-5">
                        <strong>Họ tên:</strong> 
                        <?= $order['full_name'] ?>
                    </p>
                    <p class="mb-5">
                        <strong>Điện thoại:</strong>  
                        <?= $order['phone_number'] ?>
                    </p>
                    <p class="mb-5">
                        <strong>Địa chỉ:</strong> 
                        <?= $order['address'] ?> 
                        <?= !empty($order['city']) ? ', ' . $order['city'] : '' ?>
                    </p>
                    
                    <?php if (!empty($order['note'])): ?>
                        <div class="alert alert-warning mt-10 mb-0 p-10 fs-12">
                            <strong>Ghi chú:</strong> <?= $order['note'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
                
            <div class="panel panel-default p-15">
                <div class="panel-heading panel-heading-light">
                    <strong class="text-dark">Thanh toán</strong>
                </div>
                <div class="panel-body">
                    <p>
                        <strong>Hình thức:</strong> 
                        <?= ($order['payment_method'] == 'banking') ? 'Chuyển khoản' : 'Tiền mặt (COD)' ?>
                    </p>
                    <p>
                        <strong>Trạng thái:</strong> 
                        <?php if ($order['payment_status'] == 1): ?>
                            <span class="text-success fw-bold"><i class="glyphicon glyphicon-ok"></i> Đã thanh toán</span>
                        <?php else: ?>
                            <span class="text-danger fw-bold"><i class="glyphicon glyphicon-remove"></i> Chưa thanh toán</span>
                        <?php endif; ?>
                    </p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>