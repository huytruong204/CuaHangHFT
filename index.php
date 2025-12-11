<?php
include_once "./View/Layout/Header.php";
require_once "./Controller/HomeController.php";
require_once "./Controller/ContactController.php";

if(isset($_GET["page"])){
    $content = $_GET["page"];
    switch ($content) {
        case 'contact':
            $contact = new ContactController();
            $contact->ContactView();
            break;
        
        default:
            $home = new HomeController();
            $home->HomeView();
            break;
    }
}
else{
    $home = new HomeController();
    $home->HomeView();
}
include_once "./View/Layout/Footer.php";
?>
