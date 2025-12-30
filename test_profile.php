<?php
session_start();
require_once 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
        $config['user'],
        $config['pass']
    );

    echo "Database connection successful!\n\n";

    echo "Testing getDetailedOrders query...\n";
    $stmt = $pdo->prepare("
        SELECT o.*, i.invoice_number, i.invoice_date,
               GROUP_CONCAT(oi.product_id, ':', oi.quantity, ':', oi.price SEPARATOR ';') as order_items
        FROM orders o
        LEFT JOIN invoices i ON o.id = i.order_id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        WHERE o.user_id = ?
        GROUP BY o.id
        ORDER BY o.created_at DESC
    ");
    $stmt->execute([1]);
    $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo "Query executed successfully. Found " . count($orders) . " orders.\n\n";

    echo "Testing invoice download query...\n";
    $stmt = $pdo->prepare("
        SELECT i.*, o.delivery_address, o.tracking_number,
               u.fullname, u.email,
               GROUP_CONCAT(oi.product_id, ':', oi.quantity, ':', oi.price, ':', p.name SEPARATOR ';') as order_items
        FROM invoices i
        JOIN orders o ON i.order_id = o.id
        JOIN users u ON i.user_id = u.id
        LEFT JOIN order_items oi ON o.id = oi.order_id
        LEFT JOIN products p ON oi.product_id = p.id
        WHERE i.id = ? AND i.user_id = ?
        GROUP BY i.id
    ");
    $stmt->execute([1, 1]);
    $invoice = $stmt->fetch(PDO::FETCH_ASSOC);
    if ($invoice) {
        echo "Invoice query successful. Invoice: " . $invoice['invoice_number'] . "\n";
    } else {
        echo "No invoice found with ID 1 for user 1 (this is normal if no data exists).\n";
    }

    echo "\nAll database tests passed!\n";

} catch (PDOException $e) {
    echo "Database test failed: " . $e->getMessage() . "\n";
}
?>
