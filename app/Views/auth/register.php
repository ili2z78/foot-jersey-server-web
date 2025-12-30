<?php require __DIR__ . '/../layout/header.php'; ?>

<div class="auth-page">
  <div class="auth-container">
    <h1 class="auth-title">Inscription</h1>

    <?php if(!empty($error)): ?>
      <p style="color: red; text-align: center; margin-bottom: 20px;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form class="auth-form" method="post" action="?page=auth&action=register">
      <label class="auth-label">Nom complet</label>
      <input class="auth-input" type="text" name="fullname">

      <label class="auth-label">Email</label>
      <input class="auth-input" type="email" name="email" required>

      <label class="auth-label">Mot de passe</label>
      <input class="auth-input" type="password" name="password" required>

      <button class="auth-btn" type="submit">S'inscrire</button>
    </form>

    <div class="auth-switch">
      <p>Déjà un compte ? <a href="?page=auth&action=login">Se connecter</a></p>
    </div>
  </div>
</div>

<?php require __DIR__ . '/../layout/footer.php'; ?>
