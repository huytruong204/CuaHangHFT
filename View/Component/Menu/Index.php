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
        
        <li>
            <a href="./Admin/index.php?page=HomeAdmin" class="nav-highlight">
                <i class="glyphicon glyphicon-cog"></i> Admin
            </a>
        </li>

        <li>
            <a href="index.php?page=Cart" class="nav-highlight">
                <i class="glyphicon glyphicon-shopping-cart"></i> Giỏ hàng
            </a>
        </li>

        <?php
<<<<<<< HEAD
        if (SessionManager::exists('user_id')){
            $displayName = htmlspecialchars(SessionManager::get('user_name', 'Người dùng'));
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=User'>Xin chào {$displayName}</a></li>";
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=User&action=Logout'>Đăng xuất</a></li>";
        } else {
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=SignIn'> Đăng nhập</a></li>";
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=SignUp'> Đăng ký</a></li>";
        }
=======
        if (session_status() !== PHP_SESSION_ACTIVE) session_start();
        
        if (isset($_SESSION['user_id'])): 
            $displayName = htmlspecialchars($_SESSION['user_name'] ?? 'Thành viên');
>>>>>>> d7e1c8eeae4e27b7bf0504d5cc41567207b8e1e3
        ?>
            <li class="dropdown">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false" style="padding-left: 10px;">
                    <img src="" class="img-circle" style="width: 25px; margin-right: 5px;"> 
                    Xin chào, <?= $displayName ?> <span class="caret"></span>
                </a>
                <ul class="dropdown-menu">
                    <li><a href="index.php?page=User"><i class="glyphicon glyphicon-user"></i> Hồ sơ cá nhân</a></li>
                    <li><a href="index.php?page=Order"><i class="glyphicon glyphicon-list-alt"></i> Lịch sử đơn hàng</a></li>
                    <li class="divider"></li>
                    <li><a href="index.php?page=User&action=Logout" class="text-danger"><i class="glyphicon glyphicon-log-out"></i> Đăng xuất</a></li>
                </ul>
            </li>

        <?php else: ?>
            <li><a href="index.php?page=SignIn"><i class="glyphicon glyphicon-log-in"></i> Đăng nhập</a></li>
            <li><a href="index.php?page=SignUp"><i class="glyphicon glyphicon-registration-mark"></i> Đăng ký</a></li>
        <?php endif; ?>
    </ul>
</div>
</div>
</nav>

</section>
</div>