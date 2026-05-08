<?php
require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/customer_dashboad_controller_model.php';

if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$orderModel = new OrderModel($db);

$customer_id = $_SESSION['customer_id'];
$orders = $orderModel->getOrdersByCustomerId($customer_id);

include __DIR__ . '/../view/customer_dashboard.php'; 