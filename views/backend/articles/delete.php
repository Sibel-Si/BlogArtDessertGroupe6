<?php
include '../../../header.php';
check_page_access([1, 2]); 

$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;
if ($numArt <= 0) { header("Location: list.php"); exit; }

$article = sql_select("ARTICLE", "*", "numArt = $numArt");
$article = !empty($article) ? $article[0] : null;
if (!$article) { header("Location: list.php"); exit; }

// Check for dependent comments
$comments = sql_select('COMMENT', 'COUNT(*) as count', "numArt = $numArt");
$commentCount = $comments[0]['count'] ?? 0;

$themes = sql_select("THEMATIQUE", "*");
$motscles = sql_select("MOTCLE", "*");
$motsclesarticles = sql_select("MOTCLEARTICLE", "numMotCle", "numArt = $numArt");
$motscleschoisis = array_column($motsclesarticles, 'numMotCle');
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Suppression Article</h1>

            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger"><?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?></div>
            <?php endif; ?>

            <?php if($commentCount > 0): ?>
                <div class="alert alert-warning">
                    <strong>⚠️ Attention !</strong> Cet article possède <strong><?php echo $commentCount; ?></strong> commentaire(s). 
                    La suppression est bloquée tant que ces commentaires existent.
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/articles/delete.php' ?>" method="post" 
                  onclick="return <?php echo ($commentCount == 0) ? "confirm('Confirmer la suppression définitive de cet article ?')" : "false"; ?>;">
                
                <input type="hidden" name="numArt" value="<?php echo $article['numArt']; ?>" />
                
                <div class="form-group">
                    <label>Titre de l'article</label>
                    <input class="form-control" type="text" value="<?php echo htmlspecialchars($article['libTitrArt']); ?>" readonly disabled />
                </div>
                <br />
                <div class="form-group">
                    <label>Thématique</label>
                    <select class="form-control" disabled>
                        <?php foreach($themes as $theme): ?>
                            <option <?php echo ($theme['numThem'] == $article['numThem']) ? 'selected' : ''; ?>>
                                <?php echo $theme['libThem']; ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">Retour</a>
                    <?php if($commentCount == 0): ?>
                        <button type="submit" class="btn btn-fonce">Confirmer Suppression</button>
                    <?php else: ?>
                        <button type="button" class="btn btn-fonce" disabled>Suppression impossible</button>
                    <?php endif; ?>
                </div>
            </form>
        </div>
    </div>
</div>

<?php include '../../../footer.php'; ?>