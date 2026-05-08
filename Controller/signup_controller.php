<?php
require_once '../config/init.php';
require_once '../model/signup_model.php';

$error_message = "";
$success_message = "";
$database = new Database();
$db = $database->getConnection();

$first_name = $last_name = $email = $phone = $address = $city = "";

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['submit'])) {
    // Collect and Sanitization
    $first_name = cleanInput($_POST['first_name']);
    $last_name  = cleanInput($_POST['last_name']);
    $email      = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone      = cleanInput($_POST['phone']);
    $address    = cleanInput($_POST['address']);
    $city       = cleanInput($_POST['city']);
    $password   = $_POST['password'];
    $confirm    = $_POST['confirm_password'];

    // Validation Logic
    if (empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($password)) {
        $error_message = "All required fields must be filled.";
    }
    // Validate Email Format
    elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Please enter a valid email address.";
    }
    // Validate Phone Number (digits only, length between 10 and 15)
    elseif (!preg_match('/^[0-9]{10,15}$/', $phone)) {
        $error_message = "Please enter a valid phone number.";
    }
    // Validate Password Strength
    elseif (strlen($password) < 8) {
        $error_message = "Password must be at least 8 characters long.";
    }
    elseif ($password !== $confirm) {
        $error_message = "Passwords do not match.";
    }
else {
        // 3. Model 
        $customerModel = new CustomerModel($db);

        try {
            if ($customerModel->emailExists($email)) {
                $error_message = "This email is already registered.";
            } else {
                $hashed_password = password_hash($password, PASSWORD_DEFAULT);
                
                $customerData = [
                    ':fname' => $first_name,
                    ':lname' => $last_name,
                    ':email' => $email,
                    ':pass'  => $hashed_password,
                    ':phone' => $phone,
                    ':addr'  => $address,
                    ':city'  => $city
                ];

                if ($customerModel->create($customerData)) {
                    $success_message = "Account created! Redirecting...";
                }
            }
        } catch (PDOException $e) {
            $error_message = "Database error. Please try again later.";
        }
    }
}

include '../view/signup_view.php';