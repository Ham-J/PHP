<?php ob_start(); ?>
<h1 class="h4 mb-4">Agences</h1>

<div class="row g-4">
  <div class="col-lg-6">
    <div class="card">
      <div class="card-body p-0">
        <table class="table mb-0 align-middle">
          <thead><tr><th>Nom</th><th style="width:170px">Actions</th></tr></thead>
          <tbody>
          <?php foreach ($agencies as $a): ?>
            <tr>
              <td><?= htmlspecialchars($a['name']) ?></td>
              <td>
                <form class="d-flex gap-2" method="post" action="/admin/agencies/update">
                  <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
                  <input type="text" name="name" class="form-control form-control-sm" value="<?= htmlspecialchars($a['name']) ?>">
                  <button class="btn btn-sm btn-success-custom">OK</button>
                </form>
                <form method="post" action="/admin/agencies/delete" onsubmit="return confirm('Supprimer cette agence ?');" class="mt-2">
                  <input type="hidden" name="id" value="<?= (int)$a['id'] ?>">
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

  <div class="col-lg-6">
    <form class="card card-body" method="post" action="/admin/agencies">
      <h2 class="h6">Ajouter une agence</h2>
      <div class="mb-2">
        <label class="form-label">Nom</label>
        <input type="text" name="name" class="form-control" required>
      </div>
      <button class="btn btn-primary">Ajouter</button>
    </form>
  </div>
</div>

<?php $content = ob_get_clean(); include __DIR__.'/../layouts/app.php'; ?>
