<?php
require_once '../config/init.php';
require_once '../Model/admin_dashboard_model.php';

// Security Check: Block non-admins immediately!
checkAdmin(); 

// Initialize DB and Model
$database = new Database();
$db = $database->getConnection();
$dashboardModel = new AdminDashboardModel($db);

// Fetch data via Stored Procedures
$stats = $dashboardModel->getDashboardStats();
if (!$stats) {
    $stats = ['categories' => 0, 'foods' => 0, 'users' => 0, 'revenue' => 0];
}

$recentOrders = $dashboardModel->getRecentOrders();

// Pass control to the View
include '../view/admin_dashboard_view.php';