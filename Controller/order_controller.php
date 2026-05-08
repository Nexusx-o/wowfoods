<?php
require_once '../config/init.php';
require_once '../Model/Order_Model.php';
checkAdmin();

$database = new Database();
$db = $database->getConnection();
$orderModel = new OrderModel($db);

$action = $_GET['action'] ?? 'manage';
$id = $_GET['id'] ?? null;

switch ($action) {
    case 'update':
        if (isset($_POST['submit'])) {
            $status = $_POST['status'];
            $pay_status = $_POST['payment_status'];
            
            if ($orderModel->update($id, $status, $pay_status, $_SESSION['user_id'])) {
                redirect('Controller/Order_Controller.php?action=manage');
            }
        }
        $order = $orderModel->getById($id);
        include '../view/update_order_view.php';
        break;

    default:
        $orders = $orderModel->getAll();
        include '../view/manage_order_view.php';
        break;
}