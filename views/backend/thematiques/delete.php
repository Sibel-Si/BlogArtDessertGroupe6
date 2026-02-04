<?php
include '../../../header.php';

if(isset($_GET['numThem'])){
    $numThem = $_GET['numThem'];
    $thematique = sql_select("THEMATIQUE", "*", "numThem = $numThem");
    if(!$thematique) {
        $_SESSION['error_message'] = "Thématique non trouvée.";
        header('Location: list.php');
        exit();
    }
    $libThem = $thematique[0]['libThem'];
    
    
    $articlesWithThem = sql_select('ARTICLE', 'COUNT(*) as count', "numThem = $numThem");
    $articleCount = $articlesWithThem[0]['count'] ?? 0;
} else {
    $_SESSION['error_message'] = "ID de thématique manquant.";
    header('Location: list.php');
    exit();
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Thématique</h1>
            
            
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
            
            <?php if($articleCount > 0): ?>
                <div class="alert alert-warning" role="alert">
                    <strong>⚠️ Attention !</strong> Cette thématique est utilisée par <strong><?php echo $articleCount; ?></strong> article(s). La suppression n'est pas possible tant que des articles sont associés à cette thématique.
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-12">
           
            <form action="<?php echo ROOT_URL . '/api/thematiques/delete.php' ?>" method="post">
                <div class="form-group">
                    <label for="libThem">Nom de la thématique</label>
                    <input id="numThem" name="numThem" class="form-control" style="display: none" type="text" value="<?php echo($numThem); ?>" readonly="readonly" />
                    <input id="libThem" name="libThem" class="form-control" type="text" value="<?php echo($libThem); ?>" readonly="readonly" disabled />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">Retour à la liste</a>
                    <?php if($articleCount === 0): ?>
                        <button type="submit" class="btn btn-fonce" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cette thématique ?');">Confirmer suppression</button>
                    <?php else: ?>
                        <button type="submit" class="btn btn-fonce" disabled>Suppression impossible</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

