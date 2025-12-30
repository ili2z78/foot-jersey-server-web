<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="order-detail-section">
  <div class="container">
    <div class="order-detail-header">
      <a href="/?page=order&action=history" class="back-link">
        <i class="fas fa-arrow-left"></i> Retour à mes commandes
      </a>
      <h1 class="order-title">Commande #<?= htmlspecialchars($order['id']) ?></h1>
    </div>

    <div class="order-detail-content">
      <div class="order-summary-card">
        <div class="summary-header">
          <h2 class="summary-title">Résumé de la Commande</h2>
          <span class="order-status-badge status-<?= htmlspecialchars($order['status']) ?>">
            <?= htmlspecialchars($order['status']) ?>
          </span>
        </div>

        <div class="summary-details">
          <div class="detail-item">
            <span class="detail-label">
              <i class="fas fa-calendar"></i> Date de commande
            </span>
            <span class="detail-value">
              <?= date('d/m/Y H:i', strtotime($order['created_at'])) ?>
            </span>
          </div>

          <div class="detail-item">
            <span class="detail-label">
              <i class="fas fa-tag"></i> Statut
            </span>
            <span class="detail-value">
              <span class="status-badge status-<?= htmlspecialchars($order['status']) ?>">
                <?= htmlspecialchars($order['status']) ?>
              </span>
            </span>
          </div>

          <div class="detail-item total-item">
            <span class="detail-label">
              <i class="fas fa-euro-sign"></i> Montant Total
            </span>
            <span class="detail-value total-value">
              <?= number_format($order['total'], 2, ',', ' ') ?> €
            </span>
          </div>
        </div>
      </div>

      <div class="order-items-card">
        <h2 class="items-title">Articles Commandés</h2>
        <?php if (empty($items)): ?>
          <div class="empty-items">
            <p>Aucun article dans cette commande.</p>
          </div>
        <?php else: ?>
          <div class="items-list">
            <?php foreach($items as $it): ?>
              <div class="order-item">
                <div class="item-image">
                  <img src="/assets/images/<?= htmlspecialchars($it['image']) ?>" alt="<?= htmlspecialchars($it['name']) ?>">
                </div>
                <div class="item-details">
                  <h3 class="item-name"><?= htmlspecialchars($it['name']) ?></h3>
                </div>
                <div class="item-quantity">
                  <span class="qty-label">Quantité</span>
                  <span class="qty-value"><?= $it['quantity'] ?></span>
                </div>
                <div class="item-price">
                  <span class="price-label">Prix unitaire</span>
                  <span class="price-value"><?= number_format($it['price'], 2, ',', ' ') ?> €</span>
                </div>
                <div class="item-subtotal">
                  <span class="subtotal-label">Sous-total</span>
                  <span class="subtotal-value">
                    <?= number_format($it['price'] * $it['quantity'], 2, ',', ' ') ?> €
                  </span>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        <?php endif; ?>
      </div>

      <div class="order-actions">
        <a href="/?page=product&action=list" class="btn-primary">
          <i class="fas fa-shopping-bag"></i> Continuer les Achats
        </a>
        <a href="/?page=order&action=history" class="btn-secondary">
          <i class="fas fa-list"></i> Voir toutes les Commandes
        </a>
      </div>
    </div>
  </div>
</section>

