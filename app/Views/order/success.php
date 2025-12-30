<?php require __DIR__ . '/../layout/header.php'; ?>

<section class="order-success-section">
  <div class="container">
    <div class="success-content">
      <div class="success-icon-wrapper">
        <div class="success-icon">
          <i class="fas fa-check-circle"></i>
        </div>
      </div>

      <h1 class="success-title">Commande Confirmée !</h1>
      <p class="success-message">Merci de votre achat. Votre commande a bien été enregistrée et est en cours de traitement.</p>

      <div class="success-card">
        <div class="success-details">
          <div class="detail-row">
            <span class="detail-label">
              <i class="fas fa-hashtag"></i> Numéro de Commande
            </span>
            <span class="detail-value order-id"><?= htmlspecialchars($_GET['id'] ?? 'N/A') ?></span>
          </div>

          <div class="detail-row">
            <span class="detail-label">
              <i class="fas fa-envelope"></i> Confirmation par Email
            </span>
            <span class="detail-value">Un email de confirmation a été envoyé</span>
          </div>

          <div class="detail-row">
            <span class="detail-label">
              <i class="fas fa-truck"></i> Livraison
            </span>
            <span class="detail-value">Vous recevrez votre colis dans 2-3 jours ouvrables</span>
          </div>
        </div>
      </div>

      <div class="success-actions">
        <a href="/?page=order&action=view&id=<?= htmlspecialchars($_GET['id'] ?? '') ?>" class="btn-primary">
          <i class="fas fa-eye"></i> Voir les Détails de la Commande
        </a>
        <a href="/?page=order&action=history" class="btn-secondary">
          <i class="fas fa-list"></i> Mes Commandes
        </a>
        <a href="/?page=product&action=list" class="btn-secondary">
          <i class="fas fa-shopping-bag"></i> Continuer vos Achats
        </a>
      </div>

      <div class="success-info">
        <p>Des questions ? Consultez notre <a href="#">centre d'aide</a> ou <a href="#">contactez-nous</a>.</p>
      </div>
    </div>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
