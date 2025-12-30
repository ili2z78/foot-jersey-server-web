<?php
class ProfileController {

    protected $userModel;

    public function __construct() {
        $this->userModel = new User();
    }

    public function index() {
        requireLogin();

        $user = currentUser();
        $userId = $user['id'];

        $invoices = $this->getInvoices($userId);
        $settlements = $this->getSettlements($userId);
        $bonuses = $this->getBonuses($userId);
        $detailedOrders = $this->getDetailedOrders($userId);

        require __DIR__ . '/../Views/profile/index.php';
    }

    protected function getInvoices($userId) {
        $stmt = Model::getDb()->prepare("
            SELECT i.*, o.status as order_status 
            FROM invoices i
            JOIN orders o ON i.order_id = o.id
            WHERE i.user_id = ?
            ORDER BY i.invoice_date DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    protected function getSettlements($userId) {
        $stmt = Model::getDb()->prepare("
            SELECT s.*, i.invoice_number
            FROM settlements s
            LEFT JOIN invoices i ON s.invoice_id = i.id
            WHERE s.user_id = ?
            ORDER BY s.payment_date DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    protected function getBonuses($userId) {
        $stmt = Model::getDb()->prepare("
            SELECT * FROM user_bonuses
            WHERE user_id = ?
            ORDER BY created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll();
    }

    protected function getDetailedOrders($userId) {
        $stmt = Model::getDb()->prepare("
            SELECT o.*, i.invoice_number, i.invoice_date,
                   GROUP_CONCAT(oi.product_id, ':', oi.quantity, ':', oi.price SEPARATOR ';') as order_items
            FROM orders o
            LEFT JOIN invoices i ON o.id = i.order_id
            LEFT JOIN order_items oi ON o.id = oi.order_id
            WHERE o.user_id = ?
            GROUP BY o.id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$userId]);
        $orders = $stmt->fetchAll();

        foreach ($orders as &$order) {
            $order['items'] = [];
            if ($order['order_items']) {
                $items = explode(';', $order['order_items']);
                foreach ($items as $item) {
                    list($product_id, $quantity, $price) = explode(':', $item);
                    $order['items'][] = [
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'price' => $price
                    ];
                }
            }
        }
        return $orders;
    }

    public function downloadInvoice($invoiceId) {
        requireLogin();

        $stmt = Model::getDb()->prepare("
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
        $stmt->execute([$invoiceId, currentUser()['id']]);
        $invoice = $stmt->fetch();

        if (!$invoice) {
            header('Location: /?page=profile');
            exit;
        }

        require_once 'vendor/tecnickcom/tcpdf/tcpdf.php';

        $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);
        $pdf->SetCreator(PDF_CREATOR);
        $pdf->SetAuthor('FootJersey');
        $pdf->SetTitle('Facture #' . $invoice['invoice_number']);
        $pdf->SetSubject('Facture de commande');

        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->AddPage();

        $html = '
        <style>
            body { font-family: Arial, sans-serif; }
            .header { text-align: center; margin-bottom: 30px; }
            .invoice-info { margin-bottom: 20px; }
            .customer-info { margin-bottom: 20px; }
            table { width: 100%; border-collapse: collapse; }
            th, td { border: 1px solid #ddd; padding: 8px; text-align: left; }
            th { background-color: #f2f2f2; }
            .total { font-weight: bold; }
        </style>

        <div class="header">
            <h1>FootJersey</h1>
            <h2>Facture #' . htmlspecialchars($invoice['invoice_number']) . '</h2>
        </div>

        <div class="invoice-info">
            <p><strong>Date de facture:</strong> ' . date('d/m/Y', strtotime($invoice['invoice_date'])) . '</p>
            <p><strong>Montant total:</strong> ' . number_format($invoice['amount'], 2, ',', ' ') . ' €</p>
        </div>

        <div class="customer-info">
            <p><strong>Client:</strong> ' . htmlspecialchars($invoice['fullname']) . '</p>
            <p><strong>Email:</strong> ' . htmlspecialchars($invoice['email']) . '</p>
            <p><strong>Adresse de livraison:</strong> ' . nl2br(htmlspecialchars($invoice['delivery_address'])) . '</p>
        </div>

        <h3>Détails de la commande</h3>
        <table>
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>';

        $items = explode(';', $invoice['order_items']);
        foreach ($items as $item) {
            list($product_id, $quantity, $price, $name) = explode(':', $item);
            $total = $quantity * $price;
            $html .= '
                <tr>
                    <td>' . htmlspecialchars($name) . '</td>
                    <td>' . $quantity . '</td>
                    <td>' . number_format($price, 2, ',', ' ') . ' €</td>
                    <td>' . number_format($total, 2, ',', ' ') . ' €</td>
                </tr>';
        }

        $html .= '
            </tbody>
        </table>

        <p class="total">Total: ' . number_format($invoice['amount'], 2, ',', ' ') . ' €</p>';

        $pdf->writeHTML($html, true, false, true, false, '');
        $pdf->Output('facture_' . $invoice['invoice_number'] . '.pdf', 'D');
        exit;
    }

    public function emailInvoice($invoiceId) {
        requireLogin();

        $stmt = Model::getDb()->prepare("
            SELECT i.*, u.email, u.fullname
            FROM invoices i
            JOIN users u ON i.user_id = u.id
            WHERE i.id = ? AND i.user_id = ?
        ");
        $stmt->execute([$invoiceId, currentUser()['id']]);
        $invoice = $stmt->fetch();

        if (!$invoice) {
            header('Location: /?page=profile');
            exit;
        }

        $to = $invoice['email'];
        $subject = 'Votre facture FootJersey - #' . $invoice['invoice_number'];
        $message = "Bonjour " . $invoice['fullname'] . ",\n\nVotre facture est disponible en pièce jointe.\n\nCordialement,\nL'équipe FootJersey";

        header('Location: /?page=profile&email_sent=1');
        exit;
    }
}
