<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
    <ul class="nav navbar-nav nav_m">
        <li><a class="m_tag active_tab" href="index.php?page=Home">Trang chủ</a></li>
        <li class="dropdown">
            <a class="m_tag" href="shop.html" data-toggle="dropdown" role="button" aria-expanded="false">Thực đơn<span class="caret"></span></a>
            <ul class="dropdown-menu drop_3" role="menu">
                <?php
                foreach ($list_cat as $cat) {
                    echo "<li><a href='Index.php?page=Food&cat_filter={$cat->getCategory_id()}'>{$cat->getCategory_name()}</a></li>";
                }
                ?>
            </ul>
        </li>
        <li><a class="m_tag" href="#">Khuyến mãi</a></li>
        <li><a class="m_tag" href="#">Dịch vụ</a></li>
        <li><a class="m_tag" href="index.php?page=Contact">Liên hệ</a></li>
        <li><a class="m_tag1 button mgt" href="./Admin/index.php?page=HomeAdmin"> Admin</a></li>
        <li><a class="m_tag1 button mgt" href="index.php?page=Cart"> Giỏ hàng</a></li>
    </ul>
    <ul class="nav navbar-nav nav_m navbar-right">
        <li><a class="m_tag1 button mgt" href="index.php?page=Login"> Đăng nhập</a></li>
        <li><a class="m_tag1 button mgt" href="index.php?page=Register"> Đăng ký</a></li>
    </ul>
</div>
</div>
</nav>

</section>
</div>