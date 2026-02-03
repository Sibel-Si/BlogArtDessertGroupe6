<?php
include '../../../header.php'; // contains the header and call to config.php

$thematiques = [];
try {
    $thematiques = getThematiques();
} catch (Exception $e) {
    $_SESSION['error_message'] = 'Erreur lors du chargement des thématiques: ' . $e->getMessage();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Liste des Thématiques</h1>
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-12">
            <a href="create.php" class="btn btn-success mb-3">+ Créer une nouvelle thématique</a>
            
            <?php if (count($thematiques) > 0): ?>
                <table class="table table-striped table-hover">
                    <thead class="table-dark">
                        <tr>
                            <th>ID</th>
                            <th>Nom de la thématique</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($thematiques as $thematique): ?>
                            <tr>
                                <td><?php echo $thematique['idThem']; ?></td>
                                <td><?php echo htmlspecialchars($thematique['libThem']); ?></td>
                                <td>
                                    <a href="edit.php?id=<?php echo $thematique['idThem']; ?>" class="btn btn-warning btn-sm">Modifier</a>
                                    <a href="delete.php?id=<?php echo $thematique['idThem']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?');">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <div class="alert alert-info" role="alert">
                    Aucune thématique trouvée. <a href="create.php">Créer la première</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>


