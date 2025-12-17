<div class="container " style="padding-top: 30px; margin-top: 70px;">
    <div class="category-container">
        <form action="" method="GET" class="form-inline">
            <?php if(isset($_GET['cat_filter'])): ?>
                <input type="hidden" name="cat_filter" value="<?= htmlspecialchars($_GET['cat_filter']) ?>">
            <?php endif; ?>

            <div class="row">
                <div class="col-md-6 col-sm-12 mb-2">
                    <div class="input-group" style="width: 100%;">
                        <input type="text" class="form-control" name="keyword" placeholder="Tìm tên món ăn..." value="">
                        <span class="input-group-btn">
                            <button class="btn btn-primary" type="submit"><i class="glyphicon glyphicon-search"></i></button>
                        </span>
                    </div>
                </div>

                <div class="col-md-4 col-sm-12">
                    <select name="price_sort" class="form-control" onchange="this.form.submit()">
                        <option value="desc" <?= ($sort_price == 'desc') ? 'selected' : '' ?>>Giá giảm dần</option>
                        <option value="asc" <?= ($sort_price == 'asc') ? 'selected' : '' ?>>Giá tăng dần</option>
                    </select>
                </div>

                <div class="col-md-2 col-sm-12 text-right">
                    <button type="submit" class="btn btn-primary btn-block">Lọc</button>
                    <?php if(!empty($where_clauses)): ?>
                        <a href="index.php" class="btn btn-default btn-block" style="margin-top: 5px;">Bỏ lọc</a>
                    <?php endif; ?>
                </div>
            </div>
        </form>
    </div>
     <div class="category-container">
         <div class="clearfix mb-4">
             <h3 class="pull-left mt-0 fw-bold text-dark" style="margin: 0;">Danh mục món ăn</h3>
             <a href="#" class="pull-right text-primary fw-bold" style="text-decoration: none; margin-top: 2px;">
                 Xem tất cả <span class="glyphicon glyphicon-arrow-right"></span>
             </a>
         </div>

         <div class="category-scroll" id="category-list">
             <button class="btn category-btn active">Tất cả</button>
             <button class="btn category-btn">Pizza</button>
             <button class="btn category-btn">Burger</button>
             <button class="btn category-btn">Sushi</button>
             <button class="btn category-btn">Cơm</button>
             <button class="btn category-btn">Đồ uống</button>
             <button class="btn category-btn">Tráng miệng</button>
         </div>
     </div>

     <div class="row">

         <!-- Món 1 -->
         <div class="col-xs-12 col-sm-6 col-lg-4 food-col">
             <div class="food-card">
                 <div class="img-wrapper">
                     <img src="https://images.unsplash.com/photo-1565299624946-b28f40a0ae38?auto=format&fit=crop&w=800&q=80" alt="Pizza">
                     <button class="btn-heart shadow-sm">
                         <span class="glyphicon glyphicon-heart"></span>
                     </button>
                     <div class="rating-badge">
                         <span class="glyphicon glyphicon-star text-warning" style="color: #f59e0b;"></span> 4.8
                     </div>
                 </div>

                 <div class="card-body">
                     <h4 class="card-title fw-bold text-dark">Pizza Hải Sản Nhiệt Đới</h4>
                     <p class="card-desc">
                         Tôm, mực, nghêu, dứa, phô mai mozzarella béo ngậy trên nền sốt cà chua.
                     </p>

                     <div class="clearfix">
                         <span class="pull-left price-tag">159.000₫</span>
                         <button class="btn-add shadow-sm" onclick="addToCart(this)">
                             <span class="glyphicon glyphicon-plus"></span>
                         </button>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Món 2 -->
         <div class="col-xs-12 col-sm-6 col-lg-4 food-col">
             <div class="food-card">
                 <div class="img-wrapper">
                     <img src="https://images.unsplash.com/photo-1568901346375-23c9450c58cd?auto=format&fit=crop&w=800&q=80" alt="Burger">
                     <button class="btn-heart shadow-sm">
                         <span class="glyphicon glyphicon-heart-empty"></span>
                     </button>
                     <div class="rating-badge">
                         <span class="glyphicon glyphicon-star text-warning" style="color: #f59e0b;"></span> 4.9
                     </div>
                 </div>
                 <div class="card-body">
                     <h4 class="card-title fw-bold text-dark">Burger Bò Wagyu</h4>
                     <p class="card-desc">
                         Thịt bò Wagyu thượng hạng nướng than hoa, kèm phô mai cheddar và rau tươi.
                     </p>
                     <div class="clearfix">
                         <span class="pull-left price-tag">129.000₫</span>
                         <button class="btn-add shadow-sm" onclick="addToCart(this)">
                             <span class="glyphicon glyphicon-plus"></span>
                         </button>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Món 3 -->
         <div class="col-xs-12 col-sm-6 col-lg-4 food-col">
             <div class="food-card">
                 <div class="img-wrapper">
                     <img src="https://images.unsplash.com/photo-1546069901-ba9599a7e63c?auto=format&fit=crop&w=800&q=80" alt="Cơm gà">
                     <button class="btn-heart shadow-sm">
                         <span class="glyphicon glyphicon-heart-empty"></span>
                     </button>
                     <div class="rating-badge">
                         <span class="glyphicon glyphicon-star text-warning" style="color: #f59e0b;"></span> 4.5
                     </div>
                 </div>
                 <div class="card-body">
                     <h4 class="card-title fw-bold text-dark">Cơm Gà Teriyaki</h4>
                     <p class="card-desc">
                         Gà nướng sốt Teriyaki đậm đà, ăn kèm cơm Nhật dẻo thơm và súp Miso.
                     </p>
                     <div class="clearfix">
                         <span class="pull-left price-tag">89.000₫</span>
                         <button class="btn-add shadow-sm" onclick="addToCart(this)">
                             <span class="glyphicon glyphicon-plus"></span>
                         </button>
                     </div>
                 </div>
             </div>
         </div>

         <!-- Món 4 (Demo cấu trúc chờ dữ liệu) -->
         <div class="col-xs-12 col-sm-6 col-lg-4 food-col">
             <div class="food-card">
                 <div class="img-wrapper" style="background: #eee; display: flex; align-items: center; justify-content: center;">
                     <span class="glyphicon glyphicon-picture" style="font-size: 40px; color: #ccc;"></span>
                 </div>
                 <div class="card-body">
                     <h4 class="card-title fw-bold text-dark">Món ăn mẫu</h4>
                     <p class="card-desc">
                         Mô tả món ăn sẽ hiển thị ở đây. Tối đa 2 dòng để giữ giao diện đều đẹp.
                     </p>
                     <div class="clearfix">
                         <span class="pull-left price-tag">000.000₫</span>
                         <button class="btn-add shadow-sm" onclick="addToCart(this)">
                             <span class="glyphicon glyphicon-plus"></span>
                         </button>
                     </div>
                 </div>
             </div>
         </div>

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
                        echo "
                        <li class='page-item $prev_disabled'>
                            <a class='page-link' href='index.php?$query_str&p=$prev_page' aria-label='Previous'>
                                <span aria-hidden='true' class='glyphicon glyphicon-chevron-left'></span>
                            </a>
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
                        echo "
                        <li class='page-item $next_disabled'>
                            <a class='page-link' href='index.php?$query_str&p=$next_page' aria-label='Next'>
                                <span aria-hidden='true' class='glyphicon glyphicon-chevron-right'></span>
                            </a>
                        </li>";
                        ?>
                    </ul>
                </nav>
            </div>
    <?php endif; ?>
 </div>