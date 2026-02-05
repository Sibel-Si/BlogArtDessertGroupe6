<?php

include '../../../header.php'; // contains the header and call to config.php

//Load all statuts


$commentairesattente = sql_select('COMMENT', "*", 'attModOK = 0 AND delLogiq = 0');
$commentaireOK = sql_select('COMMENT', "*", 'attModOK = 1 AND delLogiq = 0');
$commentaireSupLog = sql_select('COMMENT', "*", 'delLogiq = 1');
$infosMembArt = sql_select("comment INNER JOIN article ON article.numArt = comment.numArt INNER JOIN membre ON comment.numMemb=membre.numMemb", "*");
$infosMembArt = $infosMembArt[0];

//SELECT * FROM article INNER JOIN membre ON article.numMemb = membre.numMemb;


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
                            <td><?php echo($infosMembArt["libTitrArt"]); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($infosMembArt["pseudoMemb"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['dtCreaCom']); ?></td>
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td>
                                <a href="control.php?numCom=<?php echo($commentaire['numCom']); ?>" class="btn btn-clair">Control</a>
                                <a href="edit.php?numCom=<?php echo($commentaire['numCom']); ?>" class="btn btn-moyen">Edit</a>
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
                            <td><?php echo($infosMembArt["pseudoMemb"]); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["dtModCom"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td><?php echo($commentaire['attModOK']); ?></td>
                            <td><?php echo($commentaire['notifComKOAff']); ?></td>
                            <td>
                                <a href="edit.php?numCom=<?php echo($commentaire['numCom']); ?>" class="btn btn-clair">Edit</a>
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
                            <td><?php echo($infosMembArt["pseudoMemb"]); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["dtDelLogCom"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td><?php echo($commentaire['delLogiq']); ?></td>
                            <td><?php echo($commentaire['notifComKOAff']); ?></td>
                            <td>
                                <a href="edit.php?numCom=<?php echo($commentaire['numCom']); ?>" class="btn btn-moyen">Edit</a>
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
                            <td><?php echo($infosMembArt["pseudoMemb"]); ?></td> <!--faire en sorte de mettre le titre des articles-->
                            <td><?php echo($commentaire["dtDelLogCom"]); ?></td> <!-- idem pour pseudo-->
                            <td><?php echo($commentaire['libCom']); ?></td>
                            <td><?php echo($commentaire['delLogiq']); ?></td>
                            <td><?php echo($commentaire['notifComKOAff']); ?></td>
                            <td>
                                <a href="delete.php?numCom=<?php echo($commentaire['numCom']); ?>" class="btn btn-fonce">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <!--à verifier pour clic bouton si membre connecté-->
            <a href="create.php" class="btn btn-clair">Create</a>
        </div>
    </div>
</div>
<?php
include '../../../footer.php'; // contains the footer