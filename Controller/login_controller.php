<?php
// controller/login_controller.php
require_once '../config/init.php';
require_once '../model/auth_model.php';

// 1. Initialize the database connection using your new Class
$database = new Database();
$pdo = $database->getConnection();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = cleanInput($_POST['username']);
    $password   = $_POST['password'];

    $authModel = new AuthModel($pdo);
    $user = $authModel->getUserByAnyIdentifier($identifier);

    if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
    
    // 1. Set common session variables
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];

    // 2. Determine if the user is an Admin or a Customer
    // We check if the 'role' key exists and if it is set to 'admin'
    if (isset($user['role']) && $user['role'] === 'Admin') {
        
        // --- ADMIN LOGIC ---
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $user['id']; // Store admin's primary key
        
        redirect('controller/admin_dashboard_controller.php');
        
    } else {
        
        // --- CUSTOMER LOGIC ---
        $_SESSION['role'] = 'customer'; 
        $_SESSION['customer_id'] = $user['id']; // Store customer's primary key
        
        // Redirect to customer dashboard/menu
        redirect('controller/customer_dashboard_controller.php');
    }
    
    exit();
} else {
    $error = "Invalid email/username or password.";
}
}

// 2. THIS MUST LOAD THE VIEW (HTML Form), NOT THE TEST CONTROLLER
include '../view/login_view.php';