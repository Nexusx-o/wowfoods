<?php
require_once '../config/init.php';

// 1. Initialize the database connection using your new Class
$database = new Database();
$pdo = $database->getConnection();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_or_username = cleanInput($_POST['username']);
    $password = $_POST['password'];

    if (empty($email_or_username) || empty($password)) {
        $error = "Please enter both credentials.";
    } else {
        try {
            // Check 'user' table (Admin/Staff)
            $stmt = $pdo->prepare("SELECT id, username, password, first_name, last_name, role FROM user WHERE username = ?");
            $stmt->execute([$email_or_username]);
            $user = $stmt->fetch();

            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['role'] = $user['role'];
                
                // Redirect on success
                redirect('controller/test_controller.php');
            }

            // Check 'customers' table
            $stmt_cust = $pdo->prepare("SELECT id, email, password, first_name, last_name FROM customers WHERE email = ?");
            $stmt_cust->execute([$email_or_username]);
            $cust = $stmt_cust->fetch();

            if ($cust && password_verify($password, $cust['password'])) {
                $_SESSION['customer_id'] = $cust['id'];
                $_SESSION['full_name'] = $cust['first_name'] . ' ' . $cust['last_name'];
                $_SESSION['role'] = 'customer';
                
                // Redirect on success
                redirect('public/menu.php');
            }

            $error = "Invalid email/username or password.";
        } catch (PDOException $e) {
            $error = "A system error occurred. Please try again later.";
        }
    }
}

// 2. THIS MUST LOAD THE VIEW (HTML Form), NOT THE TEST CONTROLLER
include '../view/login_view.php';