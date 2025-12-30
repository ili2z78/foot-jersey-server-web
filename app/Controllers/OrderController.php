<?php
class OrderController {

    protected $orderModel;
    protected $cartModel;

    public function __construct() {
        $this->orderModel = new Order();
        $this->cartModel = new Cart();
    }

    public function checkout() {
        requireLogin();

        $user = currentUser();
        $userId = $user['id'];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $items = $this->cartModel->getItems();
            if (empty($items)) {
                $error = "Panier vide.";
                require __DIR__ . '/../Views/order/checkout.php';
                return;
            }

            $total = $this->cartModel->getTotal();

            try {
                $orderId = $this->orderModel->createOrder($userId, $total, $items);
                $this->cartModel->clear();
                header('Location: /?page=order&action=success&id=' . $orderId);
                exit;
            } catch (Exception $e) {
                $error = $e->getMessage();
            }
        } else {
            $items = $this->cartModel->getItems();
            $total = $this->cartModel->getTotal();
            $error = null;
        }

        require __DIR__ . '/../Views/order/checkout.php';
    }

    public function history() {
        requireLogin();

        $user = currentUser();
        $userId = $user['id'];

        $orders = $this->orderModel->getByUser($userId);

        require __DIR__ . '/../Views/order/history.php';
    }

    public function view() {
        requireLogin();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /?page=order&action=history');
            exit;
        }

        $user = currentUser();
        $userId = $user['id'];

        $stmt = Model::getDb()->prepare("SELECT * FROM orders WHERE id = ? AND user_id = ?");
        $stmt->execute([$id, $userId]);
        $order = $stmt->fetch();

        if (!$order) {
            echo "Commande introuvable.";
            exit;
        }

        $items = $this->orderModel->getItems($id);

        require __DIR__ . '/../Views/order/view.php';
    }

    public function success() {
        requireLogin();

        $id = $_GET['id'] ?? null;
        if (!$id) {
            header('Location: /?page=home');
            exit;
        }

        require __DIR__ . '/../Views/order/success.php';
    }
}
