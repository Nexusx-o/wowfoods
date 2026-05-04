<?php
/**
 * Global Initialization File
 * This file acts as a Controller for setting up the application environment.
 */

// 1. Start Session
// We check if a session exists to prevent "Session already started" errors.
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. Load Database Connection
// This connects the logic to your 'Model' layer.
require_once 'database.php';

// 3. Define Global Constants
// These help you manage paths easily without hardcoding links.
define('SITEURL', 'http://localhost/WowFoods/'); // Change to your actual project URL
define('ASSETS_URL', SITEURL . 'assets/');

// 4. Global Utility Functions (Optional)
// Putting common functions here saves you from rewriting code.

/**
 * Clean user input to prevent XSS (Cross-Site Scripting)
 */
function cleanInput($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

/**
 * Redirect helper for cleaner code
 */
function redirect($page) {
    header('location:'.SITEURL.$page);
    exit();
}

// 5. Error Reporting (For Development)
// Turn this off (set to 0) when you move the site to a real server.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// 6. Set Timezone
date_default_timezone_set('Asia/Manila'); // Set this to your local timezone