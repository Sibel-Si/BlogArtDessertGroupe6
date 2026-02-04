<?php
include '../../../header.php'; // contains the header and call to config.php
?>
<div class="card">
    <div class="card-body">
      <?php if(isset($_SESSION['success_message'])): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <?php if(isset($_SESSION['error_message'])): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
          <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
      <?php endif; ?>

      <div class="d-flex justify-content-between align-items-center mb-3">
        <h3 class="card-title mb-0">Membres</h3>
      </div>

      <div class="table-responsive">
        <table class="table table-striped table-hover">
          <thead class="thead-light">
            <tr>
              <th scope="col">Id</th>
              <th scope="col">Prénom</th>
              <th scope="col">Nom</th>
              <th scope="col">Pseudo</th>
              <th scope="col">eMail</th>
              <th scope="col">Accord RGPD</th>
              <th scope="col">Statut</th>
              <th scope="col" class="text-right">Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php 
            $members = function_exists('sql_select') ? sql_select('MEMBRE', '*', null, null, 'numMemb ASC') : array();
            if ($members && count($members) > 0):
              foreach ($members as $m):
                $statLib = '—';
                if (isset($m['numStat'])) {
                  $s = function_exists('sql_select') ? sql_select('STATUT', 'libStat', 'numStat = ' . $m['numStat']) : null;
                  if ($s && count($s) > 0) $statLib = $s[0]['libStat'];
                }
                $accord = (isset($m['accordMemb']) && $m['accordMemb']) ? 'Oui' : 'Non';
            ?>
            <tr>
              <td><?php echo htmlspecialchars($m['numMemb']); ?></td>
              <td><?php echo htmlspecialchars($m['prenomMemb'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($m['nomMemb'] ?? ''); ?></td>
              <td><?php echo htmlspecialchars($m['pseudoMemb']); ?></td>
              <td><?php echo htmlspecialchars($m['eMailMemb']); ?></td>
              <td><?php echo $accord; ?></td>
              <td><?php echo htmlspecialchars($statLib); ?></td>
              <td class="text-right">
                <a href="edit.php?numM=<?php echo $m['numMemb']; ?>" class="btn btn-sm btn-moyen mr-1">Edit</a>
                <a href="delete.php?numM=<?php echo $m['numMemb']; ?>" class="btn btn-sm btn-fonce">Delete</a>
              </td>
            </tr>
            <?php 
              endforeach;
            else:
            ?>
            <tr>
              <td colspan="8" class="text-center text-muted">Aucun membre trouvé.</td>
            </tr>
            <?php endif; ?>
          </tbody>
        </table>

      </div>

      <div class="d-flex justify-content-between align-items-center mt-3">
        <div class="d-flex align-items-center">
          <a href="create.php" class="btn btn-clair btn-sm mr-3">Create</a>
          <nav aria-label="Page navigation">

    


