<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="order-history-section">
  <div class="container">
    <div class="history-header">
      <h1 class="history-title">
        <i class="fas fa-history"></i>
        Mes Commandes
      </h1>
      <p class="history-subtitle">Historique complet de vos achats</p>
    </div>

    <div class="history-content">
      <?php if (empty($orders)): ?>
        <div class="empty-orders">
          <div class="empty-orders-icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <h2>Aucune commande pour l'instant</h2>
          <p>Commencez votre shopping dès maintenant pour voir vos commandes apparaître ici.</p>
          <a href="/?page=product&action=list" class="btn-primary">
            <i class="fas fa-shopping-bag"></i>
            Découvrir le Catalogue
          </a>
        </div>
      <?php else: ?>
        <div class="orders-list">
          <?php foreach($orders as $o): ?>
            <div class="order-card" data-status="<?= htmlspecialchars($o['status']) ?>">
              <div class="order-card-header">
                <div class="order-id-section">
                  <h3 class="order-id">Commande #<?= $o['id'] ?></h3>
                  <span class="order-status status-<?= htmlspecialchars($o['status']) ?>">
                    <?= htmlspecialchars($o['status']) ?>
                  </span>
                </div>
                <a href="?page=order&action=view&id=<?= $o['id'] ?>" class="view-details-btn">
                  <i class="fas fa-arrow-right"></i>
                  Voir détails
                </a>
              </div>

              <div class="order-card-body">
                <div class="order-info">
                  <div class="info-item">
                    <span class="info-label">
                      <i class="fas fa-calendar"></i> Date
                    </span>
                    <span class="info-value">
                      <?= date('d/m/Y H:i', strtotime($o['created_at'])) ?>
                    </span>
                  </div>
                  <div class="info-item">
                    <span class="info-label">
                      <i class="fas fa-tag"></i> Statut
                    </span>
                    <span class="info-value">
                      <span class="status-badge status-<?= htmlspecialchars($o['status']) ?>">
                        <?= htmlspecialchars($o['status']) ?>
                      </span>
                    </span>
                  </div>
                  <div class="info-item total">
                    <span class="info-label">
                      <i class="fas fa-euro-sign"></i> Total
                    </span>
                    <span class="info-value total-value">
                      <?= number_format($o['total'],2,',',' ') ?> €
                    </span>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </div>
  </div>
</section>

<style>
  .order-history-section {
    padding: var(--space-3xl) 0;
    background: var(--gray-50);
    min-height: 100vh;
  }

  .history-header {
    text-align: center;
    margin-bottom: var(--space-3xl);
  }

  .history-title {
    font-size: var(--font-size-4xl);
    color: var(--primary-black);
    margin: 0 0 var(--space-md) 0;
    font-weight: 900;
  }

  .history-title i {
    color: var(--accent-red);
    margin-right: var(--space-md);
  }

  .history-subtitle {
    font-size: var(--font-size-lg);
    color: var(--gray-600);
    margin: 0;
  }

  .history-content {
    display: flex;
    flex-direction: column;
  }

  .empty-orders {
    background: var(--primary-white);
    padding: 4rem 2.5rem;
    border-radius: var(--radius-2xl);
    text-align: center;
    box-shadow: var(--shadow-md);
  }

  .empty-orders-icon {
    font-size: 4rem;
    color: var(--gray-300);
    margin-bottom: var(--space-lg);
  }

  .empty-orders h2 {
    font-size: var(--font-size-3xl);
    color: var(--primary-black);
    margin: 0 0 var(--space-md) 0;
    font-weight: 700;
  }

  .empty-orders p {
    color: var(--gray-600);
    margin: 0 0 var(--space-2xl) 0;
    font-size: var(--font-size-lg);
  }

  .btn-primary {
    display: inline-flex;
    align-items: center;
    gap: var(--space-md);
    padding: var(--space-md) var(--space-2xl);
    background: var(--accent-red);
    color: var(--primary-white);
    text-decoration: none;
    border-radius: var(--radius-lg);
    font-weight: 700;
    transition: all var(--transition-normal);
  }

  .btn-primary:hover {
    background: #b91c1c;
    transform: translateY(-2px);
    box-shadow: var(--shadow-lg);
  }

  .orders-list {
    display: grid;
    grid-template-columns: 1fr;
    gap: var(--space-lg);
  }

  .order-card {
    background: var(--primary-white);
    border-radius: var(--radius-2xl);
    box-shadow: var(--shadow-md);
    transition: all var(--transition-normal);
    overflow: hidden;
  }

  .order-card:hover {
    box-shadow: var(--shadow-lg);
    transform: translateY(-2px);
  }

  .order-card-header {
    padding: var(--space-2xl);
    background: var(--gray-100);
    border-bottom: 1px solid var(--gray-200);
    display: flex;
    justify-content: space-between;
    align-items: center;
  }

  .order-id-section {
    display: flex;
    align-items: center;
    gap: var(--space-lg);
  }

  .order-id {
    margin: 0;
    font-size: var(--font-size-xl);
    color: var(--primary-black);
    font-weight: 700;
  }

  .order-status {
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

  .status-cancelled {
    background: #fee2e2;
    color: #991b1b;
  }

  .view-details-btn {
    display: inline-flex;
    align-items: center;
    gap: var(--space-sm);
    padding: var(--space-sm) var(--space-lg);
    background: var(--accent-red);
    color: var(--primary-white);
    text-decoration: none;
    border-radius: var(--radius-lg);
    font-weight: 600;
    transition: all var(--transition-normal);
  }

  .view-details-btn:hover {
    background: #b91c1c;
    transform: translateX(3px);
  }

  .order-card-body {
    padding: var(--space-2xl);
  }

  .order-info {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
    gap: var(--space-lg);
  }

  .info-item {
    display: flex;
    flex-direction: column;
  }

  .info-label {
    display: flex;
    align-items: center;
    gap: var(--space-sm);
    color: var(--gray-600);
    font-size: var(--font-size-sm);
    margin-bottom: var(--space-sm);
    font-weight: 600;
  }

  .info-label i {
    color: var(--accent-red);
  }

  .info-value {
    font-size: var(--font-size-lg);
    color: var(--primary-black);
    font-weight: 700;
  }

  .total {
    padding: var(--space-lg);
    background: linear-gradient(135deg, var(--accent-red) 0%, #991b1b 100%);
    border-radius: var(--radius-lg);
    color: var(--primary-white);
  }

  .total .info-label {
    color: rgba(255, 255, 255, 0.9);
  }

  .total-value {
    color: var(--primary-white);
    font-size: var(--font-size-2xl);
    font-weight: 900;
  }

  .status-badge {
    display: inline-block;
    padding: var(--space-sm) var(--space-md);
    border-radius: var(--radius-md);
    font-size: var(--font-size-xs);
    font-weight: 700;
    text-transform: uppercase;
  }

  @media (max-width: 768px) {
    .history-title {
      font-size: var(--font-size-3xl);
    }

    .order-card-header {
      flex-direction: column;
      gap: var(--space-lg);
      align-items: flex-start;
    }

    .order-id-section {
      flex-direction: column;
      gap: var(--space-md);
      width: 100%;
    }

    .view-details-btn {
      width: 100%;
      justify-content: center;
    }

    .order-info {
      grid-template-columns: 1fr;
    }

    .empty-orders {
      padding: 2.5rem 1.25rem;
    }

    .empty-orders-icon {
      font-size: 3rem;
    }

    .empty-orders h2 {
      font-size: var(--font-size-2xl);
    }
  }
</style>

<?php require __DIR__ . '/../layout/footer.php'; ?>
