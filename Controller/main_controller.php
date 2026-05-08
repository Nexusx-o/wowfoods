<?php
require_once('../config/init.php');
require_once '../model/auth_model.php';

// Initialize the database connection 
$database = new Database();
$pdo = $database->getConnection();
// DATA FETCHING
$categories = [];
try {
    $stmt = $pdo->query("SELECT * FROM category WHERE active='Yes' LIMIT 4");
    $categories = $stmt->fetchAll();
} catch (PDOException $e) {
    error_log("Error fetching categories: " . $e->getMessage());
}