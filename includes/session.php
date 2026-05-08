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
    if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'Admin') {
        header("Location: ../index.php?error=unauthorized");
        exit();
    }
}

function getUserId() {
    return $_SESSION['user_id'] ?? null;
}

/**
 * Destroys the session and redirects to login
 */
function logout() {
    // 1. Clear all session variables
    $_SESSION = [];

    // 2. If it's desired to kill the session, also delete the session cookie.
    if (ini_get("session.use_cookies")) {
        $params = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $params["path"], $params["domain"],
            $params["secure"], $params["httponly"]
        );
    }

    // 3. Destroy the session on the server
    session_destroy();

    // 4. Redirect to login or home page
    header("Location: ../index.php");
    exit();
}