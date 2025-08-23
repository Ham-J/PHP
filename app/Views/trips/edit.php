<?php ob_start(); $now = date('Y-m-d\TH:i'); ?>
<h1 class="h4 mb-3">Modifier le trajet</h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>

<form method="post" action="/trips/update" class="card card-body form-wrapper">
  <input type="hidden" name="id" value="<?= (int)$trip['id'] ?>">

  <div class="mb-3">
    <label>Agence de départ</label>
    <select name="departure_agency_id" class="form-select" required>
      <?php foreach ($agencies as $a): ?>
        <option value="<?= (int)$a['id'] ?>" <?= ((int)$trip['departure_agency_id']===(int)$a['id'])?'selected':''; ?>>
        <?=htmlspecialchars($a['name'])?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Agence d'arrivée</label>
    <select name="arrival_agency_id" class="form-select" required>
      <?php foreach ($agencies as $a): ?>
        <option value="<?= (int)$a['id'] ?>" <?= ((int)$trip['arrival_agency_id']===(int)$a['id'])?'selected':''; ?>>
        <?=htmlspecialchars($a['name'])?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Départ</label>
    <input type="datetime-local" name="departure_at" class="form-control"
    min="<?= $now ?>" step="1"
    value="<?= htmlspecialchars(date('Y-m-d\TH:i:s', strtotime($trip['departure_at']))) ?>">
  </div>

  <div class="mb-3">
    <label>Arrivée</label>
    <input type="datetime-local" name="arrival_at" class="form-control"
    min="<?= $now ?>" step="1"
    value="<?= htmlspecialchars(date('Y-m-d\TH:i:s', strtotime($trip['arrival_at']))) ?>">
  </div>

  <div class="mb-3">
    <label>Places totales</label>
    <input type="number" name="total_seats" class="form-control" min="1" required
    value="<?= (int)$trip['total_seats'] ?>">
  </div>

  <div class="mb-3">
    <label>Places disponibles</label>
    <input type="number" name="available_seats" class="form-control" min="1" required
    value="<?= (int)$trip['available_seats'] ?>">
  </div>

  <button class="btn btn-primary">Enregistrer</button>
</form>
<?php $content = ob_get_clean(); include __DIR__.'/../layouts/app.php'; ?>
