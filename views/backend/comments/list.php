<?php
include '../../../header.php'; // contains the header and call to config.php


//Load all statuts

$commentairesattente = sql_select('COMMENT', "*", 'attModOK = 0 AND delLogiq = 0');
$commentaireOK = sql_select('COMMENT', "*", 'attModOK = 1 AND delLogiq = 0');
$articles = sql_select("ARTICLE", "*");
$commentaireSupLog = sql_select('COMMENT', "*", 'delLogiq = 1');
$membres = sql_select("MEMBRE", "*");

//test de requetes sql

// $commentairesinfos = sql_select("COMMENT", "numCom, numArt, numMemb", "comment.numMemb = membre.numMemb and comment.numArt = article.libTitrArt");
// SELECT 
//      COMMENT.numCom,
//      comment.numArt,
//      comment.numMemb
//  FROM
//      comment, membre, article
// WHERE comment.numMemb = membre.pseudoMemb and comment.numArt = article.libTitrArt;

// var_dump($commentairemechant);

?>

<!-- Bootstrap default layout to display all statuts in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Commentaires</h1>
            <h2> Commentaires en attente</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Titre Article</th>
                        <th>Pseudo</th>
                        <th>Date</th>
                        <th>Contenu</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    foreach($commentairesattente as $commentaire){ ?>
                        <tr>
                            <td><?php 
                            // $intMemb = ["numArt"]-1;
                            echo($commentaire['numArt']); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["numMemb"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['dtCreaCom']); ?></td>
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td>
                                <a href="control.php?dtCreaCom=<?php echo($commentaire['dtCreaCom']); ?>" class="btn btn-primary">Control</a>
                                <a href="edit.php?dtCreaCom=<?php echo($commentaire['dtCreaCom']); ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h2> Commentaires contrôlés</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Date de Dernière Modification</th>
                        <th>Contenu</th>
                        <th>Etat Publication</th>
                        <th>Raison Refus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($commentaireOK as $commentaire){ ?>
                        <tr>
                            <td><?php echo($commentaire['numMemb']); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["dtModCom"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td><?php echo($commentaire['attModOK']); ?></td>
                            <td><?php echo($commentaire['notifComKOAff']); ?></td>
                            <td>
                                <a href="edit.php?dtCreaCom=<?php echo($commentaire['dtCreaCom']); ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h2> Suppression logique</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Date Suppression Logique</th>
                        <th>Contenu</th>
                        <th>Publication</th>
                        <th>Raison refus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($commentaireSupLog as $commentaire){ ?>
                        <tr>
                            <td><?php echo($commentaire['numMemb']); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["dtDelLogCom"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td><?php echo($commentaire['delLogiq']); ?></td>
                            <td><?php echo($commentaire['notifComKOAff']); ?></td>
                            <td>
                                <a href="edit.php?dtCreaCom=<?php echo($commentaire['dtCreaCom']); ?>" class="btn btn-warning">Edit</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <h2> Suppression physique</h2>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Pseudo</th>
                        <th>Date Suppression Physique</th>
                        <th>Contenu</th>
                        <th>Publication</th>
                        <th>Raison refus</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($commentaireSupLog as $commentaire){ ?>
                        <tr>
                            <td><?php echo($commentaire['numMemb']); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["dtDelLogCom"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td><?php echo($commentaire['delLogiq']); ?></td>
                            <td><?php echo($commentaire['notifComKOAff']); ?></td>
                            <td>
                                <a href="delete.php?dtCreaCom=<?php echo($commentaire['dtCreaCom']); ?>" class="btn btn-danger">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--à verifier pour clic bouton si membre connecté-->
            <a href="create.php" class="btn btn-success">Create</a>
        </div>
    </div>
</div>
<?php
include '../../../footer.php'; // contains the footer