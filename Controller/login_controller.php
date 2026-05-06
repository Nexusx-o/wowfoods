<?php
require_once '../config/init.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email_or_username = cleanInput($_POST['username']);
    $password = $_POST['password'];

    if (empty($email_or_username) || empty($password)) {
        $error = "Please enter both credentials.";
    } else {
        try {
            // 1. Check 'user' table (Admin/User)
            $stmt = $pdo->prepare("SELECT id, username, password, first_name, last_name, role FROM user WHERE username = ?");
            $stmt->execute([$email_or_username]);
            $user = $stmt->fetch();

            if ($user && (password_verify($password, $user['password']) || $password === $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['role'] = $user['role'];
                redirect('admin/dashboard.php');
            }

            // 2. Check 'customers' table
            $stmt_cust = $pdo->prepare("SELECT id, email, password, first_name, last_name FROM customers WHERE email = ?");
            $stmt_cust->execute([$email_or_username]);
            $cust = $stmt_cust->fetch();

            if ($cust && password_verify($password, $cust['password'])) {
                $_SESSION['customer_id'] = $cust['id'];
                $_SESSION['full_name'] = $cust['first_name'] . ' ' . $cust['last_name'];
                $_SESSION['role'] = 'customer';
                redirect('public/menu.php');
            }

            $error = "Invalid email/username or password.";
        } catch (PDOException $e) {
            $error = "A system error occurred. Please try again later.";
        }
    }
}

// Load the View
include '../view/login_view.php';