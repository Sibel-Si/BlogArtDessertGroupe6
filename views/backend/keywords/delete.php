<?php

session_start();
require_once ROOT_URL . '/functions/security.php';

// Define the required level (e.g., 1 for Admin, 2 for Moderator)
$required_level = 1; 

if (!check_access($required_level)) {
    // Redirect unauthorized users to login or an error page
    header("Location: login.php?error=unauthorized");
    exit(); // Always exit after a header redirect
}

include '../../../header.php';

if(isset($_GET['numMotCle'])){
    $numMotCle = $_GET['numMotCle'];
    $libMotCle = sql_select("MOTCLE", "libMotCle", "numMotCle = $numMotCle")[0]['libMotCle'];
    
    $articleWithMotCle = sql_select('MOTCLEARTICLE', 'COUNT(*) as count', "numMotCle = $numMotCle");
    $articleCount = $articleWithMotCle[0]['count'] ?? 0;

    }
?>

<!-- Bootstrap form to create a new statut -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Mot Clé</h1>
        </div>

        <?php if($articleCount > 0): ?>
        <div class="alert alert-warning" role="alert">
            <strong>⚠️ Attention !</strong> Ce Mot Clé est utilisée par <strong><?php echo $articleCount; ?></strong> article(s). La suppression n'est pas possible tant que des articles sont associés à ce mot clé.
        </div>
        <?php endif; ?>

        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/keywords/delete.php' ?>" method="post">
                <div class="form-group">
                    <label for="numMotCle">Id du mot clé</label>
                    <input id="numMotCle" name="numMotCle" class="form-control" type="text" value="<?php echo($numMotCle); ?>" readonly="readonly" />
                </div>
                <div class="form-group">
                    <label for="libMotCle">Nom du mot clé</label>
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" readonly="readonly" />
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