<div class="collapse navbar-collapse " style="padding-top: 10px" id="bs-example-navbar-collapse-1">

    <ul class="nav navbar-nav">
        <li class='active'>
            <a href="index.php?page=Home">
                <i class="glyphicon glyphicon-home"></i> Trang chủ
            </a>
        </li>

        <li>
            <a href="index.php?page=Food">
                <i class="glyphicon glyphicon-cutlery"></i> Thực đơn 
            </a>
        </li>

        <li><a href="#"><i class="glyphicon glyphicon-gift"></i> Khuyến mãi</a></li>
        <li><a href="index.php?page=Contact"><i class="glyphicon glyphicon-earphone"></i> Liên hệ</a></li>
    </ul>

    <ul class="nav navbar-nav navbar-right">

        <?php if ($role_user === 'admin' || $role_user === 'shipper'): ?>
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
        ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="font-weight: bold; display: flex; align-items: center; margin-top: -5px">
                    <?php
                    $avatarUrl = $user->getAvatar_url();
                    if (!empty($avatarUrl)):
                    ?>
                        <img src="assets/img/avatars/<?= $avatarUrl ?>" alt="Avatar"
                            style="width: 30px; height: 30px; border-radius: 50%; object-fit: cover; margin-right: 8px; border: 1px solid #ddd;">
                    <?php else: ?>
                        <i class="glyphicon glyphicon-user" style="margin-right: 5px;"></i>
                    <?php endif; ?>

                    Xin chào, <?= htmlspecialchars($user->getFull_name() ?? $user->getUser_name()) ?>
                    <span class="caret"></span>
                </a>

                <ul class="dropdown-menu" role="menu">
                    <li>
                        <a href="index.php?page=User">Hồ sơ cá nhân</a>
                    </li>
                    <li>
                        <a href="index.php?page=Order">Lịch sử đơn hàng</a>
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