<?php
require_once __DIR__ . '/../includes/functions.php';

try {
    $db = get_db();
    $stmt = $db->query('SELECT COUNT(*) AS total_products FROM products');
    $row = $stmt->fetch();
    echo "SUCCESS: PDO Database Infrastructure connected! Products in catalog: " . $row['total_products'] . PHP_EOL;

    $stmt2 = $db->query('SELECT COUNT(*) AS total_categories FROM categories');
    $row2 = $stmt2->fetch();
    echo "SUCCESS: Categories in catalog: " . $row2['total_categories'] . PHP_EOL;

    $stmt3 = $db->query('SELECT COUNT(*) AS total_users FROM users');
    $row3 = $stmt3->fetch();
    echo "SUCCESS: Users in database: " . $row3['total_users'] . PHP_EOL;

} catch (Exception $e) {
    echo "ERROR: " . $e->getMessage() . PHP_EOL;
}
