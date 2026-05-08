<?php
/**
 * PlaceOrderController - Manages the flow of placing an order
 */

require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/process_order_controller_model.php';
require_once __DIR__ . '/../includes/functions.php'; // generateOrderNumber සඳහා

// 1. ආරක්ෂක පරීක්ෂාව
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['customer_id'])) {
    
    $database = new Database();
    $db = $database->getConnection();
    $orderModel = new OrderModel($db);

    // 2. දත්ත සූදානම් කිරීම
    $orderData = [
        'order_number' => generateOrderNumber($db), // PDO connection එක යැවිය යුතුයි
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

    // 3. ඇණවුම සිදු කිරීම
    $isSuccess = $orderModel->placeOrder($orderData, $cartItems);

    if ($isSuccess) {
        // Cart එක හිස් කිරීම
        unset($_SESSION['cart']);

        // සාර්ථක පණිවිඩය (SweetAlert2)
       include __DIR__ . '/../view/order_success_view.php'; 
    } else {
        echo "<script>alert('Something went wrong. Please try again.'); window.history.back();</script>";
    }

} else {
    header("Location: ../index.php");
    exit();
}
?>