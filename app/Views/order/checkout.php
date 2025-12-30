<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="checkout-section">
  <div class="container">
    <div class="checkout-header">
      <h1 class="checkout-title">
        <i class="fas fa-lock"></i>
        Finaliser la Commande
      </h1>
      <p class="checkout-subtitle">Vérifiez vos articles avant de passer au paiement</p>
    </div>

    <?php if(!empty($error)): ?>
      <div class="alert alert-error">
        <i class="fas fa-exclamation-circle"></i>
        <?= htmlspecialchars($error) ?>
      </div>
    <?php endif; ?>

    <?php if (empty($items)): ?>
      <div class="empty-checkout-container">
        <div class="empty-checkout-content">
          <div class="empty-cart-icon">
            <i class="fas fa-shopping-cart"></i>
          </div>
          <h2>Votre panier est vide</h2>
          <p>Vous devez ajouter des articles avant de finaliser votre commande</p>
          <a href="/?page=product&action=list" class="btn-primary btn-xl">
            <i class="fas fa-shopping-bag"></i>
            Retour au catalogue
          </a>
        </div>
      </div>
    <?php else: ?>

      <div class="checkout-content">
        <div class="checkout-items">
          <h2 class="checkout-section-title">
            <i class="fas fa-shopping-bag"></i>
            Articles (<?= count($items) ?>)
          </h2>
          
          <div class="checkout-items-list">
            <?php foreach($items as $it): ?>
              <div class="checkout-item">
                <div class="checkout-item-image">
                  <img src="/assets/images/<?= htmlspecialchars($it['image']) ?>" alt="<?= htmlspecialchars($it['name']) ?>">
                </div>
                
                <div class="checkout-item-details">
                  <h3 class="checkout-item-name"><?= htmlspecialchars($it['name']) ?></h3>
                  <p class="checkout-item-qty">Quantité : <span class="qty-value"><?= $it['quantity'] ?></span></p>
                </div>
                
                <div class="checkout-item-pricing">
                  <div class="item-price-row">
                    <span class="label">Prix unitaire</span>
                    <span class="price"><?= number_format($it['price'],2,',',' ') ?> €</span>
                  </div>
                  <div class="item-subtotal-row">
                    <span class="label">Sous-total</span>
                    <span class="subtotal"><?= number_format($it['line_total'],2,',',' ') ?> €</span>
                  </div>
                </div>
              </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="checkout-summary">
          <div class="summary-card">
            <h2 class="summary-title">
              <i class="fas fa-receipt"></i>
              Résumé de la Commande
            </h2>

            <div class="summary-breakdown">
              <div class="summary-row">
                <span class="summary-label">Sous-total</span>
                <span class="summary-value"><?= number_format($total,2,',',' ') ?> €</span>
              </div>
              <div class="summary-row">
                <span class="summary-label">Frais de port</span>
                <span class="summary-value">Gratuit</span>
              </div>
            </div>

            <div class="summary-divider"></div>

            <div class="summary-total">
              <span class="total-label">Total</span>
              <span class="total-amount"><?= number_format($total,2,',',' ') ?> €</span>
            </div>

            <div class="security-badge">
              <i class="fas fa-shield-alt"></i>
              Paiement 100% sécurisé
            </div>

            <form method="post" action="?page=order&action=checkout" class="checkout-form">
              <p class="payment-info">
                <i class="fas fa-info-circle"></i>
                Cliquez sur le bouton ci-dessous pour simuler le paiement et finaliser votre commande.
              </p>
              <button type="submit" class="btn-primary btn-xl btn-pay">
                <i class="fas fa-credit-card"></i>
                Payer (mode test)
              </button>
            </form>

            <div class="payment-methods-info">
              <p class="methods-label">Moyens de paiement acceptés :</p>
              <div class="methods-icons">
                <i class="fab fa-cc-visa" title="Visa"></i>
                <i class="fab fa-cc-mastercard" title="Mastercard"></i>
                <i class="fab fa-cc-paypal" title="PayPal"></i>
              </div>
            </div>
          </div>

          <a href="/?page=cart&action=view" class="btn-secondary">
            <i class="fas fa-arrow-left"></i>
            Retour au Panier
          </a>
        </div>
      </div>

    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
