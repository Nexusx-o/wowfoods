<?php

require_once __DIR__ . '/../config/init.php';
require_once __DIR__ . '/../Model/get_order_item_controller_model.php';

//  Obtaining database connection
$database = new Database();
$db = $database->getConnection();
$orderModel = new OrderModel($db);

//  Checking the request
if (isset($_GET['order_id'])) {
    $order_id = (int)$_GET['order_id'];

    //  Retrieving data through the model
    $items = $orderModel->getOrderItems($order_id);

    // Preparing the JSON Response
    header('Content-Type: application/json');

    if ($items !== false) {
        echo json_encode($items);
    } else {
        http_response_code(500); 
        echo json_encode(['error' => 'Could not fetch order items.']);
    }
    exit();
} else {
    header('Content-Type: application/json');
    echo json_encode(['error' => 'Order ID is required.']);
    exit();
}
?>