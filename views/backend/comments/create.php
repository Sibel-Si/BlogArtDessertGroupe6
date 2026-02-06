<?php

//CREATE
include '../../../header.php';
check_page_access([1, 2]); 


$numMemb = $_SESSION['id_user'] ?? 0;

$articles = sql_select("ARTICLE", "*");

// 1. Fetch the member data
$membre_data = sql_select("MEMBRE", "*", "numMemb = $numMemb");

// 2. Extract the first row [0] if it exists
$membre = !empty($membre_data) ? $membre_data[0] : null;

// 3. Set variables only if member was found
$pseudoMemb = $membre["pseudoMemb"] ?? "Pseudo inconnu";
$prenomMemb = $membre["prenomMemb"] ?? "Prénom inconnu";
$nomMemb    = $membre["nomMemb"]    ?? "Nom inconnu";

$comments = sql_select("COMMENT", "*");


?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création nouveau Commentaire</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/comments/create.php' ?>" method="post">
                <div class="form-group">
                    <input type="hidden" id="numMemb" name="numMemb" class="form-control" type="text" value ="<?php echo($numMemb);?>">
                    <label for="pseudoMemb">Pseudo</label>
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value ="<?php echo($pseudoMemb);?>" disabled>
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
                    <label for="numArt">Articles</label>
                    <select id="numArt" name="numArt" class="form-control" required="required">
                    <option value=""></option>
                    <?php
                    foreach($articles as $article){
                        echo('<option value="' . $article['numArt'] . '">' . $article['libTitrArt'] . '</option>');
                    }
                    ?>
                    </select>
                </div>
                <h2>Commentaire</h2>
                <div class="form-group">
                    <label for="libCom">Commentaire</label>
                    <textarea id="libCom" name="libCom" class="form-control">Ecriver votre commentaire.</textarea>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-clair">Poster</button>
                </div>
            </form>
            <br />
            <!--<h3> Commentaires de l'article :<?php //echo($article)?></h3>
            <h4><?php //echo($commentaire["pseudoMemb"]);?></h4>
            <?php// echo($commentaire["libCom"]);?>
            <br />
            <?php// echo($commentaire["dtCreaCom"]);?> <br /><br />
            <a href="list.php" class="btn btn-moyen">List</a>-->
        </div>
    </div>
</div>

<?php
include '../../../footer.php'; // contains the footer
?>