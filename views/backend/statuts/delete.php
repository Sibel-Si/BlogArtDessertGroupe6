<?php
include '../../../header.php';
check_page_access([1, 2]); 

if(isset($_GET['numStat'])){
    $numStat = $_GET['numStat'];
    $statut = sql_select("STATUT", "libStat", "numStat = $numStat");
    
    if(!$statut) {
        $_SESSION['error_message'] = "Statut non trouvé.";
        header('Location: list.php');
        exit();
    }
    
    $libStat = $statut[0]['libStat'];
    $membreWithStat = sql_select('MEMBRE', 'COUNT(*) as count', "numStat = $numStat");
    $membreCount = $membreWithStat[0]['count'] ?? 0;
} else {
    header('Location: list.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Statut</h1>

            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <?php if($membreCount > 0): ?>
                <div class="alert alert-warning" role="alert">
                    <strong>⚠️ Attention !</strong> Ce Statut est utilisé par <strong><?php echo $membreCount; ?></strong> membre(s). La suppression est impossible.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/statuts/delete.php' ?>" method="post">
                <div class="form-group">
                    <label for="numStat">Id du statut</label>
                    <input id="numStat" name="numStat" class="form-control" type="text" value="<?php echo($numStat); ?>" readonly />
                </div>
                <div class="form-group">
                    <label for="libStat">Nom du statut</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo($libStat); ?>" readonly disabled />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">Retour à la liste</a>
                    
                    <?php if($membreCount === 0): ?>
                        <button type="submit" class="btn btn-fonce" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce statut ?');">
                            Confirmer la suppression
                        </button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-fonce" disabled>Suppression impossible</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>