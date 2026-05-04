<?php
// Start the session to track user data across pages
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

/**
 * Security Function: Check if user is logged in
 * Redirects to login page if unauthorized
 */
function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        header("Location: login.php");
        exit();
    }
}

/**
 * Role-Based Access Control (RBAC)
 * Redirects non-admin users if they try to access admin pages
 */
function checkAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../public/index.php?error=unauthorized");
        exit();
    }
}

/**
 * Helper to get current user ID for Tier 3 (Data Layer) queries
 */
function getUserId() {
    return $_SESSION['user_id'] ?? null;
}
?>