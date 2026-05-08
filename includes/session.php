<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
        // Redirect to the login view relative to the project root
        header("Location: ../view/login_view.php");
        exit();
    }
}

function checkAdmin() {
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
        header("Location: ../index.php?error=unauthorized");
        exit();
    }
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}