<?php
/**
 * API: Order History
 * GET /api/orders/history.php
 * Returns all orders + nested items for the logged-in user.
 * UnityDesignX Platform
 */

require_once __DIR__ . '/../../includes/functions.php';

header('Content-Type: application/json; charset=utf-8');

if (!is_logged_in()) {
    json_response(['success' => false, 'error' => 'Authentication required.'], 401);
}

$userId = (int)$_SESSION['user_id'];
$db = get_db();

try {
    // Fetch all orders for this user
    $ordersStmt = $db->prepare("
        SELECT
            o.order_id,
            o.order_number,
            o.status,
            o.total_amount,
            o.shipping_address,
            o.payment_method,
            o.created_at,
            COUNT(oi.order_item_id) AS item_count
        FROM orders o
        LEFT JOIN order_items oi ON o.order_id = oi.order_id
        WHERE o.user_id = :uid
        GROUP BY o.order_id
        ORDER BY o.created_at DESC
    ");
    $ordersStmt->execute([':uid' => $userId]);
    $orders = $ordersStmt->fetchAll();

    if (empty($orders)) {
        json_response(['success' => true, 'orders' => []]);
    }

    // Fetch items for each order
    $itemsStmt = $db->prepare("
        SELECT
            oi.order_item_id,
            oi.order_id,
            oi.quantity,
            oi.unit_price,
            oi.subtotal,
            p.product_id,
            p.title,
            p.main_image,
            c.name AS category_name
        FROM order_items oi
        JOIN products p ON oi.product_id = p.product_id
        JOIN categories c ON p.category_id = c.category_id
        WHERE oi.order_id = :order_id
        ORDER BY oi.order_item_id ASC
    ");

    // Map order items into orders
    $orderIds = array_column($orders, 'order_id');
    $itemsByOrder = [];
    foreach ($orderIds as $oid) {
        $itemsStmt->execute([':order_id' => $oid]);
        $itemsByOrder[$oid] = $itemsStmt->fetchAll();
    }

    // Build final response
    $result = array_map(function ($order) use ($itemsByOrder) {
        $shipping = json_decode($order['shipping_address'], true) ?? [];
        return [
            'order_id'        => (int)$order['order_id'],
            'order_number'    => $order['order_number'],
            'status'          => $order['status'],
            'total_amount'    => (float)$order['total_amount'],
            'item_count'      => (int)$order['item_count'],
            'payment_method'  => $order['payment_method'] ?? 'cod',
            'created_at'      => $order['created_at'],
            'shipping'        => $shipping,
            'items'           => $itemsByOrder[(int)$order['order_id']] ?? [],
        ];
    }, $orders);

    json_response(['success' => true, 'orders' => $result]);

} catch (PDOException $e) {
    error_log('Order history error: ' . $e->getMessage());
    json_response(['success' => false, 'error' => 'Could not load order history.'], 500);
}
