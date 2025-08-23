<?php
/** @var array<int,array<string,mixed>> $users */
$users = $users ?? [];
?>

<?php ob_start(); ?>
<h1 class="h4 mb-4">Utilisateurs</h1>

<div class="card">
  <div class="card-body p-0">
    <table class="table mb-0 align-middle">
      <thead>
        <tr>
          <th>Nom</th>
          <th>Email</th>
          <th>Téléphone</th>
          <th>Rôle</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($users as $u): ?>
        <tr>
          <td><?= htmlspecialchars($u['last_name'].' '.$u['first_name']) ?></td>
          <td><?= htmlspecialchars($u['email']) ?></td>
          <td><?= htmlspecialchars($u['phone']) ?></td>
          <td><?= htmlspecialchars($u['role']) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
  </div>
</div>

<?php $content = ob_get_clean(); include __DIR__.'/../layouts/app.php'; ?>
