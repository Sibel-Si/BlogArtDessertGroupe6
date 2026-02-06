<?php


include '../../../header.php'; // contains the header and call to config.php
check_page_access([1, 2]); 


//Load all aticles
$articles = sql_select("ARTICLE", "*");
$themes = sql_select("THEMATIQUE", "*");
$motscles = sql_select("MOTCLE", "*");
$motsclesarticles = sql_select("MOTCLEARTICLE", "*");

?>

<!-- Bootstrap default layout to display all statuts in foreach -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Articles</h1>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Date</th>
                        <th>Titre</th>
                        <th>Chapeau</th>
                        <th>Accroche</th>
                        <th>Mots clés</th>
                        <th>Thématiques</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($articles as $article){ ?>
                        <tr>
                            <td><?php echo($article['numArt']); ?></td>
                            <td><?php echo($article['dtCreaArt']); ?></td>
                            <td><?php echo($article['libTitrArt']); ?></td>
                            <td><?php echo(substr(strip_tags($article['libChapoArt']), 0, 80) . '...' ); ?></td>
                            <td><?php echo($article['libAccrochArt']); ?></td>
                            <td><?php 
                                $listIndMots = array();
                                foreach($motsclesarticles as $motclearticle){
                                    if($motclearticle['numArt'] == $article['numArt']){
                                        $listIndMots[] = $motclearticle['numMotCle'];
                                    }
                                }
                                $listMots = "";
                                foreach($listIndMots as $indMot){
                                    $indMot = $indMot - 1;
                                    $listMots .= $motscles[$indMot]['libMotCle'] . ", ";
                                }
                                $listMots = rtrim($listMots, ", ");
                                echo($listMots); ?></td>
                            <td><?php 
                                $indThem = $article['numThem'] - 1;
                                echo($themes[$indThem]['libThem']); ?></td> 
                            <td>
                                <a href="edit.php?numArt=<?php echo($article['numArt']); ?>" class="btn btn-moyen">Edit</a>
                                <a href="delete.php?numArt=<?php echo($article['numArt']); ?>" class="btn btn-fonce">Delete</a>
                            </td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
            <a href="create.php" class="btn btn-clair">Create</a>
        </div>
    </div>
</div>
<?php
include '../../../footer.php'; // contains the footer