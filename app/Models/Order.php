<?php
class Order extends Model {

    public function createOrder($userId, $total, $items) {
        try {
            self::$db->beginTransaction();

            $stmt = self::$db->prepare("INSERT INTO orders (user_id, total, status) VALUES (?, ?, 'pending')");
            $stmt->execute([$userId, $total]);
            $orderId = self::$db->lastInsertId();

            $stmtItem = self::$db->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
            $stmtUpdateStock = self::$db->prepare("UPDATE products SET stock = stock - ? WHERE id = ? AND stock >= ?");

            foreach ($items as $it) {
                $stmtItem->execute([$orderId, $it['id'], $it['quantity'], $it['price']]);
                $stmtUpdateStock->execute([$it['quantity'], $it['id'], $it['quantity']]);
                if ($stmtUpdateStock->rowCount() === 0) {
                    throw new Exception("Stock insuffisant pour le produit ID {$it['id']}");
                }
            }

            self::$db->commit();
            return $orderId;
        } catch (Exception $e) {
            self::$db->rollBack();
            throw $e;
        }
    }

    public function getByUser($userId) {
        $stmt = self::$db->prepare("SELECT * FROM orders WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    public function getItems($orderId) {
        $stmt = self::$db->prepare("SELECT oi.*, p.name, p.image FROM order_items oi JOIN products p ON oi.product_id = p.id WHERE oi.order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll();
    }
}
