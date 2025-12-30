<?php
ob_start();
spl_autoload_register(function ($className) {
    $directories = [
        "./Controller/",
        "./Model/",
        "./Helper/",
        "./ViewComponent/"
    ];

    foreach ($directories as $dir) {
        $path = $dir . $className . ".php";
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

include_once "./View/Layout/Header.php";
$page = isset($_GET["page"]) ? $_GET["page"] : "";
$controllerName = $page . "Controller";
if (class_exists($controllerName)) {
    $controller = new $controllerName();
    $methodName = isset($_GET["action"]) ? $_GET["action"] : "Index";
    if (method_exists($controller, $methodName))
        $controller->$methodName();
    else {
        $home = new FoodController();
        $home->Index();
    }
} else {
    $home = new FoodController();
    $home->Index();
}
include_once "./View/Layout/Footer.php";
ob_end_flush();
