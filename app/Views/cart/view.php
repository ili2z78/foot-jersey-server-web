<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="cart-page">
  <div class="container">
    <div class="cart-header">
      <h1 class="cart-title">Mon panier</h1>
      <p class="cart-subtitle">Vérifiez vos commandes avant de passer au paiement</p>
    </div>

    <?php if (empty($items)): ?>
      <div class="empty-cart-container">
        <div class="empty-cart-content">
          <div class="empty-cart-icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <h2>Votre panier est vide</h2>
          <p>Parcourez notre catalogue et découvrez nos superbes maillots</p>
          <a href="/?page=product&action=list" class="btn-primary btn-xl">
            <i class="fas fa-store"></i>
            Continuer vos achats
          </a>
        </div>
      </div>
    <?php else: ?>

      <div class="cart-layout">
        
        <div class="cart-items-section">
          <div class="cart-items-header">
            <h2>Vos articles (<?= count($items) ?>)</h2>
          </div>

          <form method="post" action="?page=cart&action=update" class="cart-form">
            <div class="cart-items-list">
              <?php foreach($items as $it): ?>
                <div class="cart-item">
                  <div class="cart-item-image">
                    <img src="/assets/images/<?= htmlspecialchars($it['image']) ?>" alt="<?= htmlspecialchars($it['name']) ?>">
                  </div>

                  <div class="cart-item-details">
                    <h3 class="cart-item-name"><?= htmlspecialchars($it['name']) ?></h3>
                    <p class="cart-item-sku">SKU: <?= $it['id'] ?></p>
                  </div>

                  <div class="cart-item-price-display">
                    <p class="price-label">Prix unitaire</p>
                    <p class="price-value"><?= number_format($it['price'],2,',',' ') ?> €</p>
                  </div>

                  <div class="cart-item-quantity">
                    <label for="qty-<?= $it['id'] ?>">Quantité</label>
                    <div class="quantity-input-wrapper">
                      <input type="number" id="qty-<?= $it['id'] ?>" name="quantity[<?= $it['id'] ?>]" value="<?= $it['quantity'] ?>" min="0" class="quantity-input">
                    </div>
                  </div>

                  <div class="cart-item-total">
                    <p class="total-label">Total</p>
                    <p class="total-value"><?= number_format($it['line_total'],2,',',' ') ?> €</p>
                  </div>

                  <div class="cart-item-actions">
                    <a href="?page=cart&action=remove&id=<?= $it['id'] ?>" class="btn-remove" title="Supprimer">
                      <i class="fas fa-trash-alt"></i>
                    </a>
                  </div>
                </div>
              <?php endforeach; ?>
            </div>

            <div class="cart-actions">
              <a href="/?page=product&action=list" class="btn-secondary">
                <i class="fas fa-arrow-left"></i>
                Continuer vos achats
              </a>
              <button type="submit" class="btn-secondary">
                <i class="fas fa-sync"></i>
                Mettre à jour
              </button>
            </div>
          </form>
        </div>

        
        <aside class="cart-summary">
          <div class="summary-card">
            <h3 class="summary-title">Résumé de la commande</h3>

            <div class="summary-rows">
              <div class="summary-row">
                <span>Sous-total</span>
                <span><?= number_format($total,2,',',' ') ?> €</span>
              </div>
              <div class="summary-row">
                <span>Livraison</span>
                <span class="shipping-free">Gratuit</span>
              </div>
              <div class="summary-row">
                <span>Taxes</span>
                <span>Incluses</span>
              </div>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-total">
              <span>Total</span>
              <span class="total-price"><?= number_format($total,2,',',' ') ?> €</span>
            </div>

            <a href="?page=order&action=checkout" class="btn-primary btn-checkout">
              <i class="fas fa-credit-card"></i>
              Passer au paiement
            </a>

            <div class="security-badge">
              <i class="fas fa-lock"></i>
              <span>Paiement 100% sécurisé</span>
            </div>
          </div>

          <div class="benefits-card">
            <div class="benefit-item">
              <i class="fas fa-shipping-fast"></i>
              <div>
                <p class="benefit-title">Livraison rapide</p>
                <p class="benefit-text">24-48h en France</p>
              </div>
            </div>
            <div class="benefit-item">
              <i class="fas fa-undo"></i>
              <div>
                <p class="benefit-title">Retours gratuits</p>
                <p class="benefit-text">30 jours pour retourner</p>
              </div>
            </div>
            <div class="benefit-item">
              <i class="fas fa-headset"></i>
              <div>
                <p class="benefit-title">Support 24/7</p>
                <p class="benefit-text">Toujours disponible</p>
              </div>
            </div>
          </div>
        </aside>
      </div>

    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
