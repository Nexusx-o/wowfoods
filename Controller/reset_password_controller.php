<?php
// reset-password.php
require_once 'config/init.php';
// require_once 'models/AuthModel.php';

$error = '';
$message = '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

if (empty($token)) {
    redirect('login.php');
    exit();
}

$authModel = new AuthModel($pdo);

try {
    // 1. Check if token exists and is valid
    $reset = $authModel->verifyResetToken($token);

    if (!$reset || $reset['used'] || strtotime($reset['expires_at']) < time()) {
        $error = 'This password reset link is invalid or has expired.';
    } else {
        // 2. Handle the Form Submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm  = $_POST['confirm_password'] ?? '';

            if (empty($password) || strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif ($password !== $confirm) {
                $error = 'Passwords do not match.';
            } else {
                // 3. Execution
                $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                
                $result = $authModel->performPasswordReset(
                    $token, 
                    $reset['account_type'], 
                    $reset['account_id'], 
                    $hashedPassword
                );

                if ($result) {
                    $message = 'Your password has been reset successfully. You can now log in.';
                } else {
                    $error = 'Failed to update password. Please contact support.';
                }
            }
        }
    }
} catch (PDOException $e) {
    $error = "A system error occurred. Please try again later.";
}

include '../view/reset_password_view.php';
