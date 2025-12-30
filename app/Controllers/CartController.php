<?php
class CartController {

    protected $cartModel;

    public function __construct() {
        $this->cartModel = new Cart();
    }

    public function add() {
        $id = $_GET['id'] ?? null;
        $qty = $_POST['quantity'] ?? 1;
        if (!$id) {
            header('Location: /?page=product&action=list');
            exit;
        }
        $this->cartModel->add($id, $qty);
        header('Location: /?page=cart&action=view');
        exit;
    }

    public function update() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /?page=cart&action=view');
            exit;
        }
        $quantities = $_POST['quantity'] ?? [];
        foreach($quantities as $pid => $q) {
            $this->cartModel->update($pid, $q);
        }
        header('Location: /?page=cart&action=view');
        exit;
    }

    public function remove() {
        $id = $_GET['id'] ?? null;
        if ($id) $this->cartModel->remove($id);
        header('Location: /?page=cart&action=view');
        exit;
    }

    public function view() {
        $items = $this->cartModel->getItems();
        $total = $this->cartModel->getTotal();
        require __DIR__ . '/../Views/cart/view.php';
    }
}
