<?php
/**
 * OrdersController - Controls the flow for customer orders
 */

// 1. අවශ්‍ය ගොනු සම්බන්ධ කිරීම (Absolute paths භාවිතා කර ඇත)
require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../Model/customer_dashboad_controller_model.php';

// 2. ආරක්ෂක පියවර: Customer ලොග් වී නොමැති නම් ලොගින් පිටුවට යොමු කරයි
if (!isset($_SESSION['customer_id'])) {
    header("Location: ../login.php");
    exit();
}

// 3. Database සහ Model Object නිර්මාණය
$database = new Database();
$db = $database->getConnection();
$orderModel = new OrderModel($db);

// 4. දත්ත ලබා ගැනීම
$customer_id = $_SESSION['customer_id'];
$orders = $orderModel->getOrdersByCustomerId($customer_id);

// 5. පෙනුම (View) ලෝඩ් කිරීම
// මෙහි ඇති $orders විචල්‍යය customer_dashboad.php එක තුළ භාවිතා කළ හැක.
include __DIR__ . '/../view/customer_dashboard.php'; 
?>