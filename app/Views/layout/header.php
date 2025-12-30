<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width,initial-scale=1">
  <title>FootJersey - Maillots de Football Officiels</title>
  <meta name="description" content="Découvrez notre collection de maillots de football officiels. PSG, Real Madrid et bien plus. Livraison rapide et qualité garantie.">
  <link rel="stylesheet" href="/assets/css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;900&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
  <link rel="icon" type="image/x-icon" href="/assets/images/favicon.ico">
</head>
<body>
  <!-- Skip link for accessibility -->
  <a href="#main-content" class="skip-link">Aller au contenu principal</a>

  <header class="site-header">
    <div class="container">
      <div class="header-content">
        <!-- Brand -->
        <a href="/?page=home&action=index" class="brand">
          <i class="fas fa-futbol"></i>
          FootJersey
        </a>

        <!-- Desktop Navigation -->
        <nav class="main-nav">
          <a href="/?page=product&action=list" class="nav-link">
            <i class="fas fa-store"></i>
            Catalogue
          </a>
          <a href="/?page=cart&action=view" class="nav-link">
            <i class="fas fa-shopping-cart"></i>
            Panier
            <?php if(isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
              <span class="cart-count">(<?= $_SESSION['cart_count'] ?>)</span>
            <?php endif; ?>
          </a>
          <?php if(isset($_SESSION['user'])): ?>
            <a href="/?page=profile&action=index" class="nav-link">
              <i class="fas fa-user-circle"></i>
              Mon Profil
            </a>
            <a href="/?page=order&action=history" class="nav-link">
              <i class="fas fa-history"></i>
              Mes commandes
            </a>
            <div class="user-menu">
              <span class="user-greeting">
                <i class="fas fa-user"></i>
                Bonjour <?= htmlspecialchars($_SESSION['user']['fullname'] ?: $_SESSION['user']['email']) ?>
              </span>
              <a href="/?page=auth&action=logout" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
              </a>
            </div>
          <?php else: ?>
            <a href="/?page=auth&action=login" class="nav-link">
              <i class="fas fa-sign-in-alt"></i>
              Connexion
            </a>
            <a href="/?page=auth&action=register" class="btn-primary">
              <i class="fas fa-user-plus"></i>
              Inscription
            </a>
          <?php endif; ?>
        </nav>

        <!-- Search Bar -->
        <div class="header-search">
          <input type="text" class="search-input" placeholder="Rechercher des maillots..." id="search-input" autocomplete="off">
          <button type="button" class="search-btn" id="search-btn">
            <i class="fas fa-search"></i>
          </button>
        </div>

        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" id="mobile-menu-toggle" aria-label="Menu">
          <i class="fas fa-bars"></i>
        </button>
      </div>

      <!-- Mobile Navigation Menu -->
      <div class="mobile-menu" id="mobile-menu">
        <nav class="mobile-nav">
          <a href="/?page=product&action=list" class="mobile-nav-link">
            <i class="fas fa-store"></i>
            Catalogue
          </a>
          <a href="/?page=cart&action=view" class="mobile-nav-link">
            <i class="fas fa-shopping-cart"></i>
            Panier
            <?php if(isset($_SESSION['cart_count']) && $_SESSION['cart_count'] > 0): ?>
              <span class="cart-count">(<?= $_SESSION['cart_count'] ?>)</span>
            <?php endif; ?>
          </a>
          <?php if(isset($_SESSION['user'])): ?>
            <a href="/?page=profile&action=index" class="mobile-nav-link">
              <i class="fas fa-user-circle"></i>
              Mon Profil
            </a>
            <a href="/?page=order&action=history" class="mobile-nav-link">
              <i class="fas fa-history"></i>
              Mes commandes
            </a>
            <div class="mobile-user-menu">
              <span class="mobile-user-greeting">
                <i class="fas fa-user"></i>
                <?= htmlspecialchars($_SESSION['user']['fullname'] ?: $_SESSION['user']['email']) ?>
              </span>
              <a href="/?page=auth&action=logout" class="mobile-logout-btn">
                <i class="fas fa-sign-out-alt"></i>
                Déconnexion
              </a>
            </div>
          <?php else: ?>
            <a href="/?page=auth&action=login" class="mobile-nav-link">
              <i class="fas fa-sign-in-alt"></i>
              Connexion
            </a>
            <a href="/?page=auth&action=register" class="mobile-register-btn">
              <i class="fas fa-user-plus"></i>
              Inscription
            </a>
          <?php endif; ?>
        </nav>
      </div>
    </div>
  </header>

  <main id="main-content" class="container">
    <script src="/assets/js/app.js" defer></script>
