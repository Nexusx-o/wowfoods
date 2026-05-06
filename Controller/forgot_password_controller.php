<?php
// forgot-password.php
require_once '../config/init.php';

$error = '';
$message = '';
$reset_link = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);

    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error = 'Please enter a valid email address.';
    } else {
        try {
            $account_type = null;
            $account_id = null;

            // 1. Check 'user' table
            $stmt = $pdo->prepare("SELECT id FROM user WHERE email = ? LIMIT 1");
            $stmt->execute([$email]);
            $user = $stmt->fetch();

            if ($user) {
                $account_type = 'user';
                $account_id = $user['id'];
            } else {
                // 2. Check 'customers' table if not found in user
                $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ? LIMIT 1");
                $stmt->execute([$email]);
                $customer = $stmt->fetch();

                if ($customer) {
                    $account_type = 'customer';
                    $account_id = $customer['id'];
                }
            }

            if ($account_type && $account_id) {
                // 3. Generate Token
                $token = bin2hex(random_bytes(24));
                $expires_at = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // 4. Save to password_resets
                $stmt = $pdo->prepare("INSERT INTO password_resets (account_type, account_id, token, expires_at) VALUES (?, ?, ?, ?)");
                $stmt->execute([$account_type, $account_id, $token, $expires_at]);

                // 5. Build Link (Using SITEURL from your init file)
                $reset_link = SITEURL . "reset-password.php?token=$token";
                $message = 'A password reset link has been generated. Use the link below within one hour.';
            } else {
                // Security best practice: Don't reveal if an email exists or not
                $message = 'If this email is registered, a password reset link will be generated.';
            }

        } catch (PDOException $e) {
            $error = "System error. Please try again later.";
        }
    }
}

// Load the Presentation layer
include '../view/forgot_password_view.php';