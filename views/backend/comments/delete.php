<?php
if(!isset($_GET["numCom"])){
    header("Location:list.php");
    exit();
}

include '../../../header.php';

$numCom = intval($_GET["numCom"]);

$commentaire = sql_select("comment INNER JOIN article ON comment.numArt = article.numArt INNER JOIN membre ON comment.numMemb=membre.numMemb", "*", "numCom = ".$numCom);
$commentaire = $commentaire[0];
// var_dump($commentaire);
// récuparation avec session puis affichage nom prénom
?>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <br />
            <h1>Modération Commentaire : Suppression Logique</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new statut -->
            <form action="<?php echo ROOT_URL . '/api/comments/delete.php' ?>" method="get">
                <div class="form-group">
                    <label for="numArt">Numéro article</label>
                    <input id="numArt" name="numArt" class="form-control" type ="text" value ="<?php echo($commentaire["numArt"]);?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="numCom">Numéro commentaire</label>
                    <input id="numCom" name="numCom" class="form-control" type="text" value="<?php echo($commentaire["numCom"]);?>" disabled>

                </div>
                <br />
                <div class="form-group">
                    <label for="pseudoMemb" >Pseudo</label>
                    <input id="pseudoMemb" name="pseudoMemb" class="form-control" type="text" value="<?php echo($commentaire["pseudoMemb"]);?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" >Titre Article</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo $commentaire["libTitrArt"] ?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat">Accroche Paragraphe</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value="<?php echo $commentaire["libAccrochArt"] ?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="dtCreaCom">Date de Création Commentaire</label>
                    <input id="dtCreaCom" name="dtCreaCom" class="form-control" type="text" value ="<?php echo $commentaire["dtCreaCom"] ?>" disabled>
                </div>
                <br />
                <div class="form-group">
                    <label for="libStat" class = "disabled">Date de Modération Commentaire</label>
                    <input id="libStat" name="libStat" class="form-control" type="text" value ="<?php echo($commentaire["dtModCom"]);?>" disabled>
                </div>
                <br />
                <h2>Commentaire</h2>
                <div class="form-group">
                    <label for="libStat" class = "disabled">Commentaire à Valider/Validé</label>
                    <textarea id="libStat" name="libStat" class="form-control"><?php echo($commentaire["libCom"]);?></textarea>
                </div>
                <label class="form-label mt-4">Je valide le commentaire du membre?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="attModOK" value="oui" required>
                        <label class="form-check-label">Oui</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="attModOK" value="non" required>
                        <label class="form-check-label">Non</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="notifComKOAff" class = "disabled">Si non, en écrire les raisons : </label>
                    <textarea id="notifComKOAff" name="notifComKOAff" class="form-control"></textarea>
                </div>
                <label class="form-label mt-4">Je souhaite que le commentaire ne soit plus affiché?</label>
                <div class="d-flex gap-3">
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="afficheoui" value="oui" required>
                        <label class="form-check-label">Oui</label>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="radio" name="affichenon" value="non" required>
                        <label class="form-check-label">Non</label>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dtCreaCom">Date de Suppression Commentaire</label>
                    <input id="dtCreaCom" name="dtCreaCom" class="form-control" type="text" value ="<?php echo($commentaire["dtDelLogCom"]); ?>" disabled>
                </div>
                <br />
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