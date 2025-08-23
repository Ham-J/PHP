<?php
/** @var array<int,array{id:int,name:string}> $agencies */
$agencies = $agencies ?? [];
?>

<?php ob_start(); $now = date('Y-m-d\TH:i'); ?>
<h1 class="h4 mb-3">Proposer un trajet</h1>

<?php if (!empty($errors)): ?>
  <div class="alert alert-danger">
    <ul class="mb-0"><?php foreach ($errors as $e): ?><li><?= htmlspecialchars($e) ?></li><?php endforeach; ?></ul>
  </div>
<?php endif; ?>

<form method="post" action="/trips" class="card card-body form-wrapper">
  <div class="mb-3">
    <label>Agence de départ</label>
    <select name="departure_agency_id" class="form-select" required>
      <?php foreach ($agencies as $a): ?>
        <option value="<?= (int)$a['id'] ?>" <?= (isset($old['departure_agency_id']) && (int)$old['departure_agency_id']===(int)$a['id'])?'selected':''; ?>>
        <?=htmlspecialchars($a['name'])?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Agence d'arrivée</label>
    <select name="arrival_agency_id" class="form-select" required>
      <?php foreach ($agencies as $a): ?>
        <option value="<?= (int)$a['id'] ?>" <?= (isset($old['arrival_agency_id']) && (int)$old['arrival_agency_id']===(int)$a['id'])?'selected':''; ?>>
        <?=htmlspecialchars($a['name'])?>
        </option>
      <?php endforeach; ?>
    </select>
  </div>

  <div class="mb-3">
    <label>Départ</label>
    <input type="datetime-local" name="departure_at" class="form-control"
    min="<?= $now ?>" step="1"
    value="<?= htmlspecialchars($old['departure_at'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label>Arrivée</label>
    <input type="datetime-local" name="arrival_at" class="form-control"
    min="<?= $now ?>" step="1"
    value="<?= htmlspecialchars($old['arrival_at'] ?? '') ?>">
  </div>

  <div class="mb-3">
    <label>Places totales</label>
    <input type="number" name="total_seats" class="form-control" min="1" required
    value="<?= (int)($old['total_seats'] ?? 1) ?>">
  </div>

  <div class="mb-3">
    <label>Places disponibles</label>
    <input type="number" name="available_seats" class="form-control" min="1" required
    value="<?= (int)($old['available_seats'] ?? 1) ?>">
  </div>

  <button class="btn btn-primary">Créer</button>
</form>
<?php $content = ob_get_clean(); include __DIR__.'/../layouts/app.php'; ?>
