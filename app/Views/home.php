<?php require __DIR__ . '/layout/header.php'; ?>

<!-- Hero Section with Carousel -->
<section class="hero-section">
  <div class="hero-container">
    <img src="/assets/images/real-exterieur.jpg" alt="Maillots de Football" class="hero-image">
    <div class="hero-overlay"></div>
    <div class="hero-content">
      <h1 class="hero-title">Les Maillots Officiels</h1>
      <p class="hero-subtitle">Portez les couleurs de vos clubs préférés</p>
      <a href="/?page=product&action=list" class="btn-primary btn-xl hero-cta">
        <i class="fas fa-store"></i>
        Accéder au catalogue
      </a>
    </div>
  </div>
</section>

<!-- Trust Section -->
<section class="trust-section">
  <div class="container">
    <div class="trust-grid">
      <div class="trust-item">
        <i class="fas fa-check-circle"></i>
        <h3>Produits 100% officiels</h3>
        <p>Authentifiés et garantis</p>
      </div>
      <div class="trust-item">
        <i class="fas fa-bolt"></i>
        <h3>Livraison express</h3>
        <p>24-48h en France</p>
      </div>
      <div class="trust-item">
        <i class="fas fa-shield-alt"></i>
        <h3>Paiement sécurisé</h3>
        <p>Cryptage SSL 256-bit</p>
      </div>
      <div class="trust-item">
        <i class="fas fa-undo"></i>
        <h3>Satisfait ou remboursé</h3>
        <p>30 jours pour retourner</p>
      </div>
    </div>
  </div>
</section>

<!-- Featured Products Section -->
<section class="featured-section">
  <div class="container">
    <div class="featured-header">
      <div>
        <h2 class="featured-title">Nouveautés et Best-sellers</h2>
        <p class="featured-subtitle">Découvrez les maillots les plus demandés</p>
      </div>
      <a href="/?page=product&action=list" class="view-all-btn">
        Voir tout le catalogue
        <i class="fas fa-arrow-right"></i>
      </a>
    </div>

    <?php if (!empty($featuredProducts)) : ?>
      <div class="products-showcase">
        <?php foreach ($featuredProducts as $product) : ?>
          <div class="showcase-card">
            <div class="showcase-image-wrapper">
              <img src="/assets/images/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="showcase-image">
              <div class="showcase-overlay">
                <a href="/?page=product&action=detail&slug=<?= $product['slug'] ?>" class="showcase-btn">Voir les détails</a>
              </div>
              <span class="showcase-badge">Officiel</span>
            </div>
            <div class="showcase-content">
              <h3 class="showcase-title"><?= htmlspecialchars($product['name']) ?></h3>
              <p class="showcase-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
              <a href="/?page=cart&action=add&product_id=<?= $product['id'] ?>&quantity=1" class="btn-add-cart">
                <i class="fas fa-shopping-bag"></i>
                Ajouter au panier
              </a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    <?php endif; ?>
  </div>
</section>

<!-- Why Choose Us -->
<section class="why-section">
  <div class="container">
    <h2 class="section-title">Pourquoi nous choisir ?</h2>
    
    <div class="why-grid">
      <div class="why-card">
        <div class="why-icon">
          <i class="fas fa-crown"></i>
        </div>
        <h3>Collection complète</h3>
        <p>Les maillots de tous les grands clubs européens. PSG, Real Madrid, Manchester, Liverpool, et bien d'autres en stock permanent.</p>
      </div>

      <div class="why-card">
        <div class="why-icon">
          <i class="fas fa-tag"></i>
        </div>
        <h3>Prix compétitifs</h3>
        <p>Les meilleurs prix du marché avec des réductions régulières. Profitez de nos offres exclusives et collections en solde.</p>
      </div>

      <div class="why-card">
        <div class="why-icon">
          <i class="fas fa-users"></i>
        </div>
        <h3>Support client 24/7</h3>
        <p>Notre équipe est toujours disponible pour répondre à vos questions et vous conseiller sur votre achat.</p>
      </div>

      <div class="why-card">
        <div class="why-icon">
          <i class="fas fa-star"></i>
        </div>
        <h3>Qualité garantie</h3>
        <p>Tous nos produits sont authentiques. Garantie satisfait ou remboursé pendant 30 jours sans questions.</p>
      </div>

      <div class="why-card">
        <div class="why-icon">
          <i class="fas fa-globe"></i>
        </div>
        <h3>Livraison partout</h3>
        <p>Nous livrons rapidement en France et à l'international avec suivi de colis en temps réel.</p>
      </div>

      <div class="why-card">
        <div class="why-icon">
          <i class="fas fa-certificate"></i>
        </div>
        <h3>Authentiques certifiés</h3>
        <p>Tous nos maillots sont des produits officiels directement des marques autorisées (Nike, Adidas, Puma, etc).</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA Section -->
<section class="cta-section">
  <div class="cta-background">
    <img src="/assets/images/Psg-dommicile.jpeg" alt="Background" class="cta-bg-image">
    <div class="cta-overlay"></div>
  </div>
  <div class="container">
    <div class="cta-content">
      <h2>Prêt à porter les couleurs de votre équipe ?</h2>
      <p>Parcourez notre catalogue et trouvez le maillot idéal pour vous ou offrir en cadeau</p>
      <a href="/?page=product&action=list" class="btn-primary btn-xl">
        <i class="fas fa-shopping-bag"></i>
        Découvrir le catalogue
      </a>
    </div>
  </div>
</section>

<!-- Newsletter Section -->
<section class="newsletter-section">
  <div class="container">
    <div class="newsletter-content">
      <h2>Abonnez-vous à notre newsletter</h2>
      <p>Recevez les dernières nouveautés et offres exclusives en avant-première</p>
      <form class="newsletter-form">
        <input type="email" placeholder="Votre email" class="newsletter-input" required>
        <button type="submit" class="btn-primary">S'abonner</button>
      </form>
    </div>
  </div>
</section>

<?php require __DIR__ . '/layout/footer.php'; ?>
