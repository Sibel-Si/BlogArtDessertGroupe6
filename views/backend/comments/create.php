<?php

include '../../../header.php';

$articles = sql_select("ARTICLE", "*");
$membres = sql_select("MEMBRE", "*");
$commentaires = sql_select("COMMENT", "*");

// récuparation avec session  puis affichage nom prénom
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
                    <label for="numMemb">Pseudo</label>
                    <select id="numMemb" name="numMemb" class="form-control" autofocus="autofocus" >
                        <?php
                        foreach($membres as $membre){ //selection membre par pseudo
                            echo('<option value ="'. $membre["numMemb"]. '">'. $membre['pseudoMemb']. '</option>');
                        }
                        ?>
                    </select>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" >Nom</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php /*
                    $nomMembActu = sql_select("MEMBRE", "nomMemb", "pseudoMemb =" $pseudoMemb);
                    echo() */?>" disabled/> <!--récup choix id prenom + nom avant de les envoyer-->
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Prenom</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" />
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
                    <textarea id="libStat" name="libStat" class="form-control">Entrez le commentaire</textarea>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-clair">Poster</button>
                </div>
            </form>
            <h3> Commentaires de l'article :<?php echo("")?></h3>
            
            <a href="list.php" class="btn btn-moyen">List</a>
        </div>
    </div>
</div>

<?php
include '../../../footer.php'; // contains the footer
?>