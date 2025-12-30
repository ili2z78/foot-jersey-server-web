<?php require __DIR__ . '/../layout/header.php'; ?>

<!-- Catalogue Header -->
<section class="catalogue-hero">
  <div class="catalogue-hero-overlay"></div>
  <div class="container">
    <div class="catalogue-hero-content">
      <h1 class="catalogue-hero-title">Catalogue Complet</h1>
      <p class="catalogue-hero-subtitle">Découvrez notre collection complète de maillots officiels</p>
    </div>
  </div>
</section>

<!-- Filters & Search -->
<section class="filters-section">
  <div class="container">
    <div class="filters-header">
      <div class="search-bar-wrapper">
        <div class="search-input-group">
          <i class="fas fa-search search-icon"></i>
          <input type="text" id="search-input" placeholder="Rechercher un maillot..." class="search-input" value="<?= htmlspecialchars($q ?? '') ?>">
          <button type="button" id="search-btn" class="search-btn">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>

      <div class="filters-compact">
        <div class="filter-group">
          <label for="category-filter" class="filter-label">
            <i class="fas fa-filter"></i>
            Catégorie
          </label>
          <select id="category-filter" class="filter-select">
            <option value="">Toutes les catégories</option>
            <?php foreach ($categories ?? [] as $cat) : ?>
              <option value="<?= $cat['slug'] ?>" <?= ($category ?? '') === $cat['slug'] ? 'selected' : '' ?>>
                <?= htmlspecialchars($cat['name']) ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <div class="filter-group">
          <label for="sort-filter" class="filter-label">
            <i class="fas fa-sort"></i>
            Trier
          </label>
          <select id="sort-filter" class="filter-select">
            <option value="name" <?= ($sort ?? 'name') === 'name' ? 'selected' : '' ?>>Nom (A-Z)</option>
            <option value="price-low" <?= ($sort ?? 'name') === 'price-low' ? 'selected' : '' ?>>Prix croissant</option>
            <option value="price-high" <?= ($sort ?? 'name') === 'price-high' ? 'selected' : '' ?>>Prix décroissant</option>
            <option value="newest" <?= ($sort ?? 'name') === 'newest' ? 'selected' : '' ?>>Plus récent</option>
          </select>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- Products Section -->
<section class="products-section">
  <div class="container">
      <div class="products-header">
      <h2 class="section-title">
        <?php if (!empty($q)) : ?>
          <i class="fas fa-search"></i> Résultats pour "<?= htmlspecialchars($q) ?>"
        <?php elseif (!empty($category)) : ?>
          <i class="fas fa-tag"></i> Catégorie: <?= htmlspecialchars($categories[array_search($category, array_column($categories, 'slug'))]['name'] ?? $category) ?>
        <?php else : ?>
          <i class="fas fa-star"></i> Tous nos produits
        <?php endif; ?>
      </h2>
      <p class="products-count">
        <?php if (isset($total)) : ?>
          <i class="fas fa-list"></i> <?= count($products) ?> produit<?= count($products) > 1 ? 's' : '' ?> sur <?= $total ?>
        <?php endif; ?>
      </p>
    </div>

    <?php if (empty($products)) : ?>
      <div class="no-products">
        <div class="no-products-content">
          <i class="fas fa-search no-products-icon"></i>
          <h3>Aucun produit trouvé</h3>
          <p>Essayez de modifier vos critères de recherche.</p>
          <a href="?page=product&action=list" class="btn-primary">Voir tous les produits</a>
        </div>
      </div>
    <?php else : ?>
      <div class="products-grid" id="products-grid">
        <?php foreach ($products as $product) : ?>
          <div class="product-card" data-category="<?= $product['category_id'] ?? '' ?>" data-price="<?= $product['price'] ?>">
            <div class="product-image-container">
              <img src="/assets/images/<?= $product['image'] ?>" alt="<?= htmlspecialchars($product['name']) ?>" class="product-image">
              <span class="product-badge">Officiel</span>
            </div>
            <div class="product-content">
              <h3 class="product-title"><?= htmlspecialchars($product['name']) ?></h3>
              <p class="product-price"><?= number_format($product['price'], 2, ',', ' ') ?> €</p>
              <div class="product-actions">
                <a href="?page=product&action=detail&slug=<?= $product['slug'] ?>" class="btn-primary">
                  <i class="fas fa-eye"></i>
                  Voir détails
                </a>
                <a href="?page=cart&action=add&id=<?= $product['id'] ?>&quantity=1" class="btn-secondary">
                  <i class="fas fa-cart-plus"></i>
                  Ajouter
                </a>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Pagination -->
      <?php if (isset($totalPages) && $totalPages > 1) : ?>
      <div class="pagination">
          <?php if ($pageNum > 1) : ?>
            <a href="?page=product&action=list&page_num=<?= $pageNum - 1 ?>&q=<?= urlencode($q ?? '') ?>&category=<?= urlencode($category ?? '') ?>&sort=<?= urlencode($sort ?? 'name') ?>" class="pagination-btn">
              <i class="fas fa-chevron-left"></i>
              Précédent
            </a>
          <?php endif; ?>

          <div class="pagination-numbers">
            <?php for ($i = max(1, $pageNum - 2); $i <= min($totalPages, $pageNum + 2); $i++) : ?>
              <a href="?page=product&action=list&page_num=<?= $i ?>&q=<?= urlencode($q ?? '') ?>&category=<?= urlencode($category ?? '') ?>&sort=<?= urlencode($sort ?? 'name') ?>"
                 class="pagination-number <?= $i === $pageNum ? 'active' : '' ?>">
                <?= $i ?>
              </a>
            <?php endfor; ?>
          </div>

          <?php if ($pageNum < $totalPages) : ?>
            <a href="?page=product&action=list&page_num=<?= $pageNum + 1 ?>&q=<?= urlencode($q ?? '') ?>&category=<?= urlencode($category ?? '') ?>&sort=<?= urlencode($sort ?? 'name') ?>" class="pagination-btn">
              Suivant
              <i class="fas fa-chevron-right"></i>
            </a>
          <?php endif; ?>
        </div>
      <?php endif; ?>
    <?php endif; ?>
  </div>
</section>

<?php require __DIR__ . '/../layout/footer.php'; ?>
