<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="profile-section">
  <div class="container">
    <div class="profile-header">
      <h1 class="profile-title">
        <i class="fas fa-user-circle"></i>
        Mon Profil
      </h1>
      <div class="profile-info">
        <p class="profile-name">
          <strong><?= htmlspecialchars($user['fullname'] ?: $user['email']) ?></strong>
        </p>
        <p class="profile-email">
          <i class="fas fa-envelope"></i>
          <?= htmlspecialchars($user['email']) ?>
        </p>
      </div>
    </div>

    <div class="profile-content">
      <!-- Orders Section -->
      <div class="profile-card">
        <h2 class="profile-card-title">
          <i class="fas fa-shopping-cart"></i>
          Mes Commandes
        </h2>
        <?php
        $detailedOrders = $this->getDetailedOrders($user['id']);
        if (empty($detailedOrders)): ?>
          <div class="empty-state">
            <p>Aucune commande trouvée.</p>
          </div>
        <?php else: ?>
          <div class="orders-list">
            <?php foreach ($detailedOrders as $order): ?>
              <div class="order-card">
                <div class="order-header">
                  <div class="order-info">
                    <h3>Commande #<?= htmlspecialchars($order['id']) ?></h3>
                    <p class="order-date">Date: <?= date('d/m/Y', strtotime($order['created_at'])) ?></p>
                    <p class="order-status">
                      <span class="status-badge status-<?= htmlspecialchars($order['status']) ?>">
                        <?= htmlspecialchars($order['status']) ?>
                      </span>
                    </p>
                  </div>
                  <div class="order-total">
                    <strong>Total: <?= number_format($order['total'], 2, ',', ' ') ?> €</strong>
                  </div>
                </div>

                <div class="order-details">
                  <?php if ($order['delivery_address']): ?>
                    <div class="delivery-info">
                      <h4><i class="fas fa-map-marker-alt"></i> Adresse de livraison</h4>
                      <p><?= nl2br(htmlspecialchars($order['delivery_address'])) ?></p>
                    </div>
                  <?php endif; ?>

                  <?php if ($order['tracking_number']): ?>
                    <div class="tracking-info">
                      <h4><i class="fas fa-truck"></i> Suivi de livraison</h4>
                      <p>Numéro de suivi: <strong><?= htmlspecialchars($order['tracking_number']) ?></strong></p>
                      <a href="#" class="btn-secondary btn-sm">Suivre ma commande</a>
                    </div>
                  <?php endif; ?>

                  <div class="order-items">
                    <h4>Articles commandés</h4>
                    <ul>
                      <?php foreach ($order['items'] as $item): ?>
                        <li>
                          Produit #<?= $item['product_id'] ?> - Quantité: <?= $item['quantity'] ?> - Prix: <?= number_format($item['price'], 2, ',', ' ') ?> €
                        </li>
                      <?php endforeach; ?>
                    </ul>
                  </div>

                  <?php if ($order['invoice_number']): ?>
                    <div class="invoice-actions">
                      <h4><i class="fas fa-file-pdf"></i> Facture</h4>
                      <p>Numéro de facture: <strong><?= htmlspecialchars($order['invoice_number']) ?></strong></p>
                      <div class="action-buttons">
                        <a href="/?page=profile&action=download_invoice&id=<?= $order['id'] ?>" class="btn-primary btn-sm">
                          <i class="fas fa-download"></i> Télécharger PDF
                        </a>
                        <a href="/?page=profile&action=email_invoice&id=<?= $order['id'] ?>" class="btn-secondary btn-sm">
                          <i class="fas fa-envelope"></i> Envoyer par email
                        </a>
                      </div>
                    </div>
                  <?php endif; ?>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Invoices Section -->
      <div class="profile-card">
        <h2 class="profile-card-title">
          <i class="fas fa-file-invoice"></i>
          Mes Factures
        </h2>
        <?php if (empty($invoices)): ?>
          <div class="empty-state">
            <p>Aucune facture disponible.</p>
          </div>
        <?php else: ?>
          <div class="invoices-table">
            <table>
              <thead>
                <tr>
                  <th>Numéro de Facture</th>
                  <th>Montant</th>
                  <th>Date</th>
                  <th>Statut Commande</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($invoices as $inv): ?>
                  <tr>
                    <td class="invoice-number">
                      <span class="badge"><?= htmlspecialchars($inv['invoice_number']) ?></span>
                    </td>
                    <td class="invoice-amount">
                      <strong><?= number_format($inv['amount'], 2, ',', ' ') ?> €</strong>
                    </td>
                    <td class="invoice-date">
                      <?= date('d/m/Y', strtotime($inv['invoice_date'])) ?>
                    </td>
                    <td class="invoice-status">
                      <span class="status-badge status-<?= htmlspecialchars($inv['order_status']) ?>">
                        <?= htmlspecialchars($inv['order_status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Settlements Section -->
      <div class="profile-card">
        <h2 class="profile-card-title">
          <i class="fas fa-credit-card"></i>
          Mes Paiements
        </h2>
        <?php if (empty($settlements)): ?>
          <div class="empty-state">
            <p>Aucun paiement enregistré.</p>
          </div>
        <?php else: ?>
          <div class="settlements-table">
            <table>
              <thead>
                <tr>
                  <th>Facture</th>
                  <th>Montant</th>
                  <th>Méthode</th>
                  <th>Date</th>
                  <th>Statut</th>
                </tr>
              </thead>
              <tbody>
                <?php foreach ($settlements as $settlement): ?>
                  <tr>
                    <td class="settlement-invoice">
                      <?= $settlement['invoice_number'] ? htmlspecialchars($settlement['invoice_number']) : 'N/A' ?>
                    </td>
                    <td class="settlement-amount">
                      <strong><?= number_format($settlement['amount'], 2, ',', ' ') ?> €</strong>
                    </td>
                    <td class="settlement-method">
                      <?= htmlspecialchars($settlement['payment_method'] ?? 'Non spécifiée') ?>
                    </td>
                    <td class="settlement-date">
                      <?= date('d/m/Y', strtotime($settlement['payment_date'])) ?>
                    </td>
                    <td class="settlement-status">
                      <span class="status-badge status-<?= htmlspecialchars($settlement['status']) ?>">
                        <?= htmlspecialchars($settlement['status']) ?>
                      </span>
                    </td>
                  </tr>
                <?php endforeach; ?>
              </tbody>
            </table>
          </div>
        <?php endif; ?>
      </div>

      <!-- Bonuses Section -->
      <div class="profile-card">
        <h2 class="profile-card-title">
          <i class="fas fa-star"></i>
          Mes Bonus & Points
        </h2>
        <?php 
          $totalPoints = 0;
          foreach ($bonuses as $bonus) {
            $totalPoints += $bonus['points'];
          }
        ?>
        <div class="bonus-summary">
          <div class="bonus-total">
            <div class="bonus-points">
              <span class="bonus-points-number"><?= $totalPoints ?></span>
              <span class="bonus-points-label">Points</span>
            </div>
          </div>
        </div>

        <?php if (empty($bonuses)): ?>
          <div class="empty-state">
            <p>Aucun bonus pour le moment. Faites vos premiers achats pour accumuler des points !</p>
          </div>
        <?php else: ?>
          <div class="bonuses-list">
            <?php foreach ($bonuses as $bonus): ?>
              <div class="bonus-item">
                <div class="bonus-icon">
                  <i class="fas fa-gift"></i>
                </div>
                <div class="bonus-details">
                  <p class="bonus-description"><?= htmlspecialchars($bonus['bonus_description']) ?></p>
                  <p class="bonus-date"><?= date('d/m/Y', strtotime($bonus['created_at'])) ?></p>
                </div>
                <div class="bonus-points-badge">
                  <strong>+<?= $bonus['points'] ?></strong>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <!-- Quick Actions -->
      <div class="profile-actions">
        <a href="/?page=order&action=history" class="btn-primary">
          <i class="fas fa-history"></i>
          Mes Commandes
        </a>
        <a href="/?page=product&action=list" class="btn-secondary">
          <i class="fas fa-shopping-bag"></i>
          Continuer les Achats
        </a>
      </div>
    </div>
  </div>
</section>

<style>
  .profile-section {
    padding: var(--space-3xl) 0;
    background: var(--gray-50);
    min-height: 100vh;
  }

  .profile-header {
    text-align: center;
    margin-bottom: var(--space-3xl);
    background: var(--primary-white);
    padding: var(--space-3xl);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-md);
  }

  .profile-title {
    font-size: var(--font-size-4xl);
    margin-bottom: var(--space-lg);
    color: var(--primary-black);
    font-weight: 900;
  }

  .profile-title i {
    color: var(--accent-red);
    margin-right: var(--space-md);
  }

  .profile-info {
    border-top: 2px solid var(--gray-200);
    padding-top: var(--space-lg);
  }

  .profile-name {
    font-size: var(--font-size-2xl);
    color: var(--primary-black);
    margin-bottom: var(--space-md);
    font-weight: 700;
  }

  .profile-email {
    color: var(--gray-600);
    font-size: var(--font-size-lg);
  }

  .profile-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-3xl);
    margin-bottom: var(--space-3xl);
  }

  .profile-card {
    background: var(--primary-white);
    padding: var(--space-3xl);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-md);
  }

  .profile-card-title {
    font-size: var(--font-size-2xl);
    margin-bottom: var(--space-2xl);
    color: var(--primary-black);
    border-bottom: 3px solid var(--accent-red);
    padding-bottom: var(--space-lg);
    font-weight: 700;
  }

  .profile-card-title i {
    color: var(--accent-red);
    margin-right: var(--space-md);
  }

  .empty-state {
    text-align: center;
    padding: var(--space-3xl);
    color: var(--gray-500);
    background: var(--gray-100);
    border-radius: var(--radius-lg);
  }

  .invoices-table,
  .settlements-table {
    overflow-x: auto;
  }

  table {
    width: 100%;
    border-collapse: collapse;
  }

  table thead {
    background: var(--gray-100);
  }

  table th {
    padding: var(--space-lg);
    text-align: left;
    font-weight: 700;
    color: var(--primary-black);
    border-bottom: 2px solid var(--gray-200);
  }

  table td {
    padding: var(--space-lg);
    border-bottom: 1px solid var(--gray-200);
  }

  table tbody tr:hover {
    background: var(--gray-50);
  }

  .badge {
    display: inline-block;
    background: var(--gray-100);
    color: var(--accent-red);
    padding: var(--space-sm) var(--space-md);
    border-radius: var(--radius-full);
    font-weight: 600;
    font-size: var(--font-size-sm);
  }

  .status-badge {
    display: inline-block;
    padding: var(--space-sm) var(--space-md);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
    text-transform: uppercase;
  }

  .status-pending {
    background: #fef3c7;
    color: #92400e;
  }

  .status-paid,
  .status-completed {
    background: #dcfce7;
    color: #15803d;
  }

  .status-shipped {
    background: #dbeafe;
    color: #1e40af;
  }

  .status-failed,
  .status-cancelled {
    background: #fee2e2;
    color: #991b1b;
  }

  .bonus-summary {
    margin-bottom: var(--space-2xl);
  }

  .bonus-total {
    background: linear-gradient(135deg, var(--accent-red) 0%, #991b1b 100%);
    color: var(--primary-white);
    padding: var(--space-3xl);
    border-radius: var(--radius-2xl);
    text-align: center;
  }

  .bonus-points {
    display: flex;
    flex-direction: column;
    align-items: center;
  }

  .bonus-points-number {
    font-size: 3rem;
    font-weight: 900;
    display: block;
  }

  .bonus-points-label {
    font-size: var(--font-size-lg);
    margin-top: var(--space-md);
    opacity: 0.9;
  }

  .bonuses-list {
    display: grid;
    gap: var(--space-lg);
  }

  .bonus-item {
    display: flex;
    align-items: center;
    padding: var(--space-lg);
    background: var(--gray-100);
    border-radius: var(--radius-lg);
    border-left: 4px solid var(--accent-red);
  }

  .bonus-icon {
    font-size: 1.8rem;
    color: var(--accent-red);
    margin-right: var(--space-lg);
  }

  .bonus-details {
    flex: 1;
  }

  .bonus-description {
    margin: 0 0 var(--space-sm) 0;
    font-weight: 600;
    color: var(--primary-black);
  }

  .bonus-date {
    margin: 0;
    color: var(--gray-500);
    font-size: var(--font-size-sm);
  }

  .bonus-points-badge {
    background: var(--accent-red);
    color: var(--primary-white);
    padding: var(--space-md) var(--space-lg);
    border-radius: var(--radius-md);
    font-size: var(--font-size-lg);
    margin-left: var(--space-lg);
    font-weight: 700;
  }

  .profile-actions {
    display: flex;
    gap: var(--space-lg);
    justify-content: center;
    flex-wrap: wrap;
  }

  .btn-primary,
  .btn-secondary {
    padding: var(--space-md) var(--space-2xl);
    border-radius: var(--radius-lg);
    text-decoration: none;
    font-weight: 700;
    display: inline-flex;
    align-items: center;
    gap: var(--space-md);
    transition: all var(--transition-normal);
  }

  .btn-primary {
    background: var(--accent-red);
    color: var(--primary-white);
  }

  .btn-primary:hover {
    background: #b91c1c;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .btn-secondary {
    background: var(--gray-700);
    color: var(--primary-white);
  }

  .btn-secondary:hover {
    background: var(--gray-800);
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .btn-sm {
    padding: var(--space-sm) var(--space-lg);
    font-size: var(--font-size-sm);
  }

  .orders-list {
    display: grid;
    gap: var(--space-2xl);
  }

  .order-card {
    background: var(--gray-50);
    border-radius: var(--radius-lg);
    padding: var(--space-2xl);
    border: 1px solid var(--gray-200);
  }

  .order-header {
    display: flex;
    justify-content: space-between;
    align-items: flex-start;
    margin-bottom: var(--space-lg);
  }

  .order-info h3 {
    margin: 0 0 var(--space-sm) 0;
    color: var(--primary-black);
    font-size: var(--font-size-xl);
  }

  .order-date,
  .order-status {
    margin: var(--space-xs) 0;
    color: var(--gray-600);
    font-size: var(--font-size-sm);
  }

  .order-total {
    text-align: right;
  }

  .order-details {
    display: grid;
    gap: var(--space-lg);
  }

  .delivery-info,
  .tracking-info,
  .order-items,
  .invoice-actions {
    background: var(--primary-white);
    padding: var(--space-lg);
    border-radius: var(--radius-md);
    border-left: 4px solid var(--accent-red);
  }

  .delivery-info h4,
  .tracking-info h4,
  .order-items h4,
  .invoice-actions h4 {
    margin: 0 0 var(--space-md) 0;
    color: var(--primary-black);
    font-size: var(--font-size-lg);
    font-weight: 600;
  }

  .delivery-info h4 i,
  .tracking-info h4 i,
  .invoice-actions h4 i {
    color: var(--accent-red);
    margin-right: var(--space-sm);
  }

  .order-items ul {
    list-style: none;
    padding: 0;
    margin: 0;
  }

  .order-items li {
    padding: var(--space-sm) 0;
    border-bottom: 1px solid var(--gray-100);
    color: var(--gray-700);
  }

  .action-buttons {
    display: flex;
    gap: var(--space-md);
    margin-top: var(--space-md);
  }

  @media (max-width: 768px) {
    .profile-title {
      font-size: var(--font-size-3xl);
    }

    .profile-card {
      padding: var(--space-2xl);
    }

    .bonus-item {
      flex-direction: column;
      text-align: center;
    }

    .bonus-icon {
      margin-right: 0;
      margin-bottom: var(--space-lg);
    }

    .bonus-points-badge {
      margin-left: 0;
      margin-top: var(--space-lg);
    }

    table {
      font-size: var(--font-size-sm);
    }

    table th,
    table td {
      padding: var(--space-md);
    }
  }
</style>

<?php require __DIR__ . '/../layout/footer.php'; ?>
