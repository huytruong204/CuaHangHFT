<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Food Admin - Quản lý đặt món</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">

    <link href="assets/img/favicon.ico" rel="icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">

    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">
    <link href="assets/lib/tempusdominus/css/tempusdominus-bootstrap-4.min.css" rel="stylesheet" />

    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <?php $adminStyle = 'assets/css/style.css'; ?>
    <link href="<?= $adminStyle ?>?v=<?= file_exists(__DIR__ . '/../../assets/css/style.css') ? filemtime(__DIR__ . '/../../assets/css/style.css') : time() ?>" rel="stylesheet">
</head>

<body>
    <?php
    
    $admin_name = 'Admin';
    $admin_avatar = '';
    
    // Lấy thông tin user từ database theo user_id
    if (SessionManager::exists('user_id')) {
        $user_id = SessionManager::get('user_id');
        $user_role = SessionManager::get('user_role');
        $userModel = new UserModel();
        $user = $userModel->getDetail($user_id);
        
        if ($user) {
            $admin_name = $user->getFull_name() ?: $user->getUser_name();
            $admin_avatar = $user->getAvatar_url();
        }
    }
    
    $avatar_path = !empty($admin_avatar) ? '../assets/img/avatars/' . $admin_avatar : 'assets/img/user.jpg';
    ?>
    <div class="container-fluid position-relative d-flex p-0">
        <div id="spinner" class="show bg-white position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <div class="sidebar pe-4 pb-3">
            <nav class="navbar navbar-light">
                <a href="index.html" class="navbar-brand mx-4 mb-3">
                    <h3 class="text-primary"><i class="fa fa-utensils me-2"></i>FoodAdmin</h3>
                </a>
                <div class="d-flex align-items-center ms-4 mb-4">
                    <div class="position-relative">
                        <img class="rounded-circle" src="<?= htmlspecialchars($avatar_path) ?>" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                        <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
                    </div>
                    <div class="ms-3">
                        <h6 class="mb-0 text-dark"><?= htmlspecialchars($admin_name) ?></h6>
                        <span><?= $user_role ?></span>
                    </div>
                </div>
                <div class="navbar-nav w-100">
                    <?php if($user_role === 'admin'): ?>
                        <a href="index.php?page=HomeAdmin" class="nav-item nav-link <?= ($page == 'HomeAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-tachometer-alt me-2"></i>Trang chủ
                        </a>
                        <a href="index.php?page=CategoryAdmin" class="nav-item nav-link <?= ($page == 'CategoryAdmin') ? 'active' : '' ?>">
                            <i class="bi bi-list me-2"></i>Quản lý danh mục
                        </a>
                        <a href="index.php?page=FoodAdmin" class="nav-item nav-link <?= ($page == 'FoodAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-hamburger me-2"></i>Quản lý món ăn
                        </a>
                        <a href="index.php?page=UserAdmin" class="nav-item nav-link <?= ($page == 'UserAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-users me-2"></i>Quản lý người dùng
                        </a>
                        <a href="index.php?page=OrderAdmin" class="nav-item nav-link <?= ($page == 'OrderAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-file-invoice-dollar"></i>Quản lý đơn hàng
                        </a>
                        <a href="index.php?page=ReviewAdmin" class="nav-item nav-link <?= ($page == 'ReviewAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-star me-2"></i>Quản lý đánh giá
                        </a>
                        <a href="index.php?page=ReportAdmin" class="nav-item nav-link <?= ($page == 'ReportAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-chart-bar me-2"></i>Báo cáo
                        </a>
                    <?php else: ?>
                        <a href="index.php?page=OrderAdmin" class="nav-item nav-link <?= ($page == 'OrderAdmin') ? 'active' : '' ?>">
                            <i class="fa fa-file-invoice-dollar"></i>Quản lý đơn hàng
                        </a>
                    <?php endif; ?>

                    <a href="../index.php?page=Home" class="nav-item nav-link">
                        <i class="fa fa-store me-2"></i>Về cửa hàng
                    </a>
                </div>
            </nav>
        </div>
        <div class="content">
            <nav class="navbar navbar-expand bg-secondary navbar-light sticky-top px-4 py-0">
                <a href="index.html" class="navbar-brand d-flex d-lg-none me-4">
                    <h2 class="text-primary mb-0"><i class="fa fa-utensils"></i></h2>
                </a>
                <a href="#" class="sidebar-toggler flex-shrink-0 text-primary">
                    <i class="fa fa-bars"></i>
                </a>
                <form class="d-none d-md-flex ms-4">
                    <input class="form-control border-0" type="search" placeholder="Tìm kiếm...">
                </form>
                <div class="navbar-nav align-items-center ms-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-bs-toggle="dropdown">
                            <img class="rounded-circle me-lg-2" src="<?= htmlspecialchars($avatar_path) ?>" alt="" style="width: 40px; height: 40px; object-fit: cover;">
                            <span class="d-none d-lg-inline-flex"><?= htmlspecialchars($admin_name) ?></span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-end bg-secondary border-0 rounded-0 rounded-bottom m-0">
                            <a href="../index.php?page=User" class="dropdown-item">Hồ sơ cá nhân</a>
                            <a href="../index.php?page=User&action=Logout" class="dropdown-item">Đăng xuất</a>
                        </div>
                    </div>
                </div>
            </nav>