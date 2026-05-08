<?php
// Point to the session.php file you created in the includes folder
require_once __DIR__ . '/../includes/session.php'; 

// Load Database Connection
require_once __DIR__ . '/database.php';

// Use __DIR__ to make paths more reliable across different environments
define('SITEURL', 'http://localhost/WowFoods/'); 
define('ASSETS_URL', SITEURL . 'assets/');

// 4. Global Utility Functions
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

// Updated redirect helper to use your SITEURL constant
function redirect($page) {
    header('location:' . SITEURL . $page);
    exit();
}

// 5. Error Reporting & Timezone
error_reporting(E_ALL);
ini_set('display_errors', 1);
date_default_timezone_set('Asia/Colombo');