<style>
  .order-detail-section {
    padding: var(--space-3xl) 0;
    background: var(--gray-50);
    min-height: 100vh;
  }

  .order-detail-header {
    margin-bottom: var(--space-2xl);
  }

  .back-link {
    display: inline-flex;
    align-items: center;
    gap: var(--space-sm);
    color: var(--accent-red);
    text-decoration: none;
    margin-bottom: var(--space-lg);
    font-weight: 600;
    transition: all var(--transition-normal);
  }

  .back-link:hover {
    color: #b91c1c;
    transform: translateX(-5px);
  }

  .order-title {
    font-size: var(--font-size-4xl);
    color: var(--primary-black);
    margin: 0;
    font-weight: 900;
  }

  .order-detail-content {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-3xl);
  }

  .order-summary-card,
  .order-items-card {
    background: var(--primary-white);
    padding: var(--space-3xl);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-md);
  }

  .summary-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: var(--space-2xl);
    padding-bottom: var(--space-lg);
    border-bottom: 2px solid var(--gray-200);
  }

  .summary-title {
    font-size: var(--font-size-2xl);
    margin: 0;
    color: var(--primary-black);
    font-weight: 700;
  }

  .order-status-badge {
    display: inline-block;
    padding: var(--space-sm) var(--space-lg);
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

  .status-cancelled {
    background: #fee2e2;
    color: #991b1b;
  }

  .summary-details {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
    gap: var(--space-lg);
  }

  .detail-item {
    padding: var(--space-lg);
    background: var(--gray-100);
    border-radius: var(--radius-lg);
  }

  .detail-label {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    color: var(--gray-600);
    font-weight: 600;
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-sm);
  }

  .detail-label i {
    color: var(--accent-red);
  }

  .detail-value {
    display: block;
    font-size: var(--font-size-lg);
    color: var(--primary-black);
    font-weight: 700;
  }

  .total-item {
    background: linear-gradient(135deg, var(--accent-red) 0%, #991b1b 100%);
    color: var(--primary-white);
  }

  .total-item .detail-label {
    color: rgba(255, 255, 255, 0.9);
  }

  .total-value {
    color: var(--primary-white);
    font-size: var(--font-size-3xl);
    font-weight: 900;
  }

  .items-title {
    font-size: var(--font-size-2xl);
    margin: 0 0 var(--space-2xl) 0;
    color: var(--primary-black);
    padding-bottom: var(--space-lg);
    border-bottom: 2px solid var(--gray-200);
    font-weight: 700;
  }

  .empty-items {
    text-align: center;
    padding: var(--space-3xl);
    color: var(--gray-500);
    background: var(--gray-100);
    border-radius: var(--radius-lg);
  }

  .items-list {
    display: flex;
    flex-direction: column;
    gap: var(--space-lg);
  }

  .order-item {
    display: grid;
    grid-template-columns: 120px 1fr auto auto auto;
    gap: var(--space-lg);
    align-items: center;
    padding: var(--space-lg);
    background: var(--gray-100);
    border-radius: var(--radius-lg);
    border-left: 4px solid var(--accent-red);
    transition: all var(--transition-normal);
  }

  .order-item:hover {
    background: var(--gray-100);
    transform: translateX(5px);
  }

  .item-image {
    width: 120px;
    height: 120px;
    border-radius: var(--radius-lg);
    overflow: hidden;
  }

  .item-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
  }

  .item-details {
    flex: 1;
  }

  .item-name {
    margin: 0;
    font-size: var(--font-size-lg);
    color: var(--primary-black);
    font-weight: 700;
  }

  .item-quantity,
  .item-price,
  .item-subtotal {
    text-align: center;
  }

  .qty-label,
  .price-label,
  .subtotal-label {
    display: block;
    font-size: var(--font-size-sm);
    color: var(--gray-600);
    margin-bottom: var(--space-sm);
    font-weight: 600;
  }

  .qty-value,
  .price-value,
  .subtotal-value {
    display: block;
    font-size: var(--font-size-lg);
    font-weight: 700;
    color: var(--primary-black);
  }

  .subtotal-value {
    color: var(--accent-red);
  }

  .order-actions {
    display: flex;
    gap: var(--space-lg);
    justify-content: center;
    flex-wrap: wrap;
    padding-top: var(--space-lg);
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

  .status-badge {
    display: inline-block;
    padding: var(--space-sm) var(--space-md);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
    text-transform: uppercase;
  }

  @media (max-width: 1024px) {
    .order-item {
      grid-template-columns: 100px 1fr auto;
    }

    .item-quantity,
    .item-price {
      display: none;
    }

    .item-image {
      width: 100px;
      height: 100px;
    }
  }

  @media (max-width: 768px) {
    .order-title {
      font-size: var(--font-size-3xl);
    }

    .summary-details {
      grid-template-columns: 1fr;
    }

    .order-item {
      grid-template-columns: 80px 1fr;
      gap: var(--space-md);
    }

    .item-quantity,
    .item-price,
    .item-subtotal {
      display: none;
    }

    .item-image {
      width: 80px;
      height: 80px;
    }

    .order-actions {
      flex-direction: column;
    }

    .btn-primary,
    .btn-secondary {
      width: 100%;
      justify-content: center;
    }
  }
</style>

<?php require __DIR__ . '/../layout/footer.php'; ?>
