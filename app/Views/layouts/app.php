<?php $appName = $appName ?? 'Touche Pas Au Klaxon'; ?>
<!doctype html>
<html lang="fr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title><?= htmlspecialchars($appName) ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="/css/style.css">
</head>
<body>
<nav class="navbar navbar-expand-lg bg-light border-bottom">
  <div class="container">
    <!-- GAUCHE -->
    <a class="navbar-brand fw-semibold" href="/"><?= htmlspecialchars($appName) ?></a>

    <!-- Bouton burger visible en mobile -->
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNavbar" 
      aria-controls="mainNavbar" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <!-- DROITE -->
    <div class="collapse navbar-collapse" id="mainNavbar">
      <div class="ms-auto d-flex flex-column flex-lg-row align-items-start align-items-lg-center gap-2 mt-3 mt-lg-0">

        <?php if (empty($_SESSION['uid'])): ?>
          <!-- Visiteur -->
          <a class="btn btn-primary w-100 w-lg-auto" href="/login">Connexion</a>

        <?php elseif (($_SESSION['role'] ?? '') !== 'admin'): ?>
          <!-- Utilisateur normal -->
          <a class="btn btn-danger w-100 w-lg-auto" href="/logout">Déconnexion</a>

        <?php else: ?>
          <!-- Admin -->
          <a class="btn btn-primary w-100 w-lg-auto" href="/admin/users">Utilisateurs</a>
          <a class="btn btn-primary w-100 w-lg-auto" href="/admin/agencies">Agence</a>
          <a class="btn btn-primary w-100 w-lg-auto" href="/admin/trips">Trajets</a>
          <a class="btn btn-danger w-100 w-lg-auto" href="/logout">Déconnexion</a>
        <?php endif; ?>

      </div>
    </div>
  </div>
</nav>

<main class="container py-4">
  <?= $content ?? '' ?>
</main>

<footer class="border-top py-3" id="mainFooter">
  <div class="container small text-center">
    <?= htmlspecialchars($appName) ?> — © <?= date('Y') ?>
  </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
