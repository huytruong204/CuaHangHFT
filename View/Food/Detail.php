<?php

$is_sold_out = (method_exists($food, 'getStatus') && $food->getStatus() == 0);
$sold_class = $is_sold_out ? ' sold-out' : '';
?>
<link rel="stylesheet" href="assets/css/detail.css">

<div class="container detail-page-container">

    <nav aria-label="breadcrumb">
        <ol class="breadcrumb detail-breadcrumb">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="index.php?page=Food">Thực đơn</a></li>
            <li class="active"><?= $food->getFood_name() ?></li>
        </ol>
    </nav>

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

    <div class="row detail-card">

        <div class="col-md-6 col-sm-12">
            <div class="detail-img-wrapper<?= $sold_class ?>">

                <?php if ($is_sold_out): ?>
                    <span class="sold-badge">TẠM HẾT</span>
                <?php endif; ?>

                <img class="food-image" src="assets/img/img_foods/<?= $food->getImage_url() ?>" alt="<?= $food->getFood_name() ?>">
            </div>
        </div>

        <div class="col-md-6 col-sm-12">
            <h2 class="fw-bold text-dark food-title"><?= $food->getFood_name() ?></h2>

            <div class="food-meta">
                <span class="label label-warning">Danh mục: <?= $food->getCategory_id()  ?></span>
            </div>

            <h3 class="text-danger price"><?= $price_format ?></h3>

            <p class="description"><?= $food->getDescription() ?></p>

            <?php if ($is_sold_out): ?>

                <div class="alert detail-alert">
                    <i class="glyphicon glyphicon-info-sign"></i> Sản phẩm này hiện đang tạm ngưng kinh doanh.
                </div>
                <div class="form-group" style="margin-top: 20px;">
                    <button type="button" class="btn btn-default btn-lg btn-fullwidth" disabled>
                        <i class="glyphicon glyphicon-ban-circle"></i> TẠM NGƯNG BÁN
                    </button>
                </div>

            <?php else: ?>

                <form action="index.php?page=Cart&action=AddToCart" method="POST" class="form-horizontal">
                    <input type="hidden" name="page" value="Detail">
                    <input type="hidden" name="food_id" value="<?= $food->getFood_id() ?>">
                    <input type='hidden' name='food_name' value='<?= $food->getFood_name() ?>'>
                    <input type='hidden' name='image_url' value='<?= $food->getImage_url() ?>'>
                    <input type='hidden' name='price' value='<?= $food->getPrice() ?>'>

                    <div class="input-group" style="width: 120px;">

                        <span class="input-group-btn" style="width: 35px;">
                            <button type="button" class="btn btn-default btn-number" onclick="updateQty(-1)">
                                <span class="glyphicon glyphicon-minus"></span>
                            </button>
                        </span>

                        <input type="text"
                            name="quantity"
                            id="quantity"
                            class="form-control text-center"
                            value="1"
                            min="1"
                            max="10"
                            style="width: 50px !important; min-width: 50px; height: 34px; padding: 0;">

                        <span class="input-group-btn" style="width: 35px;">
                            <button type="button" class="btn btn-default btn-number" onclick="updateQty(1)">
                                <span class="glyphicon glyphicon-plus"></span>
                            </button>
                        </span>

                    </div>

                    <div class="form-group form-group margin-top-lg">
                        <div class="col-sm-12">
                            <button type="submit" class="btn btn-primary btn-lg shadow-sm btn-add-to-cart">
                                <i class="glyphicon glyphicon-shopping-cart"></i> Thêm vào giỏ
                            </button>
                        </div>
                    </div>
                </form>

            <?php endif; ?>
        </div>
    </div>

    <div class="row reviews-card">
        <div class="col-xs-12">
            <h3 class="reviews-heading">Đánh giá khách hàng</h3>

            <div class="rating-summary">
                <div class="rating-stars">
                    <?php
                    $avg = round($ratingInfo['avg'] ?? 0, 1);
                    $filled = (int)floor($avg);
                    for ($i = 1; $i <= 5; $i++) {
                        if ($i <= $filled) {
                            echo '<i class="glyphicon glyphicon-star"></i>';
                        } elseif ($i == $filled + 1 && $avg - $filled >= 0.5) {
                            echo '<i class="glyphicon glyphicon-star"></i>';
                        } else {
                            echo '<i class="glyphicon glyphicon-star-empty"></i>';
                        }
                    }
                    ?>
                </div>
                <div class="rating-value">
                    <strong><?= htmlspecialchars(number_format($avg, 1)) ?></strong> / 5 - <span class="text-muted"><?= (int)($ratingInfo['count'] ?? 0) ?> đánh giá</span>
                </div>
            </div>

            <?php if (empty($reviews)): ?>
                <div class="alert alert-info">Chưa có đánh giá nào cho sản phẩm này.</div>
            <?php else: ?>
                <?php foreach ($reviews as $r): ?>
                    <?php
                    $userName = htmlspecialchars($r['full_name'] ?? 'Người dùng');
                    $avatarSrc = UserHelper::avatar($r['avatar_url'] ?? '');
                    $created = !empty($r['created_at']) ? htmlspecialchars(date('d/m/Y', strtotime($r['created_at']))) : '';
                    ?>
                    <div class="media review-item">
                        <div class="media-left review-avatar">
                            <img class="media-object img-circle" src="<?= $avatarSrc ?>" alt="Avatar">
                        </div>
                        <div class="media-body">
                            <h4 class="media-heading fw-bold"><?= $userName ?> <small class="text-muted"><?= $created ? ('- ' . $created) : '' ?></small></h4>
                            <div class="review-stars">
                                <?php $stars = (int)($r['rating'] ?? 0);
                                for ($s = 1; $s <= 5; $s++): ?>
                                    <?php if ($s <= $stars): ?>
                                        <i class="glyphicon glyphicon-star"></i>
                                    <?php else: ?>
                                        <i class="glyphicon glyphicon-star-empty"></i>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                            <p class="review-text"><?= nl2br(htmlspecialchars($r['comment'] ?? '')) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
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