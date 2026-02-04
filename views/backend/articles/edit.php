<?php


include '../../../header.php';

// Get the article ID from URL parameter
$numArt = isset($_GET['numArt']) ? (int)$_GET['numArt'] : 0;

// Validate article ID exists before querying
if ($numArt <= 0) {
    header("Location: list.php");
    exit;
}

// Fetch the specific article to edit
$article = sql_select("ARTICLE", "*", "numArt = $numArt");
$article = !empty($article) ? $article[0] : null;

if (!$article) {
    header("Location: list.php");
    exit;
}

$themes = sql_select("THEMATIQUE", "*");
$motscles = sql_select("MOTCLE", "*");
$motsclesarticles = sql_select("MOTCLEARTICLE", "*", "numArt = $numArt");

// Build array of selected keywords for this article
$motscleschoisis = array();
foreach($motsclesarticles as $mca) {
    $motscleschoisis[] = $mca['numMotCle'];
}
?>

<script src="../../../src/js/articles.js"></script>

<!-- Bootstrap form to edit article -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modify Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to edit article -->
            <form action="<?php echo ROOT_URL . '/api/articles/update.php' ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="numArt" value="<?php echo htmlspecialchars($article['numArt']); ?>" />
                <div class="form-group">
                    <label for="libTitrArt">Nom de l'article</label>
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" value="<?php echo htmlspecialchars($article['libTitrArt']); ?>" autofocus="autofocus" />
                </div>
                <br />
                <div class="form-group">
                    <label for="dtCreaArt">Date de rédaction</label>
                    <input id="dtCreaArt" name="dtCreaArt" class="form-control" type="text" value="<?php echo htmlspecialchars($article['dtCreaArt']); ?>" readonly="readonly"/>
                </div>
                <br />
                <div class="form-group">
                    <label for="libChapoArt">Chapeau</label>
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control" maxlength="500"><?php echo htmlspecialchars($article['libChapoArt']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libAccrochArt">Accroche paragraphe 1</label>
                    <textarea id="libAccrochArt" name="libAccrochArt" class="form-control" maxlength="100"><?php echo htmlspecialchars($article['libAccrochArt']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="parag1Art">Paragraphe 1</label>
                    <textarea id="parag1Art" name="parag1Art" class="form-control" maxlength="1200"><?php echo htmlspecialchars($article['parag1Art']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libSsTitr1Art">Sous-titre 1</label>
                    <textarea id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" maxlength="100"><?php echo htmlspecialchars($article['libSsTitr1Art']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="parag2Art">Paragraphe 2</label>
                    <textarea id="parag2Art" name="parag2Art" class="form-control" maxlength="1200"><?php echo htmlspecialchars($article['parag2Art']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libSsTitr2Art">Sous-titre 2</label>
                    <textarea id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" maxlength="100"><?php echo htmlspecialchars($article['libSsTitr2Art']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="parag3Art">Paragraphe 3</label>
                    <textarea id="parag3Art" name="parag3Art" class="form-control" maxlength="1200"><?php echo htmlspecialchars($article['parag3Art']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libConclArt">Conclusion</label>
                    <textarea id="libConclArt" name="libConclArt" class="form-control" maxlength="800"><?php echo htmlspecialchars($article['libConclArt']); ?></textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="urlPhotArt">Importez l'illustration</label>
                    <input id="urlPhotArt" name="urlPhotArt" class="btn btn-fonce" type="file" accept=".jpg, .gif, .png, .jpeg" />
                    <p>>> Extension des images acceptées : .jpg, .gif, .png, .jpeg<br />
                    (largeur, hauteur, taille max : 80000px, 80000px, 200 000 Go)</p>
                </div>
                <br />
                <div class="form-group">
                    <label for="numThem">Thématique</label>
                    <select id="numThem" name="numThem" class="form-control" autofocus="autofocus" required="required">
                    <option value=""></option>
                    <?php
                    foreach($themes as $theme){
                        $selected = ($theme['numThem'] == $article['numThem']) ? 'selected="selected"' : '';
                        echo('<option value="' . $theme['numThem'] . '" ' . $selected . '>' . $theme['libThem'] . '</option>');
                    }
                    ?>
                    </select>
                </div>
                <br />
                <div class="form-group">
                    <label for="numMotCleAvailable">Choisir les mots clés</label>
                    <div class="d-flex">
                        <div class="flex-fill me-2">
                            <select id="numMotCleAvailable" name="numMotCleAvailable" size=<?php echo(count($motscles)+1); ?> multiple="multiple" class="form-control">
                                <?php
                                foreach($motscles as $motcle){
                                    $isSelected = in_array($motcle['numMotCle'], $motscleschoisis) ? true : false;
                                    if (!$isSelected) {
                                        echo('<option value="' . $motcle['numMotCle'] . '">' . $motcle['libMotCle'] . '</option>');
                                    }
                                }
                                ?>
                            </select>
                        </div>
                        <div class="d-flex flex-column justify-content-center">
                            <button id="addBtn" type="button" class="btn btn-fonce mb-2">Ajouter &gt;</button>
                            <button id="removeBtn" type="button" class="btn btn-fonce">&lt; Supprimer</button>
                        </div>
                        <div class="flex-fill ms-2">
                            <select id="numMotCle[]" name="numMotCle[]" class="form-control" required="required" size=<?php echo(count($motscles)+1); ?> multiple="multiple">
                                <!-- chosen keywords will appear here -->
                                <?php
                                foreach($motscles as $motcle){
                                    if (in_array($motcle['numMotCle'], $motscleschoisis)) {
                                        echo('<option value="' . $motcle['numMotCle'] . '" selected="selected">' . $motcle['libMotCle'] . '</option>');
                                    }
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <button type="submit" class="btn btn-clair">Confirmer modification</button>
                </div>
            </form>
        </div>
    </div>
</div>
