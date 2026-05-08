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
    
    // Set common session variables
    $_SESSION['first_name'] = $user['first_name'];
    $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];

    // Determine if the user is an Admin or a Customer
    if (isset($user['role']) && $user['role'] === 'Admin') {
        
        // --- ADMIN LOGIC ---
        $_SESSION['role'] = 'admin';
        $_SESSION['admin_id'] = $user['id']; // Store admin's primary key
        
        redirect('controller/admin_dashboard_controller.php');
        
    } else {
        $_SESSION['role'] = 'customer'; 
        $_SESSION['customer_id'] = $user['id'];
        
        // Redirect to customer dashboard/menu
        redirect('controller/customer_dashboard_controller.php');
    }
    
    exit();
} else {
    $error = "Invalid email/username or password.";
}
}

include '../view/login_view.php';