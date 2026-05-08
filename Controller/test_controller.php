<?php
require_once '../config/init.php';
require_once '../Model/test_model.php';

// 1. Perform Security Check IMMEDIATELY (Protects everything below)
checkLogin();

// 2. Initialize DB and Model
$database = new Database();
$db = $database->getConnection();
$userModel = new TestModel($db);

// 3. Logic: Fetch user #1 for testing
$userData = $userModel->getUserData(1);

// 4. Logic: Check if we got data, otherwise set a default
if (!$userData) {
    $userData = ['name' => 'Unknown', 'email' => 'N/A', 'role' => 'Guest'];
}

// 5. Pass control to the View
include '../view/test_view.php';