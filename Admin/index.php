<?php
// Bảo vệ trang admin - chỉ admin mới truy cập được
ob_start();
session_start();
include_once __DIR__ . '/../Helper/SessionManager.php';

// Kiểm tra đăng nhập và vai trò
if (!SessionManager::exists('user_id')) {
    echo "<script>alert('Vui lòng đăng nhập để truy cập khu vực quản trị'); window.location.href='../index.php?page=SignIn';</script>";
    exit;
}

$userRole = SessionManager::get('user_role');
if ($userRole !== 'admin') {
    echo "<script>alert('Bạn không có quyền truy cập khu vực này'); window.location.href='../index.php?page=Home';</script>";
    exit;
}

// tự động load require trong thư mục controller
spl_autoload_register(function ($className) {
    $path = "./Controller/" . $className . ".php";
    if (file_exists($path)) {
        require_once $path;
    }
});

$page = isset($_GET["page"]) ? $_GET["page"] : "HomeAdmin";
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
