<div class="container" style="padding-top: 30px; margin-top: 70px; margin-bottom: 50px;">

    <div class="row">
        <div class="col-md-12">
            <h2 class="fw-bold text-dark" style="border-bottom: 3px solid #e65100; display: inline-block; padding-bottom: 10px; margin-bottom: 30px;">
                Giỏ hàng của bạn
            </h2>
        </div>
    </div>

    <?php if (empty($cart_items)): ?>
        <div class="row text-center" style="background: #fff; padding: 50px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
            <div class="col-md-12">
                <i class="glyphicon glyphicon-shopping-cart" style="font-size: 60px; color: #ddd;"></i>
                <h3 style="color: #666;">Giỏ hàng đang trống!</h3>
                <p>Hãy chọn những món ăn ngon tuyệt vời từ thực đơn của chúng tôi.</p>
                <a href="index.php?page=Food" class="btn btn-lg" style="background-color: #e65100; color: white; margin-top: 20px;">
                    QUAY LẠI THỰC ĐƠN
                </a>
            </div>
        </div>
    <?php else: ?>


        <div class="row">
            <div class="col-md-8 col-sm-12">
                <div class="table-responsive" style="background: #fff; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05); padding: 15px;">
                    <table class="table table-hover align-middle">
                        <thead>
                            <tr style="background-color: #f9f9f9; color: #333;">
                                <th style="width: 100px;">Ảnh</th>
                                <th>Tên món</th>
                                <th>Đơn giá</th>
                                <th style="width: 150px; text-align: center;">Số lượng</th>
                                <th style="text-align: right;">Thành tiền</th>
                                <th style="width: 50px;"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($cart_items as $id => $item): ?>
                                <?php
                                $item_total = $item->price * $item->quantity;
                                $img_src = 'assets/img/img_foods/' . $item->image_url;
                                ?>
                                <tr>
                                    <td>
                                        <img src="<?= $img_src ?>" alt="<?= $item->food_name ?>"
                                            style="width: 80px; height: 80px; object-fit: cover; border-radius: 5px;">
                                    </td>

                                    <td style="vertical-align: middle;">
                                        <h5 style="font-weight: bold; margin: 0;">
                                            <?= $item->food_name ?>
                                        </h5>
                                    </td>

                                    <td style="vertical-align: middle; color: #555;">
                                        <?= number_format($item->price, 0, ',', '.') ?>đ
                                    </td>

                                    <td style="vertical-align: middle;">
                                        <form action="index.php?page=Cart&action=UpdateToCart" method="POST">
                                            <div class="input-group" style="width: 120px; margin: 0 auto;">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" onclick="updateQty(this, -1)">
                                                        <span class="glyphicon glyphicon-minus"></span>
                                                    </button>
                                                </span>
                                                <input type="hidden" name="food_id" value="<?= $id ?>">
                                                <input type="text"
                                                    name="quantity"
                                                    value="<?= $item->quantity ?>"
                                                    class="form-control text-center"
                                                    min="1"
                                                    max="99"
                                                    onkeypress="return event.charCode >= 48 && event.charCode <= 57">
                                                <span class="input-group-btn">
                                                    <button type="button" class="btn btn-default" onclick="updateQty(this, 1)">
                                                        <span class="glyphicon glyphicon-plus"></span>
                                                    </button>
                                                </span>
                                            </div>
                                        </form>
                                    </td>

                                    <td style="vertical-align: middle; text-align: right; font-weight: bold; color: #d32f2f;">
                                        <?= number_format($item_total, 0, ',', '.') ?>đ
                                    </td>

                                    <td style="vertical-align: middle; text-align: center;">
                                        <a href="index.php?page=Cart&action=DeleteToCart&food_id=<?= $id ?>"
                                            class="text-danger"
                                            onclick="return confirm('Bạn có chắc muốn xóa món này?');"
                                            title="Xóa">
                                            <i class="glyphicon glyphicon-trash"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>

                        </tbody>
                    </table>

                    <div class="text-left" style="margin-top: 10px;">
                        <a href="index.php?page=Food" class="btn btn-link" style="color: #e65100;">&larr; Tiếp tục mua hàng</a>
                    </div>
                </div>
            </div>

            <div class="col-md-4 col-sm-12">
                <div style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">
                    <h4 style="font-weight: bold; margin-top: 0;">Cộng giỏ hàng</h4>
                    <hr>
                    <div class="clearfix" style="margin-bottom: 10px;">
                        <span class="pull-left">Tạm tính:</span>
                        <span class="pull-right fw-bold"><?= number_format($total_amount, 0, ',', '.') ?>đ</span>
                    </div>
                    <div class="clearfix" style="margin-bottom: 10px;">
                        <span class="pull-left">Phí vận chuyển:</span>
                        <span class="pull-right text-success">Miễn phí</span>
                    </div>
                    <hr>
                    <div class="clearfix" style="margin-bottom: 20px;">
                        <span class="pull-left" style="font-size: 18px; font-weight: bold;">TỔNG TIỀN:</span>
                        <span class="pull-right" style="font-size: 22px; font-weight: bold; color: #e65100;">
                            <?= number_format($total_amount, 0, ',', '.') ?>đ
                        </span>
                    </div>

                    <a href="index.php?page=Cart&action=Checkout" class="btn btn-block btn-lg" style="background-color: #e65100; color: white; font-weight: bold; border-radius: 5px;">
                        TIẾN HÀNH THANH TOÁN
                    </a>
                </div>

                <div style="margin-top: 20px; background: #fffbe6; padding: 15px; border-radius: 5px; border: 1px dashed #e65100; color: #e65100; font-size: 13px;">
                    <i class="glyphicon glyphicon-gift"></i>
                    <strong>Ưu đãi:</strong> Miễn phí vận chuyển cho đơn hàng trên 200.000đ.
                </div>
            </div>
        </div>
    <?php endif; ?>
</div>
<script>
    function updateQty(btn, change) {
        var form = btn.closest('form');

        var input = form.querySelector('input[name="quantity"]');

        var currentQty = parseInt(input.value);
        if (isNaN(currentQty)) currentQty = 1;

        var newQty = currentQty + change;
        console.log(newQty);
        input.value = newQty;
        form.submit();
    }
</script>