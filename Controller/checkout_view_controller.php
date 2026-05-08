<?php

require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../Model/checkout_view_controller_model.php';

// Redirects to the login page if the customer is not logged in.
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php?error=must_login");
    exit();
}

// Database and Model Object Creation
$database = new Database();
$db = $database->getConnection();
$checkoutModel = new CheckoutModel($db);

// Data preparation
$customer_id = $_SESSION['customer_id'];
$cart = $_SESSION['cart'] ?? [];

// Redirects to the menu page if the cart is empty
if (empty($cart)) {
    header("Location: menu_view_controller.php");
    exit();
}

// Calculate the total amount
$total_amount = $checkoutModel->calculateTotal($cart);


include __DIR__ . '/../view/checkout_view.php'; 
?>