<?php ob_start(); ?>

<h1 class="h4 mb-3">Liste des trajets</h1>

<?php if (empty($trips)): ?>
  <p>Aucun trajet disponible pour le moment.</p>
<?php else: ?>

  <!-- Table classique pour écrans moyens et + -->
  <div class="d-none d-md-block">
    <div class="table-responsive">
      <table class="table table-bordered align-middle">
        <thead>
          <tr>
            <th>Départ</th>
            <th>Arrivée</th>
            <th>Date départ</th>
            <th>Date arrivée</th>
            <th>Places</th>
            <th style="width:220px">Actions</th>
          </tr>
        </thead>
        <tbody>
        <?php foreach ($trips as $t): ?>
          <tr>
            <td><?= htmlspecialchars($t['departure']) ?></td>
            <td><?= htmlspecialchars($t['arrival']) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['departure_at'])) ?></td>
            <td><?= date('d/m/Y H:i', strtotime($t['arrival_at'])) ?></td>
            <td><?= (int)($t['available_seats'] ?? 0) ?>/<?= (int)($t['total_seats'] ?? 0) ?></td>
            <td class="text-nowrap">
              <?php if (!empty($_SESSION['uid'])): ?>
                <a href="/trips/show?id=<?= (int)$t['id'] ?>" class="btn btn-sm btn-primary mb-1">Détails</a>

                <?php if ((int)$t['created_by_user_id'] === (int)$_SESSION['uid']): ?>
                  <a href="/trips/edit?id=<?= (int)$t['id'] ?>" class="btn btn-success-custom btn-sm mb-1">Modifier</a>
                  <form method="post" action="/trips/delete" class="d-inline" onsubmit="return confirm('Supprimer ce trajet ?');">
                    <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                    <button class="btn btn-sm btn-danger mb-1">Supprimer</button>
                  </form>
                <?php endif; ?>

              <?php else: ?>
                <a href="/login" class="btn btn-sm btn-primary mb-1">Se connecter</a>
              <?php endif; ?>
            </td>
          </tr>
        <?php endforeach; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Version cartes pour mobile -->
  <div class="d-md-none">
    <div class="row g-3">
      <?php foreach ($trips as $t): ?>
        <div class="col-12">
          <div class="card shadow-sm">
            <div class="card-body">
              <h5 class="card-title">
                <?= htmlspecialchars($t['departure']) ?> → <?= htmlspecialchars($t['arrival']) ?>
              </h5>
              <p class="mb-1"><strong>Départ :</strong> <?= date('d/m/Y H:i', strtotime($t['departure_at'])) ?></p>
              <p class="mb-1"><strong>Arrivée :</strong> <?= date('d/m/Y H:i', strtotime($t['arrival_at'])) ?></p>
              <p class="mb-2"><strong>Places :</strong> <?= (int)$t['available_seats'] ?>/<?= (int)$t['total_seats'] ?></p>
              
              <?php if (!empty($_SESSION['uid'])): ?>
                <a href="/trips/show?id=<?= (int)$t['id'] ?>" class="btn btn-sm btn-primary me-1">Détails</a>

                <?php if ((int)$t['created_by_user_id'] === (int)$_SESSION['uid']): ?>
                  <a href="/trips/edit?id=<?= (int)$t['id'] ?>" class="btn btn-success-custom btn-sm me-1">Modifier</a>
                  <form method="post" action="/trips/delete" class="d-inline" onsubmit="return confirm('Supprimer ce trajet ?');">
                    <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                    <button class="btn btn-sm btn-danger">Supprimer</button>
                  </form>
                <?php endif; ?>

              <?php else: ?>
                <a href="/login" class="btn btn-sm btn-secondary">Se connecter</a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

<?php endif; ?>

<!-- Bouton pour créer un nouveau trajet -->
<div>
  <a class="btn btn-primary mt-2" href="/trips/create">Nouveau trajet</a>
</div>

<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/app.php'; ?>
