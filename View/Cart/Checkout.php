<div class="container" style="padding-top: 30px; margin-top: 70px; margin-bottom: 50px;">
    
    <?php if (!empty($msg)): ?>
        <div id="cart-notification" class="success-popup">
            <div class="popup-content">
                <!-- <div class="icon-box">
                    <span>&#10003;</span>
                </div>
                <h3>Thành công!</h3> -->
                <p><?= $msg ?></p>
                <button onclick="closePopup()">Đóng</button>
            </div>
        </div>
    <?php endif; ?>

    <?php if (!empty($cart_items)): ?>
        
        <h2 class="text-center text-uppercase fw-bold" style="margin-bottom: 30px; color: #333;">Xác nhận thanh toán</h2>
        
        <form action="index.php?page=Cart&action=CheckoutPost" method="POST">
            <div class="row">
                <div class="col-md-7 col-sm-12">
                    <div class="panel panel-default" style="box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 20px">
                        <div class="panel-heading" style="background-color: #e65100; color: white; font-weight: bold;">
                            <i class="glyphicon glyphicon-user"></i> Thông tin giao hàng
                        </div>
                        <div class="panel-body">
                            <div class="form-group">
                                <label>Họ và tên người nhận <span class="text-danger">*</span></label>
                                <input type="text" name="fullname" class="form-control" placeholder="Ví dụ: Nguyễn Văn A" >
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Số điện thoại <span class="text-danger">*</span></label>
                                        <input type="text" name="phone" class="form-control" placeholder="Ví dụ: 0987..." >
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label>Email (Tùy chọn)</label>
                                        <input type="email" name="email" class="form-control" placeholder="email@example.com">
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>Địa chỉ giao hàng <span class="text-danger">*</span></label>
                                <textarea name="address" class="form-control" rows="2" placeholder="Số nhà, tên đường, phường/xã..." ></textarea>
                            </div>

                            <div class="form-group">
                                <label>Ghi chú cho đơn hàng</label>
                                <textarea name="note" class="form-control" rows="2" placeholder="Ví dụ: Không bỏ hành, giao giờ hành chính..."></textarea>
                            </div>
                        </div>
                    </div>

                    <div class="panel panel-default" style="box-shadow: 0 2px 10px rgba(0,0,0,0.05); margin-top: 20px; padding: 20px">
                        <div class="panel-heading" style="background-color: #f8f9fa; color: #333; font-weight: bold;">
                            <i class="glyphicon glyphicon-credit-card"></i> Phương thức thanh toán
                        </div>
                        <div class="panel-body">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="payment_method" value="cod" checked>
                                    <strong>Thanh toán khi nhận hàng (COD)</strong>
                                    <p class="text-muted small">Bạn sẽ thanh toán tiền mặt cho shipper khi nhận được món ăn.</p>
                                </label>
                            </div>
                            <hr style="margin: 10px 0;">
                            <div class="radio">
                                <label>
                                    <input type="radio" name="payment_method" value="banking">
                                    <strong>Chuyển khoản ngân hàng</strong>
                                    <p class="text-muted small">Quét mã QR hoặc chuyển khoản qua STK ngân hàng.</p>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-5 col-sm-12">
                    <div class="panel panel-default" style="border: 2px solid #e65100;">
                        <div class="panel-heading" style="background-color: white; border-bottom: 1px dashed #ddd;">
                            <h4 class="text-center" style="margin: 0; color: #e65100; font-weight: bold;">Đơn hàng của bạn</h4>
                        </div>
                        <div class="panel-body" style="background: #fffcf5">
                            <table class="table" style="margin-bottom: 0;">
                                <tbody>
                                    <?php foreach ($cart_items as $item): ?>
                                    <tr>
                                        <td style="width: 60px;">
                                            <img src="assets/img/img_foods/<?= $item->image_url ?>" style="width: 50px; height: 50px; object-fit: cover; border-radius: 4px;">
                                        </td>
                                        <td>
                                            <div style="font-weight: 600;"><?= $item->food_name ?></div>
                                            <div class="text-muted small">x <?= $item->quantity ?></div>
                                        </td>
                                        <td class="text-right" style="font-weight: bold;">
                                            <?= number_format($item->price * $item->quantity, 0, ',', '.') ?>đ
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <hr>
                            <div class="row" style="padding: 0 10px">
                                <div class="col-xs-6">Tạm tính:</div>
                                <div class="col-xs-6 text-right"><?= number_format($total_amount, 0, ',', '.') ?>đ</div>
                            </div>
                            <div class="row" style="padding: 0 10px">
                                <div class="col-xs-6">Phí vận chuyển:</div>
                                <div class="col-xs-6 text-right text-success">Miễn phí</div>
                            </div>
                            <hr>
                            <div class="row" style="font-size: 18px; font-weight: bold; color: #d9534f; padding: 0 10px">
                                <div class="col-xs-6">TỔNG CỘNG:</div>
                                <div class="col-xs-6 text-right"><?= number_format($total_amount, 0, ',', '.') ?>đ</div>
                            </div>
                        </div>
                        <div class="panel-footer" style="background: white; padding: 20px;">
                            <button type="submit" class="btn btn-block btn-lg" style="background-color: #e65100; color: white; border: none; text-transform: uppercase; font-weight: bold;">
                                Đặt hàng ngay
                            </button>
                            <a href="index.php?page=Cart" class="btn btn-link btn-block text-muted">Quay lại giỏ hàng</a>
                        </div>
                    </div>
                </div>
            </div>
        </form>

    <?php else: ?>

        <div class="row">
            <div class="col-md-8 col-md-offset-2 col-sm-12">
                <div class="text-center" style="background: #fff; padding: 60px 20px; border-radius: 8px; box-shadow: 0 5px 20px rgba(0,0,0,0.05); border: 1px solid #eee;">
                    
                    <div style="margin-bottom: 25px;">
                        <div style="width: 120px; height: 120px; background: #fff5e6; border-radius: 50%; display: inline-flex; align-items: center; justify-content: center;">
                            <i class="glyphicon glyphicon-shopping-cart" style="font-size: 50px; color: #e65100;"></i>
                        </div>
                    </div>

                    <h3 style="font-weight: bold; color: #333; margin-bottom: 10px;">Giỏ hàng của bạn đang trống!</h3>
                    <p class="text-muted" style="font-size: 16px; margin-bottom: 30px; max-width: 80%; margin-left: auto; margin-right: auto;">
                        Có vẻ như bạn chưa chọn món ăn nào để thanh toán.<br>
                        Hãy quay lại thực đơn và chọn cho mình vài món ngon nhé!
                    </p>

                    <a href="index.php?page=Food" class="btn btn-lg shadow-sm" style="background-color: #e65100; color: white; padding: 12px 40px; border-radius: 50px; font-weight: bold; text-decoration: none; transition: all 0.3s;">
                        <i class="glyphicon glyphicon-menu-left"></i> Quay lại Thực đơn
                    </a>
                </div>
            </div>
        </div>

    <?php endif; ?>

</div>