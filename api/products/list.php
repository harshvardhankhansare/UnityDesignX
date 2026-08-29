<?php
/**
 * Dynamic Product List API Endpoint
 * GET /api/products/list.php
 */

require_once __DIR__ . '/../../includes/functions.php';

$category = sanitize_input($_GET['category'] ?? '');
$search   = sanitize_input($_GET['search'] ?? '');
$sort     = sanitize_input($_GET['sort'] ?? 'newest');
$limit    = isset($_GET['limit']) ? (int)$_GET['limit'] : 50;

$db = get_db();

$whereClauses = ["p.is_active = 1"];
$params = [];

// Filter by Category Slug or Category ID
if (!empty($category) && $category !== 'all') {
    if (is_numeric($category)) {
        $whereClauses[] = "p.category_id = :category_id";
        $params[':category_id'] = (int)$category;
    } else {
        $whereClauses[] = "c.slug = :category_slug";
        $params[':category_slug'] = $category;
    }
}

// Search Filter
if (!empty($search)) {
    $whereClauses[] = "(p.title LIKE :search OR p.description LIKE :search)";
    $params[':search'] = '%' . $search . '%';
}

$whereSQL = implode(" AND ", $whereClauses);

// Sorting
$orderSQL = "p.created_at DESC";
if ($sort === 'price_low') {
    $orderSQL = "p.price ASC";
} elseif ($sort === 'price_high') {
    $orderSQL = "p.price DESC";
} elseif ($sort === 'title') {
    $orderSQL = "p.title ASC";
}

try {
    $sql = "
        SELECT p.product_id, p.category_id, p.title, p.slug, p.description, p.price, 
               p.stock_quantity, p.main_image, p.is_featured, p.created_at,
               c.category_name, c.slug AS category_slug
        FROM products p
        JOIN categories c ON p.category_id = c.category_id
        WHERE {$whereSQL}
        ORDER BY {$orderSQL}
        LIMIT :limit
    ";

    $stmt = $db->prepare($sql);
    foreach ($params as $key => $val) {
        $stmt->bindValue($key, $val);
    }
    $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
    $stmt->execute();

    $products = $stmt->fetchAll();

    // Fetch all categories for filter tabs
    $catStmt = $db->query("SELECT category_id, category_name, slug FROM categories ORDER BY category_name ASC");
    $categories = $catStmt->fetchAll();

    json_response([
        'success'    => true,
        'count'      => count($products),
        'products'   => $products,
        'categories' => $categories,
    ]);

} catch (PDOException $e) {
    error_log("Product List API Error: " . $e->getMessage());
    json_response(['success' => false, 'error' => 'Failed to fetch products catalog'], 500);
}
