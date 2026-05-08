<?php
/**
 * OrderDetailsController - Returns JSON data for order details
 */

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/get_order_item_controller_model.php';

// 1. Database සම්බන්ධතාවය ලබා ගැනීම
$database = new Database();
$db = $database->getConnection();
$orderModel = new OrderModel($db);

// 2. Request එක පරීක්ෂා කිරීම
if (isset($_GET['order_id'])) {
    $order_id = (int)$_GET['order_id'];

    // 3. Model එක හරහා දත්ත ලබා ගැනීම
    $items = $orderModel->getOrderItems($order_id);

    // 4. JSON Response එක සකස් කිරීම
    header('Content-Type: application/json');

    if ($items !== false) {
        echo json_encode($items);
    } else {
        http_response_code(500); // Server error එකක් ලෙස පෙන්වීම
        echo json_encode(['error' => 'Could not fetch order items.']);
    }
    exit();
} else {
    // order_id එක නැතිනම්
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Order ID is required.']);
    exit();
}
?>