<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-page">
  <div class="auth-container">
    <h1 class="auth-title">Se connecter</h1>

    <?php if(!empty($error)): ?>
      <p style="color: red; text-align: center; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="auth-form" method="post" action="?page=auth&action=login">
      <label class="auth-label">Email</label>
      <input class="auth-input" type="email" name="email" required>

      <label class="auth-label">Mot de passe</label>
      <input class="auth-input" type="password" name="password" required>

      <button class="auth-btn" type="submit">Se connecter</button>
    </form>

    <div class="auth-switch">
      <p>Pas encore inscrit ? <a href="?page=auth&action=register">Créer un compte</a></p>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
