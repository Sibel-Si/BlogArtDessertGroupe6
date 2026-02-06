<?php 

include '../../../header.php';
check_page_access([1, 2]); 

// Get the article ID from URL parameter
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;
if ($numArt <= 0) { header("Location: list.php"); exit; }

// Validate article ID exists before querying
if ($numArt <= 0) {
    header("Location: list.php");
    exit;
}

// Fetch the specific article to edit
$article = sql_select("ARTICLE", "*", "numArt = $numArt");
$article = !empty($article) ? $article[0] : null;
if (!$article) { header("Location: list.php"); exit; }

if (!$article) {
    header("Location: list.php");
    exit;
}
// Check for dependent comments
$comments = sql_select('COMMENT', 'COUNT(*) as count', "numArt = $numArt");
$commentCount = $comments[0]['count'] ?? 0;

$themes = sql_select("THEMATIQUE", "*");
$motscles = sql_select("MOTCLE", "*");
$motsclesarticles = sql_select("MOTCLEARTICLE", "*", "numArt = $numArt");

// Build array of selected keywords for this article
$motscleschoisis = array();
foreach($motsclesarticles as $mca) {
    $motscleschoisis[] = $mca['numMotCle'];
}
$motsclesarticles = sql_select("MOTCLEARTICLE", "numMotCle", "numArt = $numArt");
$motscleschoisis = array_column($motsclesarticles, 'numMotCle');
?>

<script src="../../../src/js/articles.js"></script>

<!-- Bootstrap form to edit article -->
<div class="container">
    <div class="row">

<div class="col-md-12">
    <form action="<?php echo ROOT_URL . '/api/articles/delete.php' ?>" method="post">
        
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
                <button type="submit" class="btn btn-fonce" onclick="return confirm('Confirmer la suppression définitive de cet article ?');">
                    Confirmer Suppression
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-fonce" disabled>Suppression impossible</button>
            <?php endif; ?>
        </div>
    </form>
</div>