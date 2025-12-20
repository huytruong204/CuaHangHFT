<div class="container" style="margin-top: 80px; margin-bottom: 50px;">
    
    <div style="margin-bottom: 20px;">
        <a href="index.php?page=Order" class="btn btn-default">
            <i class="glyphicon glyphicon-arrow-left"></i> Quay lại danh sách
        </a>
    </div>

    <?php if (!$order): ?>
        <div class="alert alert-danger">Không tìm thấy đơn hàng này!</div>
    <?php else: ?>

    <div class="row">
        <div class="col-md-8">
            <div class="panel panel-default" style="box-shadow: 0 2px 5px rgba(0,0,0,0.05);">
                <div class="panel-heading" style="background-color: #e65100; color: white;">
                    <h4 class="panel-title" style="font-weight: bold;">
                        <i class="glyphicon glyphicon-list-alt"></i> Chi tiết đơn hàng #<?= $order['order_id'] ?>
                    </h4>
                </div>
                <div class="table-responsive">
                    <table class="table table-hover" style="margin-bottom: 0;">
                        <thead>
                            <tr style="background: #f9f9f9;">
                                <th>Món ăn</th>
                                <th class="text-center">Đơn giá</th>
                                <th class="text-center">SL</th>
                                <th class="text-right">Thành tiền</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($items as $item): 
                                $subtotal = $item['price_at_purchase'] * $item['quantity'];
                            ?>
                            <tr>
                                <td style="vertical-align: middle;">
                                    <div class="media">
                                        <div class="media-left">
                                            <img class="media-object" src="assets/img/img_foods/<?= $item['image_url'] ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                        </div>
                                        <div class="media-body" style="vertical-align: middle;">
                                            <h5 class="media-heading" style="font-weight: bold; margin-top: 5px; font-size: 14px;"><?= $item['food_name'] ?></h5>
                                        </div>
                                    </div>
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    <?= number_format($item['price_at_purchase'], 0, ',', '.') ?>đ
                                </td>
                                <td class="text-center" style="vertical-align: middle;">
                                    x <?= $item['quantity'] ?>
                                </td>
                                <td class="text-right" style="vertical-align: middle; font-weight: bold;">
                                    <?= number_format($subtotal, 0, ',', '.') ?>đ
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                        <tfoot>
                            <tr style="background: #fffcf5;">
                                <td colspan="3" class="text-right" style="border-top: 2px solid #eee;">
                                    <h4 style="margin: 0; font-weight: bold;">TỔNG CỘNG:</h4>
                                </td>
                                <td class="text-right" style="border-top: 2px solid #eee;">
                                    <h3 style="margin: 0; color: #e65100; font-weight: bold;">
                                        <?= number_format($order['total_money'], 0, ',', '.') ?>đ
                                    </h3>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-4 bg" >
            
            <div class="panel panel-default" style="border-top: 3px solid #e65100;">
                <div class="panel-body">
                    <h5 style="font-weight: bold; margin-top: 0; border-bottom: 1px dashed #ddd; padding: 10px;">
                        TRẠNG THÁI ĐƠN HÀNG
                    </h5>
                    <?php
                        $statusClass = 'label-default';
                        $stt = $order['status'];
                        if($stt == 'Chờ xác nhận') $statusClass = 'label-warning';
                        elseif($stt == 'Đã giao hàng') $statusClass = 'label-success';
                        elseif($stt == 'Đã hủy') $statusClass = 'label-danger';
                    ?>
                    <div style="margin: 15px 0;">
                        <span class="label <?= $statusClass ?>" style="font-size: 14px; padding: 10px; display: block; text-align: center;">
                            <?= $stt ?>
                        </span>
                    </div>
                    <p class="text-muted small" style=" padding: 10px;"><i class="glyphicon glyphicon-time"></i> Ngày đặt: <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?></p>
                </div>
            </div>

            <div class="panel panel-default" style=" padding: 10px;">
                <div class="panel-heading" style="background: #f8f9fa;">
                    <strong style="color: #333;"><i class="glyphicon glyphicon-user"></i> Người nhận</strong>
                </div>
                <div class="panel-body">
                    <p style="margin-bottom: 5px;">
                        <strong>Họ tên:</strong> <br> 
                        <?= $order['full_name'] ?>
                    </p>
                    <p style="margin-bottom: 5px;">
                        <strong>Điện thoại:</strong> <br> 
                        <?= $order['phone_number'] ?>
                    </p>
                    <p style="margin-bottom: 5px;">
                        <strong>Địa chỉ:</strong> <br> 
                        <?= $order['address'] ?> 
                        <?= !empty($order['city']) ? ', ' . $order['city'] : '' ?>
                    </p>
                    
                    <?php if (!empty($order['note'])): ?>
                        <div class="alert alert-warning" style="margin-top: 10px; margin-bottom: 0; padding: 10px; font-size: 12px;">
                            <strong>Ghi chú:</strong> <?= $order['note'] ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="panel panel-default" style=" padding: 10px;">
                <div class="panel-heading" style="background: #f8f9fa;">
                    <strong style="color: #333;">Thanh toán</strong>
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