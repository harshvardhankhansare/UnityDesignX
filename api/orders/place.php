<?php
/**
 * API: Place Order
 * POST /api/orders/place.php
 * Body: { shipping_name, shipping_address, shipping_city, shipping_state, shipping_pin, shipping_phone, payment_method }
 * UnityDesignX Platform
 */

require_once __DIR__ . '/../../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

// ── Auth Guard ────────────────────────────────────────────────
if (!is_logged_in()) {
    json_response(['success' => false, 'error' => 'Authentication required.'], 401);
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    json_response(['success' => false, 'error' => 'Method not allowed.'], 405);
}

// ── Parse Input ───────────────────────────────────────────────
$input = json_decode(file_get_contents('php://input'), true);

$userId          = (int)$_SESSION['user_id'];
$shippingName    = sanitize_input($input['shipping_name']    ?? '');
$shippingAddress = sanitize_input($input['shipping_address'] ?? '');
$shippingCity    = sanitize_input($input['shipping_city']    ?? '');
$shippingState   = sanitize_input($input['shipping_state']   ?? '');
$shippingPin     = sanitize_input($input['shipping_pin']     ?? '');
$shippingPhone   = sanitize_input($input['shipping_phone']   ?? '');
$paymentMethod   = sanitize_input($input['payment_method']   ?? 'cod');

// ── Basic Validation ─────────────────────────────────────────
if (!$shippingName || !$shippingAddress || !$shippingCity || !$shippingPin || !$shippingPhone) {
    json_response(['success' => false, 'error' => 'All shipping fields are required.'], 422);
}

if (!preg_match('/^\d{6}$/', $shippingPin)) {
    json_response(['success' => false, 'error' => 'Invalid PIN code — must be 6 digits.'], 422);
}

if (!preg_match('/^\+?[\d\s\-]{10,15}$/', $shippingPhone)) {
    json_response(['success' => false, 'error' => 'Invalid phone number.'], 422);
}

$allowedPayments = ['cod', 'upi', 'card'];
if (!in_array($paymentMethod, $allowedPayments)) {
    $paymentMethod = 'cod';
}

// ── Database Transaction ──────────────────────────────────────
$db = get_db();

try {
    $db->beginTransaction();

    // 1. Get active cart for this user
    $cartStmt = $db->prepare("SELECT cart_id FROM cart WHERE user_id = :uid LIMIT 1");
    $cartStmt->execute([':uid' => $userId]);
    $cart = $cartStmt->fetch();

    if (!$cart) {
        $db->rollBack();
        json_response(['success' => false, 'error' => 'Your cart is empty.'], 400);
    }

    $cartId = $cart['cart_id'];

    // 2. Get cart items with product details
    $itemsStmt = $db->prepare("
        SELECT
            ci.cart_item_id,
            ci.product_id,
            ci.quantity,
            p.price,
            p.title,
            p.stock_quantity,
            (ci.quantity * p.price) AS subtotal
        FROM cart_items ci
        JOIN products p ON ci.product_id = p.product_id
        WHERE ci.cart_id = :cart_id
    ");
    $itemsStmt->execute([':cart_id' => $cartId]);
    $cartItems = $itemsStmt->fetchAll();

    if (empty($cartItems)) {
        $db->rollBack();
        json_response(['success' => false, 'error' => 'Your cart is empty.'], 400);
    }

    // 3. Validate stock for each item
    foreach ($cartItems as $item) {
        if ($item['quantity'] > $item['stock_quantity']) {
            $db->rollBack();
            json_response([
                'success' => false,
                'error'   => "Insufficient stock for \"{$item['title']}\". Only {$item['stock_quantity']} left."
            ], 409);
        }
    }

    // 4. Calculate total
    $totalAmount = array_sum(array_column($cartItems, 'subtotal'));

    // 5. Build shipping address JSON
    $shippingJson = json_encode([
        'name'    => $shippingName,
        'address' => $shippingAddress,
        'city'    => $shippingCity,
        'state'   => $shippingState,
        'pin'     => $shippingPin,
        'phone'   => $shippingPhone,
    ]);

    // 6. Generate human-readable order number
    $orderNumber = 'UDX-' . strtoupper(substr(uniqid(), -6)) . '-' . date('ymd');

    // 7. Insert into orders
    $orderStmt = $db->prepare("
        INSERT INTO orders (user_id, order_number, status, total_amount, shipping_address, payment_method, created_at)
        VALUES (:uid, :order_number, 'pending', :total, :shipping, :payment, NOW())
    ");
    $orderStmt->execute([
        ':uid'          => $userId,
        ':order_number' => $orderNumber,
        ':total'        => $totalAmount,
        ':shipping'     => $shippingJson,
        ':payment'      => $paymentMethod,
    ]);
    $orderId = (int)$db->lastInsertId();

    // 8. Insert order items + decrement stock
    $itemInsert = $db->prepare("
        INSERT INTO order_items (order_id, product_id, quantity, unit_price, subtotal)
        VALUES (:order_id, :product_id, :qty, :unit_price, :subtotal)
    ");
    $stockUpdate = $db->prepare("
        UPDATE products SET stock_quantity = stock_quantity - :qty WHERE product_id = :pid
    ");

    foreach ($cartItems as $item) {
        $itemInsert->execute([
            ':order_id'   => $orderId,
            ':product_id' => $item['product_id'],
            ':qty'        => $item['quantity'],
            ':unit_price' => $item['price'],
            ':subtotal'   => $item['subtotal'],
        ]);
        $stockUpdate->execute([
            ':qty' => $item['quantity'],
            ':pid' => $item['product_id'],
        ]);
    }

    // 9. Clear cart items (keep cart row, remove items)
    $clearStmt = $db->prepare("DELETE FROM cart_items WHERE cart_id = :cart_id");
    $clearStmt->execute([':cart_id' => $cartId]);

    $db->commit();

    json_response([
        'success'      => true,
        'message'      => 'Order placed successfully!',
        'order_id'     => $orderId,
        'order_number' => $orderNumber,
        'total_amount' => $totalAmount,
        'item_count'   => count($cartItems),
    ]);

} catch (PDOException $e) {
    $db->rollBack();
    error_log('Place order error: ' . $e->getMessage());
    json_response(['success' => false, 'error' => 'Order could not be placed. Please try again.'], 500);
}
