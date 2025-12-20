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
        if ($exists_id){
            $displayName = htmlspecialchars($name);
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=User'>Xin chào {$displayName}</a></li>";
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=User&action=Logout'>Đăng xuất</a></li>";
        } else {
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=SignIn'> Đăng nhập</a></li>";
            echo "<li><a class='m_tag1 button mgt' href='index.php?page=SignUp'> Đăng ký</a></li>";
        }
        ?>
    </ul>
</div>
</div>
</nav>

</section>
</div>