<?php
/**
 * User Registration API Endpoint
 * POST /api/auth/register.php
 */

require_once __DIR__ . '/../../includes/functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Invalid request method'], 405);
}

// Get input from JSON payload or POST fields
$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true) ?? $_POST;

$fullName = sanitize_input($data['full_name'] ?? '');
$email    = strtolower(sanitize_input($data['email'] ?? ''));
$password = $data['password'] ?? '';

// Validations
if (empty($fullName) || empty($email) || empty($password)) {
    json_response(['success' => false, 'error' => 'All fields (Full Name, Email, Password) are required'], 400);
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    json_response(['success' => false, 'error' => 'Invalid email address format'], 400);
}

if (strlen($password) < 6) {
    json_response(['success' => false, 'error' => 'Password must be at least 6 characters long'], 400);
}

$db = get_db();

// Check if email already exists
$checkStmt = $db->prepare("SELECT user_id FROM users WHERE email = :email");
$checkStmt->execute([':email' => $email]);
if ($checkStmt->fetch()) {
    json_response(['success' => false, 'error' => 'An account with this email address already exists'], 409);
}

// Hash password with bcrypt
$passwordHash = password_hash($password, PASSWORD_BCRYPT);

try {
    $stmt = $db->prepare("
        INSERT INTO users (role_id, full_name, email, password_hash)
        VALUES (2, :full_name, :email, :password_hash)
    ");
    $stmt->execute([
        ':full_name'     => $fullName,
        ':email'         => $email,
        ':password_hash' => $passwordHash,
    ]);

    $userId = $db->lastInsertId();

    // Auto-login user upon successful registration
    $_SESSION['user_id'] = $userId;
    $_SESSION['user'] = [
        'user_id'   => $userId,
        'full_name' => $fullName,
        'email'     => $email,
        'role_id'   => 2,
        'role_name' => 'customer',
    ];

    json_response([
        'success' => true,
        'message' => 'Registration successful! Welcome to UnityDesignX.',
        'user'    => $_SESSION['user'],
    ], 201);

} catch (PDOException $e) {
    error_log("Registration DB Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to create user account. Please try again.'], 500);
}
