<?php

require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../Model/customer_dashboad_controller_model.php';

// If the customer is not logged in, they will be redirected to the login page.
if (!isset($_SESSION['customer_id'])) {
    header("Location: login_controller.php");
    exit();
}

// Database and Model Object Creation
$database = new Database();
$db = $database->getConnection();
$orderModel = new OrderModel($db);

// Data acquisition
$customer_id = $_SESSION['customer_id'];
$orders = $orderModel->getOrdersByCustomerId($customer_id);


include __DIR__ . '/../view/customer_dashboad.php'; 
?>