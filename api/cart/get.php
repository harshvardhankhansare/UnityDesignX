<?php
/**
 * Fetch User Cart Items API Endpoint
 * GET /api/cart/get.php
 */

require_once __DIR__ . '/../../includes/functions.php';

require_login();

$userId = $_SESSION['user_id'];
$db = get_db();

try {
    // Get or Create user cart header
    $cartStmt = $db->prepare("SELECT cart_id FROM cart WHERE user_id = :user_id");
    $cartStmt->execute([':user_id' => $userId]);
    $cart = $cartStmt->fetch();

    if (!$cart) {
        $createStmt = $db->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
        $createStmt->execute([':user_id' => $userId]);
        $cartId = $db->lastInsertId();
    } else {
        $cartId = $cart['cart_id'];
    }

    // Fetch cart items joined with products
    $stmt = $db->prepare("
        SELECT ci.cart_item_id, ci.quantity, p.product_id, p.title, p.price, p.main_image, p.stock_quantity, c.category_name,
               (p.price * ci.quantity) AS subtotal
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.product_id
        JOIN categories c ON p.category_id = c.category_id
        WHERE ci.cart_id = :cart_id
        ORDER BY ci.created_at DESC
    ");
    $stmt->execute([':cart_id' => $cartId]);
    $items = $stmt->fetchAll();

    $totalAmount = 0;
    $totalCount = 0;
    foreach ($items as $item) {
        $totalAmount += (float)$item['subtotal'];
        $totalCount += (int)$item['quantity'];
    }

    json_response([
        'success'      => true,
        'cart_id'      => $cartId,
        'total_count'  => $totalCount,
        'total_amount' => $totalAmount,
        'items'        => $items,
    ]);

} catch (PDOException $e) {
    error_log("Get Cart API Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to fetch cart contents'], 500);
}
