<div class="container " style="padding-top: 30px; margin-top: 70px;">
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
            <a href="#" class="pull-right text-primary fw-bold" style="text-decoration: none; margin-top: 2px;">
                Xem tất cả <span class="glyphicon glyphicon-arrow-right"></span>
            </a>
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

    <div class="row state-card">
        <?php
        if (!empty($list_foods)) {
            foreach ($list_foods as $food) {
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
                    </button>
                ";
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
                        </form>
                    ";
                }
                echo "
                <div class='col-xs-12 col-sm-6 col-lg-4 food-col'>
                    <div class='food-card $card_class' style='cursor: pointer;'>
                        
                        <div class='img-wrapper' onclick='window.location.href=\"index.php?page=Food&action=Detail&food_id={$food->getFood_id()}&p=$current_page\"' style='position: relative; background: #edededff; height: 250px; width: 100%; display: flex; align-items: center; justify-content: center; overflow: hidden;'>
                            $badge_html  <img src='$img_src' style='width: 100%; height: 100%; object-fit: contain;'>
                        </div>

                        <div class='card-body'>
                            <span class='text-muted' style='font-size: 12px; text-transform: uppercase; font-weight: 600; color: #999;'>
                                {$food->getCategory_id()}
                            </span>
                            <h4 class='card-title fw-bold text-dark'>{$food->getFood_name()}</h4>
                            <p class='card-desc'>
                                {$food->getDescription()}
                            </p>
                            <div class='clearfix'>
                                <span class='pull-left price-tag'>$price_format</span>
                                <div class='pull-right'>
                                    $action_btn
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            ";
            }
        } else {
            echo "
                <div class='col-xs-12'>
                    <div class=' text-center'>
                        <div class='empty-icon-wrapper'>
                            <span class='glyphicon glyphicon-search'></span>
                        </div>
                        
                        <h3 class='empty-title'>Không tìm thấy kết quả</h3>
                        <p class='empty-desc'>
                            Rất tiếc, hiện tại chưa có món ăn nào trong danh mục này hoặc từ khóa tìm kiếm không khớp.
                        </p>
                    </div>
                </div>
            ";
        }
        ?>

    </div>
    <!-- PHẦN 3: PHÂN TRANG -->
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