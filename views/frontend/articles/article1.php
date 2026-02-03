<?php
require_once '../../../header.php';
?>
<?php

// Get the article ID from URL parameter
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;

// Validate article ID exists before querying
if ($numArt <= 0) {
    header("Location: list.php");
    exit;
}

// Fetch the specific article to view
$article = sql_select("ARTICLE", "*", "numArt = $numArt");
$article = !empty($article) ? $article[0] : null;

if (!$article) {
    header("Location: list.php");
    exit;
}

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
$urlPhotArt = $article['urlPhotArt'] ?? "/src/uploads/default.png";

// Fetch necessary data from the database
$themes = sql_select("THEMATIQUE", "*", "numArt = $numArt");

$numThem = $article['libChapoArt'] ?? 0;
$theme = $themes['numThem'] ?? "Thématique par défaut";

$numMotCles = sql_select("MOTCLEARTICLE", "*", "numArt = $numArt");
$motscles = sql_select("MOTCLE", "*", "numMotCle = $numMotCles");

$likes = sql_select("LIKEART", "*", "numArt = $numArt");
$nbLikes = count($likes);

$comments = sql_select("COMMENT", "*", "numArt = $numArt");
$nbComments = count($comments);


?>

<main class="container">
	<article class="article-template">
		<h1><?php echo $libTitrArt; ?></h1>

		<p class="meta">Publié le <time datetime="<?php echo $dtCreaArt; ?>"></time></p>
		<p class="meta">Nombre de commentaires : <?php  echo $nbLikes; ?></p>
        <p class="meta">Nombre de likes : <?php  echo $nbComments; ?></p>

		<p class="chapeau"><?php echo $libChapoArt; ?></p>

		<p class="accroche"> <?php echo $libAccrochArt; ?></p>

        <img src="<?php echo $urlPhotArt; ?>" style="max-width:50%;height:auto;">

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
			<h3></h3>
			<p><?php echo $libConclArt; ?></p>
		</section>

		<aside class="meta-data">
			<p> <?php echo $theme; ?></p>
			<p> Mots Clés: <?php foreach ($motscles as $motcle) {  echo $motcle['libMotCle'] . ' '; } ?></p>
		</aside>

        <div>
            <button type="">Like</button>
        </div>
        <div>
            <h3>Commentaires (<?php echo $nbComments; ?>)</h3>
            <?php foreach ($comments as $comment) { ?>
                <div>
                    <p><?php 
                    $membre = sql_select("MEMBRE", "*", "numMemb = " . $comment['numMemb']);
                    echo htmlspecialchars($membre['pseudoMemb']); ?> a écrit :</p>
                    <p><?php echo nl2br(htmlspecialchars($comment['libCom'])); ?></p>
                </div>
            <?php } ?>
            <a href="../comments/commentaire.php" class="btn">Ajputer un commentaire</a>
        </div>

	</article>
</main>

<?php
require_once '../../../footer.php';
?>