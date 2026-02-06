<?php
require_once '../../../header.php'; // Includes security.php
if (!IS_LOGGED_IN){
    exit;
}

// Get the article ID from the URL
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;

// Redirect back if no article is specified
if ($numArt <= 0) {
    header("Location: /");
    exit;
}

// Optional: Fetch article title to show the user what they are commenting on
$article = sql_select("ARTICLE", "libTitrArt", "numArt = $numArt");
$libTitrArt = !empty($article) ? $article[0]['libTitrArt'] : "l'article";
?>

<div class="container mt-5" style="max-width: 600px;">
    <h2>Ajouter un commentaire</h2>
    <p class="text-muted">Sur l'article : <strong><?= htmlspecialchars($libTitrArt) ?></strong></p>

    <form action="/api/comments/create_front.php" method="post">
        <input type="hidden" name="numArt" value="<?= $numArt ?>">
        <input type="hidden" name="numMemb" value="<?= $_SESSION['id_user'] ?>">

        <div class="mb-3">
            <label for="libCom" class="form-label">Votre message</label>
            <textarea 
                class="form-control" 
                id="libCom" 
                name="libCom" 
                rows="4" 
                placeholder="Écrivez votre commentaire ici..." 
                required
            ></textarea>
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-fonce">Publier le commentaire</button>
            <a href="javascript:history.back()" class="btn btn-outline-secondary">Annuler</a>
        </div>
    </form>
</div>

<?php require_once '../../../footer.php'; ?>