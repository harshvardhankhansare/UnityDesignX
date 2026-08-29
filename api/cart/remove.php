<?php
/**
 * Remove Item from Cart API Endpoint
 * POST /api/cart/remove.php
 */

require_once __DIR__ . '/../../includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Invalid request method'], 405);
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true) ?? $_POST;

$cartItemId = isset($data['cart_item_id']) ? (int)$data['cart_item_id'] : 0;

if ($cartItemId <= 0) {
    json_response(['success' => false, 'error' => 'Valid Cart Item ID is required'], 400);
}

$userId = $_SESSION['user_id'];
$db = get_db();

try {
    $delStmt = $db->prepare("
        DELETE ci FROM cart_items ci
        JOIN cart c ON ci.cart_id = c.cart_id
        WHERE ci.cart_item_id = :cart_item_id AND c.user_id = :user_id
    ");
    $delStmt->execute([':cart_item_id' => $cartItemId, ':user_id' => $userId]);

    $cartCount = get_cart_count();

    json_response([
        'success'    => true,
        'message'    => 'Item removed from cart',
        'cart_count' => $cartCount
    ]);

} catch (PDOException $e) {
    error_log("Remove from Cart API Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to remove cart item'], 500);
}
