<?php
require_once('../config/init.php'); // Your DB connection and session start
require_once '../model/auth_model.php';

// 1. Initialize the database connection using your new Class
$database = new Database();
$pdo = $database->getConnection();
// DATA FETCHING
$categories = [];
try {
    $stmt = $pdo->query("SELECT * FROM category WHERE active='Yes' LIMIT 4");
    $categories = $stmt->fetchAll(); // Fetch all into an array
} catch (PDOException $e) {
    // Log error and handle gracefully
    error_log("Error fetching categories: " . $e->getMessage());
}