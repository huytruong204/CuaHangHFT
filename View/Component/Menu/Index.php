<div class="collapse navbar-collapse " style="padding-top: 10px" id="bs-example-navbar-collapse-1">

    <ul class="nav navbar-nav">
        <li class='active'>
            <a href="index.php?page=Home">
                <i class="glyphicon glyphicon-home"></i> Trang chủ
            </a>
        </li>

        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                <i class="glyphicon glyphicon-cutlery"></i> Thực đơn <span class="caret"></span>
            </a>
            <ul class="dropdown-menu" role="menu">
                <li><a href="Index.php?page=Food"><strong>Tất cả món ăn</strong></a></li>
                <li class="divider"></li>
                <?php
                foreach ($list_cat as $cat) {
                    echo "<li><a href='Index.php?page=Food&cat_filter={$cat->getCategory_id()}'>{$cat->getCategory_name()}</a></li>";
                }
                ?>
            </ul>
        </li>

        <li><a href="#"><i class="glyphicon glyphicon-gift"></i> Khuyến mãi</a></li>
        <li><a href="index.php?page=Contact"><i class="glyphicon glyphicon-earphone"></i> Liên hệ</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">

        <?php if (SessionManager::get('user_role') === 'admin' || SessionManager::get('user_role') === 'shipper'): ?>
            <li>
                <a href="./Admin/index.php?page=HomeAdmin" class="nav-highlight">
                    <i class="glyphicon glyphicon-cog"></i> Admin
                </a>
            </li>
        <?php endif; ?>

        <li>
            <a href="index.php?page=Cart" class="nav-highlight">
                <i class="glyphicon glyphicon-shopping-cart"></i> Giỏ hàng <?= "(" . $count . ")" ?>
            </a>
        </li>

        <?php if ($exists_id):
            $displayName = htmlspecialchars($name);
        ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="font-weight: bold;">
                    <i class="glyphicon glyphicon-user"></i> Xin chào, <?= $displayName ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="index.php?page=User">
                            Hồ sơ cá nhân
                        </a>
                    </li>
                    <li>
                        <a href="index.php?page=Order">
                            Lịch sử đơn hàng
                        </a>
                    </li>
                    <li class="divider"></li>
                    <li>
                        <a href="index.php?page=User&action=Logout" style="color: #d9534f;">
                            <i class="glyphicon glyphicon-log-out"></i> Đăng xuất
                        </a>
                    </li>
                </ul>
            </li>

        <?php else: ?>

            <li>
                <a href="index.php?page=SignIn">
                    <i class="glyphicon glyphicon-log-in"></i> Đăng nhập
                </a>
            </li>
            <li>
                <a href="index.php?page=SignUp">
                    <i class="glyphicon glyphicon-registration-mark"></i> Đăng ký
                </a>
            </li>

        <?php endif; ?>
    </ul>
</div>
</div>
</nav>

</section>
</div>