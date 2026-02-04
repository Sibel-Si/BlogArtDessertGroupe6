<?php
include '../../../header.php';

$articles = sql_select("ARTICLE", "*");
$membres = sql_select("MEMBRE", "*");
$commentaires = sql_select("COMMENT", "*");
$libCom = sql_select("COMMENT","libCom");
$affichageNumCom = sql_select("COMMENT", "numCom");

//au clic bouton edit, affichage des données sur les parties correspondantes


// récuparation avec session  puis affichage nom prénom
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Commentaire en attente : Modifier</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/comments/create.php' ?>" method="post">
                <div class="form-group">
                    <label for="numArt">Numéro article</label>
                    <select id="numArt" name="numArt" class="form-control" autofocus="autofocus" >
                        <?php
                        foreach($articles as $article){ //selection numéro commentaire
                            echo('');
                        } //à modifier pour faire en sorte qu'en appuyant sur le bouton, ça affiche directement le numéro de l'article
                        ?>
                    </select>
                </div>
                <br />
                <div class="form-group">
                    <label for="numCom">Numéro commentaire</label>
                    <select id="numCom" name="numCom" class="form-control" autofocus="autofocus" >
                        <?php echo($affichageNumCom["numCom"] = $commentaire['dtCreaCom']);
                            //à modifier pour faire en sorte qu'en appuyant sur le bouton, ça affiche directement le numéro de commentaire qui est égal à la date correspondante dans l'url
                        ?>
                    </select>
                </div>
                <br />
                <div class="form-group">
                    <label for="pseudoMemb" >Pseudo</label>
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value="<?php /*
                    $nomMembActu = sql_select("MEMBRE", "nomMemb", "pseudoMemb =" $pseudoMemb);
                    echo() */?>" disabled/> <!--récup choix id prenom + nom avant de les envoyer-->
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Titre Article</label>
                    <select id="numMemb" name="numMemb" class="form-control" autofocus="autofocus" >
                        <?php
                        foreach($articles as $article){ //selection articles
                            echo('<option value ="'. $article["numArt"]. '">'. $article['libTitrArt']. '</option>');
                        }
                        ?>
                    </select>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Accroche Paragraphe</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value ="" disabled/>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Date de Création Commentaire</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value =<?php //echo($commentaires['dtCreaCom']); ?> disabled/>
                </div>
                <br />
                <h2>Commentaire</h2>
                <div class="form-group">
                    <label for="libStat" class = "disabled">Commentaire à Valider</label>
                    <textarea id="libStat" name="libStat" class="form-control"><?php echo($commentaires["libCom"])?></textarea>
                </div>
                <label class="form-label mt-4">Je valide le commentaire du membre?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="validate" value="oui" required>
                        <label class="form-check-label">Oui</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="validate" value="non" required>
                        <label class="form-check-label">Non</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="libStat" class = "disabled">Si non, en écrire les raisons : </label>
                    <textarea id="libStat" name="libStat" class="form-control"></textarea>
                </div>
                <label class="form-label mt-4">Je souhaite que le commentaire ne soit plus affiché?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="validate" value="oui" required>
                        <label class="form-check-label">Oui</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="validate" value="non" required>
                        <label class="form-check-label">Non</label>
                    </div>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-clair">List</button>
                </div>
                <div class="form-group mt-2">
                    <button type="submit" class="btn btn-clair">Confirmer</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include '../../../footer.php'; // contains the footer
?>