<?php
include_once "./View/Layout/Header.php";
require_once "./Controller/HomeControler.php";
if(isset($_GET["page"])){
    $content = $_GET["page"];
    switch ($content) {
        case 'home':
            $home = new HomeControler();
            $home->HomeView();
            break;
        
        default:
            $home = new HomeControler();
            $home->HomeView();
            break;
    }
}
else{
    $home = new HomeControler();
    $home->HomeView();
}
include_once "./View/Layout/Footer.php";
?>
