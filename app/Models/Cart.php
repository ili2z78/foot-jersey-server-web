<?php
class Cart extends Model {
    protected $sessionKey = 'cart_items';

    public function __construct() {
        parent::__construct();
        if(!isset($_SESSION)) session_start();
        if (!isset($_SESSION[$this->sessionKey])) {
            $_SESSION[$this->sessionKey] = [];
        }
    }

    public function add($productId, $quantity = 1) {
        $productId = (int)$productId;
        $quantity = max(1, (int)$quantity);
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            $_SESSION[$this->sessionKey][$productId] += $quantity;
        } else {
            $_SESSION[$this->sessionKey][$productId] = $quantity;
        }
        return true;
    }

    public function update($productId, $quantity) {
        $productId = (int)$productId;
        $quantity = (int)$quantity;
        if ($quantity <= 0) {
            $this->remove($productId);
            return;
        }
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            $_SESSION[$this->sessionKey][$productId] = $quantity;
        }
    }

    public function remove($productId) {
        $productId = (int)$productId;
        if (isset($_SESSION[$this->sessionKey][$productId])) {
            unset($_SESSION[$this->sessionKey][$productId]);
        }
    }

    public function clear() {
        $_SESSION[$this->sessionKey] = [];
    }

    public function getItems() {
        $items = [];
        $ids = array_keys($_SESSION[$this->sessionKey]);
        if (count($ids) === 0) return [];
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $stmt = self::$db->prepare("SELECT * FROM products WHERE id IN ($placeholders)");
        $stmt->execute($ids);
        $products = $stmt->fetchAll();
        $byId = [];
        foreach($products as $p) $byId[$p['id']] = $p;
        foreach($_SESSION[$this->sessionKey] as $pid => $qty) {
            if (isset($byId[$pid])) {
                $prod = $byId[$pid];
                $prod['quantity'] = $qty;
                $prod['line_total'] = $qty * $prod['price'];
                $items[] = $prod;
            } else {
                unset($_SESSION[$this->sessionKey][$pid]);
            }
        }
        return $items;
    }

    public function getTotal() {
        $total = 0;
        foreach($this->getItems() as $item) $total += $item['line_total'];
        return $total;
    }
}
