<?php
class Model {
    public static $db;

    public function __construct() {
        if (!self::$db) {
            $config = require __DIR__ . '/../../config/database.php';
            $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";
            try {
                self::$db = new PDO($dsn, $config['user'], $config['pass'], [
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                ]);
            } catch (PDOException $e) {
                die('DB Conn error: ' . $e->getMessage());
            }
        }
    }

    public static function getDb() {
        return self::$db;
    }
}
