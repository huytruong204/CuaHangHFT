<?php
// tự động load require trong thư mục controller
spl_autoload_register(function ($className) {
    $path = "./Controller/" . $className . ".php";
    if (file_exists($path)) {
        require_once $path;
    }
});

include_once "View/Layout/HeaderAdmin.php";

$page = isset($_GET["page"]) ? $_GET["page"] : "";
$controllerName = $page . "Controller";
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
