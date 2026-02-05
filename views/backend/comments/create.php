<?php

//CREATE NON AFFICHE
include '../../../header.php';

// $numCom = intval($_GET["numCom"]);
//SELECT * FROM article INNER JOIN membre ON article.numMemb = membre.numMemb;
$commentaire = sql_select("comment INNER JOIN membre ON comment.numMemb = membre.numMemb INNER JOIN article ON comment.numArt = article.numArt", "*");
$commentaire = $commentaire[0];
$articles = sql_select("article", "*");
// var_dump($commentaire);

$identi = sql_select("membre", "*", "numMemb");
// var_dump($identi[5-1]);
$identifiant =$identi[$_SESSION["id_user"]-1];
// $identifiant = array_search($_SESSION["id_user"], $identi);
//sql table membres pseudo nom prénom, num membre = id_user session

// récuparation avec session  puis affichage nom prénom
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création nouveau Commentaire</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/comments/create.php' ?>" method="get">
                <div class="form-group">
                    <label for="pseudoMemb">Pseudo</label>
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value ="<?php echo($identifiant["pseudoMemb"]);?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" >Nom</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo($identifiant["nomMemb"]);?>"/> <!--récup choix id prenom + nom avant de les envoyer-->
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Prenom</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo($identifiant["prenomMemb"]);?>"/>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Choix d'article</label>
                    <select id="numMemb" name="numMemb" class="form-control" autofocus="autofocus" >
                        <?php
                        foreach($articles as $article){ //selection articles
                            echo('<option value ="'. $article["numArt"]. '">'. $article['libTitrArt']. '</option>');
                        }
                        ?>
                    </select>
                </div>
                <h2>Commentaire</h2>
                <div class="form-group">
                    <label for="libStat" class = "disabled">Création d'un commentaire</label>
                    <textarea id="libStat" name="libStat" placeholder ="Entrez le commentaire" class="form-control"></textarea>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-clair">Poster</button>
                </div>
            </form>
            <br />
            <h3> Commentaires de l'article :<?php echo($commentaire["numCom"])?></h3>
            <h4><?php echo($commentaire["pseudoMemb"]);?></h4>
            <?php echo($commentaire["libCom"]);?>
            <br />
            <?php echo($commentaire["dtCreaCom"]);?> <br /><br />
            <a href="list.php" class="btn btn-moyen">List</a>
        </div>
    </div>
</div>

<?php
include '../../../footer.php'; // contains the footer
?>