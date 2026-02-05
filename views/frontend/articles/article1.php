<?php
require_once '../../../header.php'; // This already includes security.php

// Get the article ID from URL parameter
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 1;

// GET numMemb from session (updated from 0)
$numMemb = $_SESSION['id_user'] ?? 0;

// Validate article ID exists before querying
if ($numArt <= 0) {
    header("Location: list.php");
    exit;
}

// ... [Keep your existing sql_select queries for $article, $theme, $motscles, etc. here] ...

$likes = sql_select("LIKEART", "*", "numArt = $numArt");
$nbLikes = count($likes);

$comments = sql_select("COMMENT", "*", "numArt = $numArt AND attModOK = 1");
$nbComments = count($comments);
?>

<main class="container">
    <article class="article-template">
        <h1><?php echo htmlspecialchars($libTitrArt); ?></h1>

        <div class="d-flex meta">
            <p>Publié le <?php echo $dtCreaArt; ?></p>
            <p>Nombre de commentaires : <?php echo $nbComments; ?></p>
            <p>Nombre de likes : <?php echo $nbLikes; ?></p>
        </div>

        <aside class="d-flex meta">
            <p> Thématique: <?php echo $theme; ?></p>
            <p> Mots Clés: <?php foreach ($motscles as $motcle) {  echo htmlspecialchars($motcle['libMotCle']) . ' '; } ?></p>
        </aside>

        <hr>

        <?php if (IS_LOGGED_IN): ?>
            <div class="like-section mb-4">
                <?php 
                    // Optional: Check if user already liked this to change button appearance
                    $alreadyLiked = sql_select("likeart", "*", "numMemb = $numMemb AND numArt = $numArt");
                ?>
                <form action="<?php echo ROOT_URL . '/api/likes/create_front.php' ?>" method="post">
                    <input type="hidden" name="numMemb" value="<?php echo $numMemb; ?>">
                    <input type="hidden" name="numArt" value="<?php echo $numArt; ?>">
                    <button type="submit" class="btn <?php echo !empty($alreadyLiked) ? 'btn-danger' : 'btn-outline-danger'; ?>">
                        ❤ <?php echo !empty($alreadyLiked) ? 'Aimé' : 'Like'; ?>
                    </button>
                </form>
            </div>

            <div class="comments-section">
                <h3>Commentaires (<?php echo $nbComments; ?>)</h3>
                <?php foreach ($comments as $comment) { ?>
                    <div class="card mb-2 p-2">
                        <?php                 
                            $membre = sql_select("MEMBRE", "pseudoMemb", "numMemb = " . $comment['numMemb']);
                            $pseudo = !empty($membre) ? $membre[0]['pseudoMemb'] : "Anonyme";
                        ?>
                        <strong><?= htmlspecialchars($pseudo) ?></strong>
                        <p class="mb-0"><?= nl2br(htmlspecialchars($comment['libCom'])) ?></p>
                    </div>
                <?php } ?>
                <a href="../comments/commentaire.php?numArt=<?= $numArt ?>" class="btn btn-primary mt-2">Ajouter un commentaire</a>
            </div>
        <?php else: ?>
            <div class="alert alert-info">
                <a href="/views/backend/security/login.php">Connectez-vous</a> pour liker cet article ou voir les commentaires.
            </div>
        <?php endif; ?>

    </article>
</main>

<?php require_once '../../../footer.php'; ?>