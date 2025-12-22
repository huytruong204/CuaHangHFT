<?php 
    include_once "../Model/FoodModel.php";
    include_once "../Model/OrderModel.php";
    class HomeAdminController{
        public function Index() {
            $orderModel = new OrderModel();
            $foodModel = new FoodModel();
            $statistics = $orderModel->getDashboardStats();
            $recentOrders = $orderModel->getAll(0, 5, [], 'desc');
            $countFood = $foodModel->CountRows([]);
            require_once "View/HomeAdmin/Index.php";
        }
    }
?>