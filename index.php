<?php
include_once "./View/Layout/Header.php";
// tự động load require trong thư mục controller
spl_autoload_register(function($className){
    $path = "./Controller/" .$className.".php";
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
    $home = new HomeController();
    $home->HomeView();
}

include_once "./View/Layout/Footer.php";
?>
