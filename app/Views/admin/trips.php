<?php
/** @var array<int,array<string,mixed>> $trips */
$trips = $trips ?? [];
/** @var array<int,array{id:int,name:string}> $agencies */
$agencies = $agencies ?? [];
?>

<?php ob_start(); $now = date('Y-m-d\TH:i'); ?>
<h1 class="h4 mb-4">Trajets</h1>

<div class="row">
  <div class="col">
    <div class="card">
      <div class="card-body p-0">
        <table class="table mb-0 align-middle">
          <thead>
            <tr>
              <th>Départ</th>
              <th>Arrivée</th>
              <th>Départ (date)</th>
              <th>Places</th>
              <th>Action</th>
            </tr>
          </thead>
          <tbody>
          <?php foreach ($trips as $t): ?>
            <tr>
              <td><?= htmlspecialchars($t['departure']) ?></td>
              <td><?= htmlspecialchars($t['arrival']) ?></td>
              <td><?= date('d/m/Y H:i', strtotime($t['departure_at'])) ?></td>
              <td><?= (int)$t['available_seats'] ?>/<?= (int)$t['total_seats'] ?></td>
              <td>
                <form method="post" action="/admin/trips/delete" onsubmit="return confirm('Supprimer ce trajet ?');">
                  <input type="hidden" name="id" value="<?= (int)$t['id'] ?>">
                  <button class="btn btn-sm btn-danger">Supprimer</button>
                </form>
              </td>
            </tr>
          <?php endforeach; ?>
          </tbody>
        </table>
      </div>
    </div>
  </div>
  <div><a class="btn btn-primary mt-5" href="/trips/create">Nouveau trajet</a></div>


<?php $content = ob_get_clean(); include __DIR__.'/../layouts/app.php'; ?>
