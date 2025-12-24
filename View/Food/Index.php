<div class="container" style="padding-top: 30px;">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb" style="background: none; padding-left: 0;">
            <li><a href="index.php">Trang chủ</a></li>
            <li><a href="index.php?page=Food">Thực đơn</a></li>
        </ol>
    </nav>
    <div class="category-container">
        <form action="index.php" method="GET" class="form-inline">
            <input type="hidden" name="page" value="Food">
            <?php if (isset($_GET['cat_filter'])): ?>
                <input type="hidden" name="cat_filter" value="<?= htmlspecialchars($_GET['cat_filter']) ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="input-group" style="width: 100%;">
                        <input type="text" class="form-control" name="keyword" placeholder="Tìm tên món ăn..." value="<?= (isset($_GET['keyword'])) ? htmlspecialchars($_GET['keyword']) : '' ?>">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <select name="price_sort" class="form-control">
                        <option value="desc" <?= ($sort_price == 'desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                        <option value="asc" <?= ($sort_price == 'asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary btn-block">Lọc</button>
                    <?php if (!empty($where_clauses)): ?>
                        <a href="index.php?page=Food" class="btn btn-default btn-block" style="margin-top: 5px;">Bỏ lọc</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
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

    <div class="category-container">
        <div class="clearfix mb-4">
            <h3 class="pull-left mt-0 fw-bold text-dark" style="margin: 0;">Danh mục món ăn</h3>
            </div>

        <div class="category-scroll" id="category-list">
            <a class="btn category-btn <?= (empty($_GET['cat_filter'])) ? 'active' : '' ?>" href="Index.php?page=Food">Tất cả</a>
            <?php
            foreach ($list_cat as $cat) {
                $active = (isset($_GET['cat_filter']) && $_GET['cat_filter'] == $cat->getCategory_id()) ? 'active' : '';
                echo "<a class='btn category-btn $active' href='Index.php?page=Food&cat_filter={$cat->getCategory_id()}' >{$cat->getCategory_name()}</a>";
            }
            ?>
        </div>
    </div>

    <div class="food-display-area">
        <?php if (!empty($grouped_foods)): ?>
            
            <?php foreach ($grouped_foods as $category_name => $foods_in_cat): ?>
                
                <div class="category-container" style="margin-bottom: 10px;">
                    
                    <div class="clearfix mb-3">
                        <h3 class="pull-left mt-0 fw-bold text-primary" style="margin: 0; padding-left: 7px; padding-bottom: 15px;">
                            <?= htmlspecialchars($category_name) ?> 
                            <small class="text-muted" style="font-size: 14px; margin-left: 5px;">(<?= count($foods_in_cat) ?> món)</small>
                        </h3>
                    </div>

                    <div class="row">
                        <?php foreach ($foods_in_cat as $food): ?>
                            <?php
                                $price_format = number_format($food->getPrice(), 0, ',', '.') . 'đ';
                                $img_src = 'assets/img/img_foods/' . $food->getImage_url();
                                $is_sold_out = false;
                                if ($food->getStatus() == 0) {
                                    $is_sold_out = true;
                                }
                                $card_class = $is_sold_out ? 'sold-out-mode' : '';
                                $badge_html = $is_sold_out ? "<span class='badge-sold-out'>Tạm ngừng bán</span>" : "";
                                
                                if ($is_sold_out) {
                                    $action_btn = "
                                    <button type='button' class='btn-disabled' disabled title='Sản phẩm tạm ngưng bán'>
                                        <span class='glyphicon glyphicon-ban-circle'></span>
                                    </button>";
                                } else {
                                    $action_btn = "
                                        <form action='index.php?page=Cart&action=AddToCart' method='post'>
                                            <input type='hidden' name='page' value='Food'>
                                            <input type='hidden' name='food_id' value='{$food->getFood_id()}'>
                                            <input type='hidden' name='food_name' value='{$food->getFood_name()}'>
                                            <input type='hidden' name='quantity' value='1'>
                                            <input type='hidden' name='image_url' value='{$food->getImage_url()}'>
                                            <input type='hidden' name='price' value='{$food->getPrice()}'>
                                            <button type='submit' class='btn-add shadow-sm'>
                                                <span class='glyphicon glyphicon-plus'></span>
                                            </button>
                                        </form>";
                                }
                            ?>

                            <div class="col-xs-12 col-sm-6 col-lg-4 food-col">
                                <div class="food-card <?= $card_class ?>" style="cursor: pointer;">
                                    
                                    <div class="img-wrapper" onclick="window.location.href='index.php?page=Food&action=Detail&food_id=<?= $food->getFood_id() ?>'" 
                                         style="position: relative; background: #edededff; height: 250px; width: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;">
                                        <?= $badge_html ?>  
                                        <img src="<?= $img_src ?>" style="width: 100%; height: 100%; object-fit: contain;">
                                    </div>

                                    <div class="card-body">
                                        <h4 class="card-title fw-bold text-dark"><?= $food->getFood_name() ?></h4>
                                        <p class="card-desc">
                                            <?= $food->getDescription() ?>
                                        </p>
                                        <div class="clearfix">
                                            <span class="pull-left price-tag"><?= $price_format ?></span>
                                            <div class="pull-right">
                                                <?= $action_btn ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div> </div> <?php endforeach; ?>

        <?php else: ?>
            <div class="col-xs-12 category-container">
                <div class="text-center">
                    <div class="empty-icon-wrapper">
                        <span class="glyphicon glyphicon-search"></span>
                    </div>
                    
                    <h3 class="empty-title">Không tìm thấy kết quả</h3>
                    <p class="empty-desc">
                        Rất tiếc, hiện tại chưa có món ăn nào trong danh mục này hoặc từ khóa tìm kiếm không khớp.
                    </p>
                </div>
            </div>
        <?php endif; ?>
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