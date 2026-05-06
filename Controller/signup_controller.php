<?php
require_once '../config/init.php';

$error_message = "";
$success_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // 1. Collect and Sanitization
    $full_name = cleanInput($_POST['full_name']);
    $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone     = cleanInput($_POST['phone']);
    $address   = cleanInput($_POST['address']);
    $city      = cleanInput($_POST['city']);
    $password  = $_POST['password'];
    $confirm   = $_POST['confirm_password'];

    // 2. Complex Validation Logic
    if (empty($full_name) || empty($email) || empty($phone) || empty($password)) {
        $error_message = "All required fields must be filled.";
    } 
    // Validate Email Format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    }
    // Validate Name (Must have at least two parts)
    elseif (str_word_count($full_name) < 2) {
        $error_message = "Please enter your full name (First and Last name).";
    }
    // Validate Phone (Basic numeric and length check)
    elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error_message = "Please enter a valid phone number (10-15 digits).";
    }
    // Validate Password Strength
    elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    }
    elseif ($password !== $confirm) {
        $error_message = "Passwords do not match.";
    } 
    else {
        // 3. Database Operations (The Model part)
        try {
            $stmt = $pdo->prepare("SELECT id FROM customers WHERE email = ?");
            $stmt->execute([$email]);
            
            if ($stmt->fetch()) {
                $error_message = "This email is already registered.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                $nameParts = explode(' ', $full_name, 2);
                
                $sql = "INSERT INTO customers (first_name, last_name, email, password, phone, address, city) 
                        VALUES (:fname, :lname, :email, :pass, :phone, :addr, :city)";
                
                $insert = $pdo->prepare($sql);
                $result = $insert->execute([
                    ':fname' => $nameParts[0],
                    ':lname' => $nameParts[1] ?? '',
                    ':email' => $email,
                    ':pass'  => $hashed_password,
                    ':phone' => $phone,
                    ':addr'  => $address,
                    ':city'  => $city
                ]);

                if ($result) {
                    $success_message = "Account created! Redirecting...";
                }
            }
        } catch (PDOException $e) {
            $error_message = "An error occurred. Please try again later.";
        }
    }
}

include '../view/signup_view.php';