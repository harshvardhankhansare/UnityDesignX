<?php
/**
 * User Logout API Endpoint / Handler
 * POST or GET /api/auth/logout.php
 */

require_once __DIR__ . '/../../includes/functions.php';

$_SESSION = [];

if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

session_destroy();

if (isset($_SERVER['HTTP_ACCEPT']) && str_contains($_SERVER['HTTP_ACCEPT'], 'application/json')) {
    json_response(['success' => true, 'message' => 'Logged out successfully']);
} else {
    header('Location: ' . APP_URL . '/public/login.php');
    exit;
}
