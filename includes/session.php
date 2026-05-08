<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

function checkLogin() {
    if (!isset($_SESSION['user_id'])) {
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

function logout() {
    // Clear all session variables
    $_SESSION = [];

    // Kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // Destroy the session on the server
    session_destroy();

    // Redirect to login or home page
    header("Location: ../index.php");
    exit();
}