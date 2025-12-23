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
 <div class="main_2 clearfix">
 	<section id="center" class="center_home">
 		<div class="carousel fade-carousel slide" data-ride="carousel" data-interval="4000" id="bs-carousel">
 			<!-- Overlay -->
 			<div class="overlay"></div>

 			<!-- Indicators -->
 			<ol class="carousel-indicators">
 				<li data-target="#bs-carousel" data-slide-to="0" class="active"></li>
 				<li data-target="#bs-carousel" data-slide-to="1" class=""></li>
 				<li data-target="#bs-carousel" data-slide-to="2" class=""></li>
 			</ol>

 			<!-- Wrapper for slides -->
 			<div class="carousel-inner">
 				<div class="item slides active">
 					<div class="slide-1"></div>
 					<div class="hero clearfix">
 						<div class="col-sm-12">
 							<h1 class="col">Cảm nhận hương vị</h1>
 							<h4 class="big col_3">Nơi trải nghiệm ẩm thực tuyệt vời</h4>
 						</div>
 					</div>
 				</div>
 				<div class="item slides">
 					<div class="slide-2"></div>
 					<div class="hero clearfix">
 						<div class="col-sm-12">
 							<h1 class="col">Đặt món</h1>
 							<h4 class="big col_3">Nơi trải nghiệm ẩm thực tuyệt vời</h4>
 						</div>
 					</div>
 				</div>
 				<div class="item slides">
 					<div class="slide-3"></div>
 					<div class="hero clearfix">
 						<div class="col-sm-12">
 							<h1 class="col">Đặt bàn trực tuyến</h1>
 							<h4 class="big col_3">Nơi trải nghiệm ẩm thực tuyệt vời</h4>
 						</div>
 					</div>
 				</div>
 			</div>
 		</div>
 	</section>
 </div>
 <div class="main_3 clearfix">
 	<section id="about_h">
 		<div class="container">
 			<div class="row">
 				<div class="about_h_1 clearfix">
 				</div>
 			</div>
 		</div>
 	</section>
 </div>
 </div>

 <section id="dish">
 	<div class="offer_m clearfix">
 		<div class="container">
 			<div class="row">
 				<div class="discount_t text-center clearfix">
 					<div class="col-sm-12">
 						<h2 class="mgt col">Món Ăn Nổi Bật</h2>
 						<hr class="line">
 					</div>
 				</div>
 				<div class="dish_1 clearfix">
 					<div class="col-sm-12">
 						<?php
							// Ensure $list_cat is available for other logic; prefer controller-provided variable
							if (!isset($list_cat) || empty($list_cat)) {
								include_once __DIR__ . '/../../Model/CategoryModel.php';
								$cm = new CategoryModel();
								$list_cat = $cm->getAllCategories();
							}
							?>
 						<?php
							// Determine Combo category id so we can mark it active on initial load when no cat_filter is present
							$comboCatId = null;
							if (!empty($list_cat)) {
								foreach ($list_cat as $c_check) {
									if (strtolower(trim($c_check->getCategory_name())) === 'combo') {
										$comboCatId = $c_check->getCategory_id();
										break;
									}
								}
							}
							?>
 						<ul class="nav_1">
 							<?php
								foreach ($list_cat as $cat) {
									$catIdRaw = $cat->getCategory_id();
									// Active logic: prefer explicit GET filter; otherwise default to Combo category if present
									if (isset($_GET['cat_filter'])) {
										$active = ($_GET['cat_filter'] == $catIdRaw) ? 'active' : '';
									} else {
										$active = ($comboCatId !== null && $comboCatId == $catIdRaw) ? 'active' : '';
									}
									$catId = htmlspecialchars($catIdRaw);
									$catName = htmlspecialchars($cat->getCategory_name());
									echo "<li class='" . $active . "'><a href='index.php?page=Home&cat_filter=$catId' >$catName</a></li>";
								}
								?>
 						</ul>
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
                            <input type='hidden' name='page' value='Home'>
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
 			</div>
 		</div>
 </section>
 <br>
 <section id="gallery" class="clearfix">
 	<div class="discount_t text-center clearfix">
 		<div class="col-sm-12">
 			<h2 class="mgt">Combo Siêu Hot</h2>
 			<hr class="line">
 		</div>
 	</div>
 	<div class="gallery_1 clearfix">
 		<?php
			if (!empty($comboFoods)) {
				foreach ($comboFoods as $food) {
					$imgPath = 'assets/img/img_foods/' . ($food->getImage_url() ?? '');
					if (empty($food->getImage_url()) || !file_exists(__DIR__ . '/../../' . $imgPath)) {
						$imgPath = 'assets/img/13.jpg';
					}
					$foodId = htmlspecialchars($food->getFood_id());
					$foodName = htmlspecialchars($food->getFood_name());
					echo "<article class='col-sm-3 space_all'>";
					echo "<div class='panel panel-default'><div class='panel-body'>";
					// plain link to food detail (remove lightbox intercept)
					echo "<a href='index.php?page=Food&action=Detail&food_id=$foodId' title='$foodName'>";
					echo "<img src='$imgPath' alt='$foodName'>";
					echo "<span class='overlay'><i class='glyphicon glyphicon-fullscreen'></i></span>";
					echo "</a></div></div></article>";
				}
			} else {
				echo "<div class='col-sm-12 text-center'>Không tìm thấy combo cho danh mục Combo.</div>";
			}
			?>
 	</div>
 </section>

 <br>
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