<?php
// reset-password.php
require_once 'config/init.php';

$error = '';
$message = '';
$token = $_GET['token'] ?? $_POST['token'] ?? '';

// 1. Basic Token Check
if (empty($token)) {
    redirect('login.php');
}

try {
    // 2. Validate Token in Database
    $stmt = $pdo->prepare("SELECT id, account_type, account_id, expires_at, used FROM password_resets WHERE token = ? LIMIT 1");
    $stmt->execute([$token]);
    $reset = $stmt->fetch();

    if (!$reset || $reset['used'] || strtotime($reset['expires_at']) < time()) {
        $error = 'This password reset link is invalid or has expired.';
    } else {
        // 3. Handle Form Submission
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = $_POST['password'] ?? '';
            $confirm_password = $_POST['confirm_password'] ?? '';

            if (empty($password) || empty($confirm_password)) {
                $error = 'Please enter and confirm your new password.';
            } elseif (strlen($password) < 8) {
                $error = 'Password must be at least 8 characters long.';
            } elseif ($password !== $confirm_password) {
                $error = 'Passwords do not match.';
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);

                // Determine which table to update
                $table = ($reset['account_type'] === 'user') ? 'user' : 'customers';
                
                // Update User/Customer Password
                $update_sql = "UPDATE $table SET password = ? WHERE id = ?";
                $update_stmt = $pdo->prepare($update_sql);
                $update_stmt->execute([$hashed_password, $reset['account_id']]);

                // Mark Token as Used
                $mark_used = $pdo->prepare("UPDATE password_resets SET used = 1 WHERE id = ?");
                $mark_used->execute([$reset['id']]);

                $message = 'Your password has been reset successfully. You can now log in.';
            }
        }
    }
} catch (PDOException $e) {
    $error = "A system error occurred. Please try again later.";
}

// Load the Presentation layer
include 'view/reset_password_view.php';