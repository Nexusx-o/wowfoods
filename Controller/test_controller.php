<?php
require_once '../config/init.php';
require_once '../Model/test_model.php';

// Perform Security Check
checkLogin();

// Initialize DB and Model
$database = new Database();
$db = $database->getConnection();
$userModel = new TestModel($db);

// Fetch user #1 for testing
$userData = $userModel->getUserData(1);

// Check if got data, otherwise set a default
if (!$userData) {
    $userData = ['name' => 'Unknown', 'email' => 'N/A', 'role' => 'Guest'];
}

// Pass control to the View
include '../view/test_view.php';