<?php ob_start(); ?>
<h1 class="h4 mb-3">Connexion</h1>
<form method="post" action="/login" class="card card-body form-wrapper">
  <div class="mb-3">
    <label>Email</label>
    <input type="email" name="email" class="form-control" required>
  </div>
  <div class="mb-3">
    <label>Mot de passe</label>
    <input type="password" name="password" class="form-control" required>
  </div>
  <button class="btn btn-primary">Se connecter</button>
</form>
<?php $content = ob_get_clean(); include __DIR__.'/../layouts/app.php'; ?>
