<?php
/**
 * Update Cart Item Quantity API Endpoint
 * POST /api/cart/update.php
 */

require_once __DIR__ . '/../../includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Invalid request method'], 405);
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true) ?? $_POST;

$cartItemId = isset($data['cart_item_id']) ? (int)$data['cart_item_id'] : 0;
$quantity   = isset($data['quantity']) ? (int)$data['quantity'] : 0;

if ($cartItemId <= 0 || $quantity <= 0) {
    json_response(['success' => false, 'error' => 'Valid Cart Item ID and Quantity are required'], 400);
}

$userId = $_SESSION['user_id'];
$db = get_db();

try {
    // Verify item belongs to user cart
    $stmt = $db->prepare("
        SELECT ci.cart_item_id, ci.cart_id 
        FROM cart_items ci
        JOIN cart c ON ci.cart_id = c.cart_id
        WHERE ci.cart_item_id = :cart_item_id AND c.user_id = :user_id
    ");
    $stmt->execute([':cart_item_id' => $cartItemId, ':user_id' => $userId]);
    $item = $stmt->fetch();

    if (!$item) {
        json_response(['success' => false, 'error' => 'Cart item not found or unauthorized'], 404);
    }

    $updStmt = $db->prepare("UPDATE cart_items SET quantity = :quantity WHERE cart_item_id = :cart_item_id");
    $updStmt->execute([':quantity' => $quantity, ':cart_item_id' => $cartItemId]);

    $cartCount = get_cart_count();

    json_response([
        'success'    => true,
        'message'    => 'Cart updated successfully',
        'cart_count' => $cartCount
    ]);

} catch (PDOException $e) {
    error_log("Update Cart API Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to update cart item'], 500);
}
