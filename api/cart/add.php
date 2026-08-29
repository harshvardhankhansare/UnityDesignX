<?php
/**
 * Add Product to Cart API Endpoint
 * POST /api/cart/add.php
 */

require_once __DIR__ . '/../../includes/functions.php';

require_login();

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Invalid request method'], 405);
}

$rawInput = file_get_contents('php://input');
$data = json_decode($rawInput, true) ?? $_POST;

$productId = isset($data['product_id']) ? (int)$data['product_id'] : 0;
$quantity  = isset($data['quantity']) ? (int)$data['quantity'] : 1;

if ($productId <= 0 || $quantity <= 0) {
    json_response(['success' => false, 'error' => 'Valid Product ID and Quantity are required'], 400);
}

$userId = $_SESSION['user_id'];
$db = get_db();

try {
    // Verify product exists and has stock
    $pStmt = $db->prepare("SELECT product_id, title, price, stock_quantity FROM products WHERE product_id = :id AND is_active = 1");
    $pStmt->execute([':id' => $productId]);
    $product = $pStmt->fetch();

    if (!$product) {
        json_response(['success' => false, 'error' => 'Product not found or unavailable'], 404);
    }

    // Get or Create Cart Header
    $cStmt = $db->prepare("SELECT cart_id FROM cart WHERE user_id = :user_id");
    $cStmt->execute([':user_id' => $userId]);
    $cart = $cStmt->fetch();

    if (!$cart) {
        $cIns = $db->prepare("INSERT INTO cart (user_id) VALUES (:user_id)");
        $cIns->execute([':user_id' => $userId]);
        $cartId = $db->lastInsertId();
    } else {
        $cartId = $cart['cart_id'];
    }

    // Add or Update item in cart_items
    $itemStmt = $db->prepare("
        INSERT INTO cart_items (cart_id, product_id, quantity)
        VALUES (:cart_id, :product_id, :quantity)
        ON DUPLICATE KEY UPDATE quantity = quantity + VALUES(quantity)
    ");
    $itemStmt->execute([
        ':cart_id'    => $cartId,
        ':product_id' => $productId,
        ':quantity'   => $quantity
    ]);

    $cartCount = get_cart_count();

    json_response([
        'success'    => true,
        'message'    => '"' . $product['title'] . '" added to your cart!',
        'cart_count' => $cartCount,
    ]);

} catch (PDOException $e) {
    error_log("Add to Cart API Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to add item to cart'], 500);
}
