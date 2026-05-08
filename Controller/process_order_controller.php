<?php

require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../Model/process_order_controller_model.php';
require_once __DIR__ . '/../includes/functions.php'; // generateOrderNumber සඳහා


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['customer_id'])) {
    
    $database = new Database();
    $db = $database->getConnection();
    $orderModel = new OrderModel($db);

    // Data preparation
    $orderData = [
        'order_number' => generateOrderNumber($db), 
        'customer_id'  => $_SESSION['customer_id'],
        'total'        => $_POST['total_amount'],
        'address'      => $_POST['delivery_address'],
        'phone'        => $_POST['phone'],
        'payment'      => $_POST['payment_method']
    ];

    $cartItems = $_SESSION['cart'] ?? [];

    if (empty($cartItems)) {
        header("Location: ../public/menu.php");
        exit();
    }

    //  Placing an order
    $isSuccess = $orderModel->placeOrder($orderData, $cartItems);

    if ($isSuccess) {
        // Emptying the Cart
        unset($_SESSION['cart']);

        // Success message
       include __DIR__ . '/../view/order_success_view.php'; 
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }

} else {
    header("Location: ../index.php");
    exit();
}
?>