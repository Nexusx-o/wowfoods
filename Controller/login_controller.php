<?php
// controller/login_controller.php
require_once '../config/init.php';
require_once '../model/auth_model.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifier = cleanInput($_POST['username']);
    $password   = $_POST['password'];

    if (empty($identifier) || empty($password)) {
        $error = "Please enter both credentials.";
    } else {
        $authModel = new AuthModel($pdo);
        
        try {
            $user = $authModel->getUserByAnyIdentifier($identifier);

            if ($user && password_verify($password, $user['password'])) {
                // Set common session variables
                $_SESSION['full_name'] = $user['first_name'] . ' ' . $user['last_name'];
                $_SESSION['role']      = $user['role'];

                // Redirect based on origin
                if ($user['account_origin'] === 'user') {
                    $_SESSION['user_id'] = $user['id'];
                    redirect('admin/dashboard.php');
                } else {
                    $_SESSION['customer_id'] = $user['id'];
                    redirect('public/menu.php');
                }
                exit();
            } else {
                $error = "Invalid email/username or password.";
            }
        } catch (PDOException $e) {
            $error = "A system error occurred. Please try again later.";
        }
    }
}

// Load the View
include '../view/login_view.php';