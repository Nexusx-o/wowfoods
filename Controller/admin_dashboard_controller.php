<?php
require_once '../config/init.php';
require_once '../Model/admin_dashboard_model.php';

// 1. Security Check: Block non-admins immediately!
checkAdmin(); 

// 2. Initialize DB and Model
$database = new Database();
$db = $database->getConnection();
$dashboardModel = new AdminDashboardModel($db);

// 3. Fetch data via Stored Procedures
$stats = $dashboardModel->getDashboardStats();
if (!$stats) {
    // Default values if the SP returns nothing
    $stats = ['categories' => 0, 'foods' => 0, 'users' => 0, 'revenue' => 0];
}

$recentOrders = $dashboardModel->getRecentOrders();

// 4. Pass control to the View
include '../view/admin_dashboard_view.php';