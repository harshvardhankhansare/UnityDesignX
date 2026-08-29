<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../config/database.php';

$db = Database::getInstance();

// 1. Test Admin Login Verification
$email = 'admin@unitydesign.com';
$password = 'admin123';

$stmt = $db->prepare("SELECT password_hash FROM users WHERE email = :email");
$stmt->execute([':email' => $email]);
$user = $stmt->fetch();

if ($user && password_verify($password, $user['password_hash'])) {
    echo "SUCCESS: Admin login password_verify() PASSED!" . PHP_EOL;
} else {
    echo "FAILED: Admin login password_verify() failed." . PHP_EOL;
}

// 2. Test Customer Login Verification
$cEmail = 'tester@gmail.com';
$cPassword = 'Tester@123';

$stmt2 = $db->prepare("SELECT password_hash FROM users WHERE email = :email");
$stmt2->execute([':email' => $cEmail]);
$cUser = $stmt2->fetch();

if ($cUser && password_verify($cPassword, $cUser['password_hash'])) {
    echo "SUCCESS: Customer login password_verify() PASSED!" . PHP_EOL;
} else {
    echo "FAILED: Customer login password_verify() failed." . PHP_EOL;
}
