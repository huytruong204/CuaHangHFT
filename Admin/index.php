<?php
include_once "View/Layout/HeaderAdmin.php";
// tự động load require trong thư mục controller
spl_autoload_register(function($className){
    $path = "Controller/" .$className.".php";
    if(file_exists($path)){
        require_once $path;
    } 
});

$page = isset($_GET["page"]) ? $_GET["page"] : "Home";
$controllerName = $page . "Controller";
if(class_exists($controllerName)){
    $controller = new $controllerName();
    $methodName = $page . "View";
    if(method_exists($controller, $methodName))
        $controller->$methodName();
    else
        echo "Khong ton tai $methodName";
}else
{
    $home = new HomeAdminController();
    $home->HomeAdminView();
}

include_once "View/Layout/FooterAdmin.php";
?>
