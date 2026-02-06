<?php

include '../../../header.php';
check_page_access([1, 2]); 

if(isset($_GET['numMotCle'])){
    $numMotCle = $_GET['numMotCle'];
    $motcle = sql_select("MOTCLE", "libMotCle", "numMotCle = $numMotCle");
    
    if(!$motcle) {
        $_SESSION['error_message'] = "Mot clé non trouvé.";
        header('Location: list.php');
        exit();
    }
    
    $libMotCle = $motcle[0]['libMotCle'];
    
    $articleWithMotCle = sql_select('MOTCLEARTICLE', 'COUNT(*) as count', "numMotCle = $numMotCle");
    $articleCount = $articleWithMotCle[0]['count'] ?? 0;
} else {
    header('Location: list.php');
    exit();
}
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Mot Clé</h1>
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>

            <?php if($articleCount > 0): ?>
                <div class="alert alert-warning" role="alert">
                    <strong>⚠️ Attention !</strong> Ce Mot Clé est utilisé par <strong><?php echo $articleCount; ?></strong> article(s). La suppression n'est pas possible tant que des articles sont associés à ce mot clé.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/keywords/delete.php' ?>" method="post">
                <div class="form-group">
                    <label for="numMotCle">Id du mot clé</label>
                    <input id="numMotCle" name="numMotCle" class="form-control" type="text" value="<?php echo($numMotCle); ?>" readonly="readonly" />
                </div>
                <div class="form-group">
                    <label for="libMotCle">Nom du mot clé</label>
                    <input id="libMotCle" name="libMotCle" class="form-control" type="text" value="<?php echo($libMotCle); ?>" readonly="readonly" disabled />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    
                    <?php if($articleCount === 0): ?>
                        <button type="submit" class="btn btn-fonce" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce mot clé ?');">
                            Confirmer la suppression
                        </button>
                    <?php else: ?>
                        <button type="button" class="btn btn-fonce" disabled>Suppression impossible</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>