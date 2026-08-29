<?php
/**
 * Product Detail API Endpoint
 * GET /api/products/detail.php?id=1
 */

require_once __DIR__ . '/../../includes/functions.php';

$productId = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$slug      = sanitize_input($_GET['slug'] ?? '');

if ($productId <= 0 && empty($slug)) {
    json_response(['success' => false, 'error' => 'Product ID or slug is required'], 400);
}

$db = get_db();

try {
    if ($productId > 0) {
        $stmt = $db->prepare("
            SELECT p.*, c.category_name, c.slug AS category_slug
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.product_id = :id AND p.is_active = 1
        ");
        $stmt->execute([':id' => $productId]);
    } else {
        $stmt = $db->prepare("
            SELECT p.*, c.category_name, c.slug AS category_slug
            FROM products p
            JOIN categories c ON p.category_id = c.category_id
            WHERE p.slug = :slug AND p.is_active = 1
        ");
        $stmt->execute([':slug' => $slug]);
    }

    $product = $stmt->fetch();

    if (!$product) {
        json_response(['success' => false, 'error' => 'Product not found'], 404);
    }

    // Fetch related products in same category
    $relatedStmt = $db->prepare("
        SELECT p.product_id, p.title, p.price, p.main_image, c.category_name
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        WHERE p.category_id = :category_id AND p.product_id != :product_id AND p.is_active = 1
        LIMIT 4
    ");
    $relatedStmt->execute([
        ':category_id' => $product['category_id'],
        ':product_id'  => $product['product_id']
    ]);
    $relatedProducts = $relatedStmt->fetchAll();

    json_response([
        'success' => true,
        'product' => $product,
        'related' => $relatedProducts,
    ]);

} catch (PDOException $e) {
    error_log("Product Detail API Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to fetch product details'], 500);
}
