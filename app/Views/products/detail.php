<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="container">
    <div class="product-detail">
        <div class="product-detail-grid">
            <div class="product-gallery">
                <img src="/assets/images/<?= $p['image'] ?>" alt="<?= $p['name'] ?>" class="main-image">
            </div>
            <div class="product-info">
                <h1 class="product-title"><?= $p['name'] ?></h1>
                <p class="product-description"><?= $p['description'] ?></p>
                <div class="product-price-large"><?= $p['price'] ?> €</div>
                <a href="?page=cart&action=add&id=<?= $p['id'] ?>" class="add-to-cart-btn">
                    Ajouter au panier
                </a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
