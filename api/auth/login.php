<?php
/**
 * User Login API Endpoint
 * POST /api/auth/login.php
 */

require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Invalid request method'], 405);
}

// Get input from JSON payload or POST fields
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true) ?? $_POST;

$email    = strtolower(sanitize_input($data['email'] ?? ''));
$password = $data['password'] ?? '';

if (empty($email) || empty($password)) {
    json_response(['success' => false, 'error' => 'Email and password are required'], 400);
}

$db = get_db();

try {
    $stmt = $db->prepare("
        SELECT u.user_id, u.role_id, u.full_name, u.email, u.password_hash, r.role_name
        FROM users u
        JOIN roles r ON u.role_id = r.role_id
        WHERE u.email = :email
    ");
    $stmt->execute([':email' => $email]);
    $user = $stmt->fetch();

    if (!$user || !password_verify($password, $user['password_hash'])) {
        json_response(['success' => false, 'error' => 'Invalid email or password'], 401);
    }

    // Regenerate Session ID to prevent session fixation attacks
    session_regenerate_id(true);

    $_SESSION['user_id'] = $user['user_id'];
    $_SESSION['user'] = [
        'user_id'   => $user['user_id'],
        'full_name' => $user['full_name'],
        'email'     => $user['email'],
        'role_id'   => $user['role_id'],
        'role_name' => $user['role_name'],
    ];

    $redirectUrl = ($user['role_name'] === 'admin') ? APP_URL . '/admin/dashboard.php' : APP_URL . '/public/index.php';

    json_response([
        'success'      => true,
        'message'      => 'Login successful',
        'redirect_url' => $redirectUrl,
        'user'         => $_SESSION['user'],
    ], 200);

} catch (PDOException $e) {
    error_log("Login DB Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'An authentication error occurred. Please try again.'], 500);
}
