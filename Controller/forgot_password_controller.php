<?php
require_once '../includes/session.php';
require_once '../config/database.php';
require_once '../model/user_model.php';

$error = '';
$message = '';
$reset_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $database = new Database();
    $db = $database->getConnection();
    $userModel = new UserModel($db);

    $email = trim($_POST['email'] ?? '');

    if (empty($email)) {
        $error = 'Please enter your email address.';
    } else {
        $account = $userModel->findAccountByEmail($email);

        if ($account) {
            $token = bin2hex(random_bytes(24));
            $userModel->createPasswordReset($account['account_type'], $account['id'], $token);

            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
            $host = $_SERVER['HTTP_HOST'];
            $path = rtrim(dirname($_SERVER['PHP_SELF']), '/\\');
            
            // Generate link (assumes reset-password.php is in the same folder)
            $reset_link = "$protocol://$host$path/reset_password_controller.php?token=$token";
            $message = 'A password reset link has been generated. Use the link below within one hour.';
        } else {
            // Security best practice: don't reveal if email exists or not
            $message = 'If this email is registered, a password reset link will be sent.';
        }
    }
}

include '../view/forgot_password_view.php';