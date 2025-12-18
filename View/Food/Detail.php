<div class="container" style="padding-top: 30px; margin-top: 70px;">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: none; padding-left: 0;">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="index.php?page=Food&cat_filter=<?= $food->getCategory_id() ?>">Thực đơn</a></li>
            <li class="active"><?= $food->getFood_name() ?></li>
        </ol>
    </nav>

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

    <div class="row" style="background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.05);">

        <div class="col-md-6 col-sm-12">
            <div class="detail-img-wrapper" style="width: 100%; height: 400px; background: #f8f9fa; display: flex; align-items: center; justify-content: center; border-radius: 8px; overflow: hidden; border: 1px solid #eee;">
                <img src="assets/img/img_foods/<?= $food->getImage_url() ?>" alt="<?= $food->getFood_name() ?>" style="max-width: 100%; max-height: 100%; object-fit: contain;">
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <h2 class="fw-bold text-dark" style="margin-top: 0; font-weight: 700;"><?= $food->getFood_name() ?></h2>

            <div style="margin-bottom: 15px;">
                <span class="label label-warning" style="font-size: 100%;">Danh mục: <?= $food->getCategory_id()  ?></span>
                <span class="text-warning" style="margin-left: 10px;">
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    <i class="glyphicon glyphicon-star"></i>
                    (5 đánh giá)
                </span>
            </div>

            <h3 class="text-danger" style="font-size: 28px; font-weight: bold; margin: 20px 0;">
                <?= $price_format ?>
            </h3>

            <p class="description" style="font-size: 16px; color: #555; line-height: 1.6; margin-bottom: 30px;">
                <?= $food->getDescription() ?>
            </p>

            <form action="index.php?page=Cart&action=AddToCart" method="POST" class="form-horizontal">
                <input type="hidden" name="page" value="Detail">
                <input type="hidden" name="food_id" value="<?= $food->getFood_id() ?>">
                <input type='hidden' name='food_name' value='<?= $food->getFood_name() ?>'>
                <input type='hidden' name='image_url' value='<?= $food->getImage_url() ?>'>
                <input type='hidden' name='price' value='<?= $food->getPrice() ?>'>
                <div class="form-group">
                    <label class="col-sm-3 control-label" style="text-align: left;">Số lượng:</label>
                    <div class="col-sm-4">
                        <div class="input-group">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number" onclick="updateQty(-1)">-</button>
                            </span>
                            <input type="text" name="quantity" id="quantity" class="form-control text-center" value="1" min="1" max="10">
                            <span class="input-group-btn">
                                <button type="button" class="btn btn-default btn-number" onclick="updateQty(1)">+</button>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-group" style="margin-top: 40px;">
                    <div class="col-sm-12">
                        <button type="submit" class="btn btn-primary btn-lg shadow-sm" style="padding: 10px 40px; border-radius: 5px;">
                            <i class="glyphicon glyphicon-shopping-cart"></i> Thêm vào giỏ
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="row" style="background: #fff; padding: 30px; border-radius: 8px; box-shadow: 0 2px 15px rgba(0,0,0,0.05); margin-top: 30px; margin-bottom: 30px">
        <div class="col-xs-12">
            <h3 style="border-bottom: 2px solid #e65100; display: inline-block; padding-bottom: 10px; margin-bottom: 30px; font-weight: bold;">
                Đánh giá khách hàng
            </h3>

            <div class="media" style="border-bottom: 1px solid #eee; padding-bottom: 15px; margin-bottom: 15px;">
                <div class="media-left">
                    <img class="media-object img-circle" src="https://via.placeholder.com/64" alt="Avatar" style="width: 50px;">
                </div>
                <div class="media-body">
                    <h4 class="media-heading fw-bold">Nguyễn Văn A <small class="text-muted">- 10/12/2025</small></h4>
                    <div class="text-warning" style="font-size: 12px; margin-bottom: 5px;">
                        <i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i>
                    </div>
                    <p>Món này rất ngon, giao hàng nhanh, sẽ ủng hộ shop dài dài!</p>
                </div>
            </div>

            <div class="media">
                <div class="media-left">
                    <img class="media-object img-circle" src="https://via.placeholder.com/64" alt="Avatar" style="width: 50px;">
                </div>
                <div class="media-body">
                    <h4 class="media-heading fw-bold">Trần Thị B <small class="text-muted">- 09/12/2025</small></h4>
                    <div class="text-warning" style="font-size: 12px; margin-bottom: 5px;">
                        <i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star"></i><i class="glyphicon glyphicon-star-empty"></i>
                    </div>
                    <p>Hương vị ổn, nhưng mình thích ngọt hơn một chút.</p>
                </div>
            </div>
        </div>
    </div>
    <!-- <div class="related-products" style="margin-top: 50px;">
        <h3 class="text-center" style="font-weight: bold; margin-bottom: 30px; text-transform: uppercase;">Món ăn cùng danh mục</h3>
        <div class="row">
            <?php if (!empty($related_foods)): ?>
                <?php foreach ($related_foods as $item): ?>
                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="thumbnail" style="border: none; box-shadow: 0 2px 5px rgba(0,0,0,0.1);">
                            <a href="index.php?controller=food&action=detail&id=<?= $item->getFood_id()  ?>">
                                <div style="height: 180px; width: 100%; display: flex; align-items: center; justify-content: center; background: #f9f9f9; overflow: hidden;">
                                    <img src="assets/img/img_foods/<?= $item->getImage_url() ?>" style="width: 100%; height: 100%; object-fit: cover;">
                                </div>
                            </a>
                            <div class="caption text-center">
                                <h5 style="font-weight: bold; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                                    <a href="#" style="text-decoration: none; color: #333;"><?= $item->getFood_name() ?></a>
                                </h5>
                                <p class="text-danger fw-bold"><?= number_format($item->getPrice(), 0, ',', '.') ?>đ</p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p class="text-center text-muted">Chưa có món ăn liên quan.</p>
            <?php endif; ?>
        </div>
    </div> -->
</div>

<script>
    function updateQty(change) {
        var qtyInput = document.getElementById('quantity');
        var currentQty = parseInt(qtyInput.value);
        var newQty = currentQty + change;

        if (newQty >= 1 && newQty <= 10) {
            qtyInput.value = newQty;
        }
    }

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