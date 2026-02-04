<?php
include '../../../header.php';

if(isset($_GET['numStat'])){
    $numStat = $_GET['numStat'];
    $libStat = sql_select("STATUT", "libStat", "numStat = $numStat")[0]['libStat'];

    $membreWithStat = sql_select('MEMBRE', 'COUNT(*) as count', "numStat = $numStat");
    $membreCount = $membreWithStat[0]['count'] ?? 0;
}
?>

<!-- Bootstrap form to delet a statut -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Statut</h1>
        </div>

        <?php if($membreCount > 0): ?>
        <div class="alert alert-warning" role="alert">
            <strong>⚠️ Attention !</strong> Ce Statut est utilisée par <strong><?php echo $membreCount; ?></strong> membre(s). La suppression n'est pas possible tant que des membres sont associés à ce statut.
        </div>
        <?php endif; ?>

        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/statuts/delete.php' ?>" method="post">
                <div class="form-group">
                    <label for="libStat">Id du statut</label>
                    <input id="numStat" name="numStat" class="form-control"  type="text" value="<?php echo($numStat); ?>" readonly="readonly" disabled/>
                </div>
                <div class="form-group">
                    <label for="libStat">Nom du statut</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo($libStat); ?>" readonly="readonly" disabled />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <button type="submit" class="btn btn-fonce">Confirmer delete ?</button>
                </div>
            </form>
        </div>
    </div>
</div>