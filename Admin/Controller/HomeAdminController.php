<?php

class HomeAdminController
{
    public function Index()
    {
        $orderModel = new OrderModel();
        $foodModel = new FoodModel();
        $statistics = $orderModel->getDashboardStats();
        $recentOrders = $orderModel->getAll(0, 5, [], 'desc');
        $countFood = $foodModel->CountRows([]);
        $msg_success = SessionManager::flash('success');
        $msg_error = SessionManager::flash('error');
        require_once "View/HomeAdmin/Index.php";
    }
}
