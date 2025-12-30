<?php
$config = require 'config/database.php';

try {
    $pdo = new PDO(
        "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8",
        $config['user'],
        $config['pass']
    );

    $result = $pdo->query("SHOW TABLES LIKE 'orders'");
    if ($result->rowCount() > 0) {
        $columns = $pdo->query("SHOW COLUMNS FROM orders LIKE 'delivery_address'");
        if ($columns->rowCount() == 0) {
            $pdo->exec("ALTER TABLE orders ADD COLUMN delivery_address TEXT");
            echo "Added delivery_address column to orders table.\n";
        }

        $columns = $pdo->query("SHOW COLUMNS FROM orders LIKE 'tracking_number'");
        if ($columns->rowCount() == 0) {
            $pdo->exec("ALTER TABLE orders ADD COLUMN tracking_number VARCHAR(255)");
            echo "Added tracking_number column to orders table.\n";
        }
    }

    $result = $pdo->query("SHOW TABLES LIKE 'invoices'");
    if ($result->rowCount() == 0) {
        echo "Invoices table missing. Please run the full schema setup.\n";
    } else {
        echo "Database is properly set up!\n";
    }

} catch (PDOException $e) {
    echo "Database check failed: " . $e->getMessage() . "\n";
}
