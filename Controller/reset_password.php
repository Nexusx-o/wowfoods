<?php
require_once __DIR__ . '/../config/init.php'; 
require_once __DIR__ . '/../config/database.php';
require_once __DIR__ . '/../model/auth_model.php';

$error = '';
$message = '';

// Capture token from URL
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if (empty($token)) {
    header("Location: " . SITEURL . "login.php");
    exit();
}

$database = new Database();
$db = $database->getConnection();
$authModel = new AuthModel($db);

try {
    // Check if token exists and is valid
    $reset = $authModel->verifyResetToken($token);

    if (!$reset || (isset($reset['used']) && $reset['used'] == 1) || strtotime($reset['expires_at']) < time()) {
        $error = 'This password reset link is invalid or has expired.';
    } else {
        // Handle the Form Submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if (empty($password) || strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } else {
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $result = $authModel->performPasswordReset(
                    $token, 
                    $reset['account_type'], 
                    $reset['account_id'], 
                    $hashedPassword
                );

                if ($result) {
                    $message = 'Your password has been reset successfully!';
                } else {
                    $error = 'Failed to update password. Please contact support.';
                }
            }
        }
    }
} catch (PDOException $e) {
    $error = "A system error occurred. Please try again later.";
}

include __DIR__ . '/../view/reset_password_view.php';