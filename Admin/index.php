<?php
ob_start();

spl_autoload_register(function ($className) {
    $directories = [
        "./Controller/",
        "../Model/",
        "../Helper/",
    ];

    foreach ($directories as $dir) {
        $path = $dir . $className . ".php";
        if (file_exists($path)) {
            require_once $path;
            return; 
        }
    }
});
if (!SessionManager::exists('user_id')) {
    echo "<script>alert('Vui lòng đăng nhập để truy cập khu vực quản trị'); window.location.href='../index.php?page=SignIn';</script>";
    exit;
}

$userRole = SessionManager::get('user_role');
if ($userRole !== 'admin' && $userRole !== 'shipper') {
    echo "<script>alert('Bạn không có quyền truy cập khu vực này'); window.location.href='../index.php?page=Home';</script>";
    exit;
}
$page = isset($_GET["page"]) ? $_GET["page"] : "HomeAdmin";

if ($userRole === 'shipper') {
    $allowed_pages = ['OrderAdmin']; 
    
    if (!in_array($page, $allowed_pages)) {
        echo "<script>
                alert('Shipper chỉ có quyền quản lý đơn hàng!'); 
                window.location.href = 'index.php?page=OrderAdmin';
              </script>";
        exit; 
    }
}
$controllerName = $page . "Controller";
include_once "View/Layout/HeaderAdmin.php";
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    $methodName = isset($_GET["action"]) ? $_GET["action"] : "Index";
    if (method_exists($controller, $methodName)) {
        $controller->$methodName();
    } else
        echo "Khong ton tai $methodName";
} else {
    $home = new HomeAdminController();
    $home->Index();
}

include_once "View/Layout/FooterAdmin.php";
ob_end_flush();
