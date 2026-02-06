<?php
require_once '../../../header.php'; 

// 1. Get IDs
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 1;
$numMemb = $_SESSION['id_user'] ?? 0;

if ($numArt <= 0) {
    header("Location: list.php");
    exit;
}

// 2. Fetch data
$article = sql_select("ARTICLE", "*", "numArt = $numArt");
$article = !empty($article) ? $article[0] : null;

if (!$article) {
    header("Location: list.php");
    exit;
}

// 3. Define variables (Restore all original data mapping)
$libTitrArt = $article['libTitrArt'] ?? "Titre de l'article";
$dtCreaArt = $article['dtCreaArt'] ??"date de création";
$libChapoArt = $article['libChapoArt'] ?? "chapeau de l'article";
$libAccrochArt = $article['libAccrochArt'] ?? "accroche";
$parag1Art = $article['parag1Art'] ?? "Premier paragraphe";
$libSsTitr1Art = $article['libSsTitr1Art'] ?? "Premier sous-titre";
$parag2Art = $article['parag2Art'] ?? "Deuxième paragraphe";
$libSsTitr2Art = $article['libSsTitr2Art'] ?? "Second sous-titre";
$parag3Art = $article['parag3Art'] ?? "Troisième paragraphe";
$libConclArt = $article['libConclArt'] ?? "Conclusion de l'article";
$urlPhotArt = $article['urlPhotArt'] ?? "default.png";

$themeData = sql_select("THEMATIQUE", "libThem", "numThem = " . ($article['numThem'] ?? 0));
$theme = !empty($themeData) ? $themeData[0]['libThem'] : "Thématique par défaut";

$motsClesArt = sql_select("MOTCLEARTICLE", "numMotCle", "numArt = $numArt");
if (!empty($motsClesArt)) {
    $ids = implode(',', array_column($motsClesArt, 'numMotCle'));
    $motscles = sql_select("MOTCLE", "*", "numMotCle IN ($ids)");
} else {
    $motscles = [];
}

$likes = sql_select("LIKEART", "*", "numArt = $numArt AND likeA = 1");
$nbLikes = count($likes);

// Check if the current user has liked this article
$userHasLiked = false;
if ($numMemb > 0) {
    $checkLike = sql_select("LIKEART", "likeA", "numArt = $numArt AND numMemb = $numMemb");
    // Extract the value (handling potential array return)
    $status = !empty($checkLike) ? (isset($checkLike[0]['likeA']) ? $checkLike[0]['likeA'] : $checkLike['likeA']) : 0;
    $userHasLiked = ((int)$status === 1);
}

$comments = sql_select("COMMENT", "*", "numArt = $numArt AND attModOK = 1");
$nbComments = count($comments);
?>

<main class="container">
    <article class="article-template">
        <h1><?php echo $libTitrArt; ?></h1>

        <div class="d-flex meta">
            <p>Publié le <?php echo $dtCreaArt; ?></p>
            <p>Nombre de commentaires : <?php echo $nbComments; ?></p>
            <p>Nombre de likes : <?php echo $nbLikes; ?></p>
        </div>

        <div class="d-flex chapo-photo">
            <div>
                <p class="chapeau"><?php echo $libChapoArt; ?></p>
                <p class="accroche"> <?php echo $libAccrochArt; ?></p>
            </div>
            <img src="../../../src/uploads/<?php echo $urlPhotArt; ?>" style="max-width:50%;height:auto;">
        </div>

        <div class="d-flex separateur">
            <img src="../../../src/images/canele-illu.png" alt="">
            <p>CANELES</p>
            <img src="../../../src/images/croissant-illu.png" alt="">
            <p>CROISSANTS</p>
            <img src="../../../src/images/pain-illu.png" alt="">
            <p>PAINS</p>
        </div>

        <section>
            <p><?php echo $parag1Art; ?></p>
        </section>

        <h2><?php echo $libSsTitr1Art; ?></h2>
        <section>
            <p><?php echo $parag2Art; ?></p>
        </section>

        <h2><?php echo $libSsTitr2Art; ?></h2>
        <section>
            <p><?php echo $parag3Art; ?></p>
        </section>

        <section class="conclusion">
            <p><?php echo $libConclArt; ?></p>
        </section>

        <div class="d-flex separateur">
            <img src="../../../src/images/canele-illu.png" alt="">
            <p>CANELES</p>
            <img src="../../../src/images/croissant-illu.png" alt="">
            <p>CROISSANTS</p>
            <img src="../../../src/images/pain-illu.png" alt="">
            <p>PAINS</p>
        </div>

        <aside class="d-flex meta">
            <p> Thématique: <?php echo $theme; ?></p>
            <p> Mots Clés: <?php foreach ($motscles as $motcle) {  echo $motcle['libMotCle'] . ' '; } ?></p>
        </aside>

        <?php if (IS_LOGGED_IN): ?>
            <div class="like-section mt-4 mb-4">
                <form action="<?php echo ROOT_URL . '/api/likes/create_front.php' ?>" method="post">
                    <input type="hidden" name="numMemb" value="<?php echo $numMemb; ?>">
                    <input type="hidden" name="numArt" value="<?php echo $numArt; ?>">
                    <button type="submit" class="btn <?php echo $userHasLiked ? 'btn-danger' : 'btn-fonce'; ?>">❤ <?php echo $userHasLiked ? 'Unliker' : 'Liker'; ?></button>
                </form>
            </div>

            <div class="comments-section">
                <h3>Commentaires (<?php echo $nbComments; ?>)</h3>
                <?php foreach ($comments as $comment) { ?>
                    <div class="comments card mb-2 p-2">
                        <?php                 
                            $membre = sql_select("MEMBRE", "*", "numMemb = " . $comment['numMemb']);
                            $pseudo = !empty($membre) ? $membre[0]['pseudoMemb'] : "Anonyme";
                        ?>
                        <strong><?= htmlspecialchars($pseudo) ?> a écrit :</strong>
                        <p><?= nl2br(htmlspecialchars($comment['libCom'])) ?></p>
                    </div>
                <?php } ?>
                <a href="../comments/commentaire.php?numArt=<?= $numArt ?>" class="btn btn-fonce">Ajouter un commentaire</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info mt-4">
                Veuillez vous connecter pour liker ou commenter cet article.
            </div>
        <?php endif; ?>

    </article>
</main>

<?php require_once '../../../footer.php'; ?>