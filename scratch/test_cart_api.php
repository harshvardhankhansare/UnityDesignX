<?php
require_once __DIR__ . '/../config/app.php';
require_once __DIR__ . '/../includes/functions.php';

$_SESSION['user_id'] = 2; // Customer user Tester

$db = get_db();

// Verify Cart API logic directly
$cartStmt = $db->prepare("SELECT cart_id FROM cart WHERE user_id = :user_id");
$cartStmt->execute([':user_id' => 2]);
$cart = $cartStmt->fetch();

if ($cart) {
    $cartId = $cart['cart_id'];
    $stmt = $db->prepare("
        SELECT ci.cart_item_id, ci.quantity, p.title, p.price, (p.price * ci.quantity) AS subtotal
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.product_id
        WHERE ci.cart_id = :cart_id
    ");
    $stmt->execute([':cart_id' => $cartId]);
    $items = $stmt->fetchAll();

    echo "SUCCESS: Logged-in Customer Cart contains " . count($items) . " items." . PHP_EOL;
    foreach ($items as $item) {
        echo " - " . $item['title'] . " (Qty: " . $item['quantity'] . ", Subtotal: ₹" . $item['subtotal'] . ")" . PHP_EOL;
    }
} else {
    echo "NO CART FOUND" . PHP_EOL;
}
