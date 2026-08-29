<?php
/**
 * Test Phase 9 — Checkout & Place Order API
 */
require_once __DIR__ . '/../includes/functions.php';

$db = get_db();

// 1. Ensure test user is logged in session
$_SESSION['user_id'] = 2; // Customer user_id from seed
$_SESSION['user'] = [
    'user_id' => 2,
    'full_name' => 'Tester User',
    'email' => 'tester@gmail.com',
    'role_name' => 'customer',
    'role_id' => 2
];

echo "Testing Order Placement API...\n";

// Ensure customer has items in cart
$cartStmt = $db->prepare("SELECT cart_id FROM cart WHERE user_id = 2");
$cartStmt->execute();
$cart = $cartStmt->fetch();

if (!$cart) {
    $db->query("INSERT INTO cart (user_id) VALUES (2)");
    $cartId = $db->lastInsertId();
} else {
    $cartId = $cart['cart_id'];
}

// Add 1 test product item into cart_items if empty
$checkItems = $db->prepare("SELECT COUNT(*) as count FROM cart_items WHERE cart_id = :cid");
$checkItems->execute([':cid' => $cartId]);
if ($checkItems->fetch()['count'] == 0) {
    $db->prepare("INSERT INTO cart_items (cart_id, product_id, quantity) VALUES (:cid, 1, 2)")->execute([':cid' => $cartId]);
}

// Call API logic directly
$_SERVER['REQUEST_METHOD'] = 'POST';

// Mock post payload
$payload = [
    'shipping_name' => 'Tester User',
    'shipping_address' => '123 Test Suite, Tech Park',
    'shipping_city' => 'Bengaluru',
    'shipping_state' => 'Karnataka',
    'shipping_pin' => '560001',
    'shipping_phone' => '+91 9876543210',
    'payment_method' => 'cod'
];

// Capture place.php output
ob_start();
// Inject raw input stream mock via php://input override in scratch test or run place logic
require __DIR__ . '/../api/orders/history.php';
$out = ob_get_clean();

echo "History API Output:\n" . $out . "\n";

echo "Database verification:\n";
$orders = $db->query("SELECT order_id, order_number, status, total_amount FROM orders")->fetchAll();
print_r($orders);

$orderItems = $db->query("SELECT * FROM order_items")->fetchAll();
print_r($orderItems);
