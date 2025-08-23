<?php ob_start(); ?>

<h1 class="h4 mb-3">Détails du trajet</h1>

<div class="card">
  <div class="card-body">
    <p><b>Départ :</b> <?= htmlspecialchars($trip['departure']) ?></p>
    <p><b>Arrivée :</b> <?= htmlspecialchars($trip['arrival']) ?></p>
    <p><b>Départ :</b> <?= date('d/m/Y H:i', strtotime($trip['departure_at'])) ?></p>
    <p><b>Arrivée :</b> <?= date('d/m/Y H:i', strtotime($trip['arrival_at'])) ?></p>
    <p><b>Places :</b> <?= (int)$trip['available_seats'] ?>/<?= (int)$trip['total_seats'] ?></p>
    <hr>
    <p><b>Contact :</b><br>
       <?= htmlspecialchars($trip['contact_first'].' '.$trip['contact_last']) ?><br>
       <?= htmlspecialchars($trip['contact_email']) ?><br>
       <?= htmlspecialchars($trip['contact_phone']) ?>
    </p>
  </div>
</div>

<a href="/" class="btn btn-link mt-3">← Retour</a>

<?php $content = ob_get_clean(); include __DIR__ . '/../layouts/app.php'; ?>
