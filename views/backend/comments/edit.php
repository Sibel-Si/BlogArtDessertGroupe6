<?php
// EDIT COMMENT (Fixed Article)
include '../../../header.php';

// 1. Get the comment ID from URL
$numCom = $_GET['numCom'] ?? 0;

// 2. Fetch the specific comment data
$comment_data = sql_select("COMMENT", "*", "numCom = $numCom");
$commentaire = !empty($comment_data) ? $comment_data[0] : null;

if (!$commentaire) {
    header("Location: list.php");
    exit;
}

// 3. Fetch the member associated with this comment
$numMemb = $commentaire['numMemb'];
$membre_data = sql_select("MEMBRE", "*", "numMemb = $numMemb");
$membre = !empty($membre_data) ? $membre_data[0] : null;

$pseudoMemb = $membre["pseudoMemb"] ?? "Pseudo inconnu";
$prenomMemb = $membre["prenomMemb"] ?? "Prénom inconnu";
$nomMemb    = $membre["nomMemb"]    ?? "Nom inconnu";

// 4. Fetch articles to display the title
$articles = sql_select("ARTICLE", "*");
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification du Commentaire</h1>
        </div>
        <div class="col-md-12">
            <form action="<?php echo ROOT_URL . '/api/comments/update.php' ?>" method="post">
                
                <input type="hidden" name="numCom" value="<?php echo($numCom); ?>">
                <input type="hidden" name="numMemb" value="<?php echo($numMemb); ?>">
                <input type="hidden" name="numArt" value="<?php echo($commentaire['numArt']); ?>">

                <div class="form-group">
                    <label for="pseudoMemb">Pseudo</label>
                    <input id="pseudoMemb" class="form-control" type="text" value="<?php echo($pseudoMemb);?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="nomMemb">Nom</label>
                    <input id="nomMemb" name="nomMemb" class="form-control" type="text" value ="<?php echo($nomMemb);?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="prenomMemb">Prénom</label>
                    <input id="prenomMemb" name="prenomMemb" class="form-control" type="text" value ="<?php echo($prenomMemb);?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="numArt_display">Article</label>
                    <select id="numArt_display" class="form-control" disabled>
                        <?php
                        foreach($articles as $article){
                            $selected = ($article['numArt'] == $commentaire['numArt']) ? 'selected' : '';
                            echo('<option value="' . $article['numArt'] . '" ' . $selected . '>' . $article['libTitrArt'] . '</option>');
                        }
                        ?>
                    </select>
                </div>
                
                <h2 class="mt-4">Modifier votre message</h2>
                <div class="form-group">
                    <label for="libCom">Commentaire</label>
                    <textarea id="libCom" name="libCom" class="form-control" rows="5"><?php echo($commentaire['libCom']); ?></textarea>
                </div>

                <div class="form-group mt-3">
                    <button type="submit" class="btn btn-clair">Edit</button>
                    <a href="list.php" class="btn btn-moyen">List</a>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include '../../../footer.php'; 
?>