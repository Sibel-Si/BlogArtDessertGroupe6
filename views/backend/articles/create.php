<?php


include '../../../header.php';
check_page_access([1, 2]); 


$articles = sql_select("ARTICLE", "*");
$themes = sql_select("THEMATIQUE", "*");
$motscles = sql_select("MOTCLE", "*");
$motsclesarticles = sql_select("MOTCLEARTICLE", "*");
$motscleschoisis = array();

date_default_timezone_set('Europe/Paris');
?>

<script src="../../../src/js/articles.js"></script>

<!-- Bootstrap form to create a new article -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création nouvel Article</h1>
        </div>
        <div class="col-md-12">
            <!-- Form to create a new article -->
            <form action="<?php echo ROOT_URL . '/api/articles/create.php' ?>" method="post" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="libTitrArt">Nom de l'article</label>
                    <input id="libTitrArt" name="libTitrArt" class="form-control" type="text" autofocus="autofocus" />
                </div>
                <br />
                <div class="form-group">
                    <label for="dtCreaArt">Date de rédaction</label>
                    <input id="dtCreaArt" name="dtCreaArt" class="form-control" type="text" value=<?php echo (date('Y-m-d/H:i:s')) ?> readonly="readonly"/>
                </div>
                <br />
                <div class="form-group">
                    <label for="libChapoArt">Chapeau</label>
                    <textarea id="libChapoArt" name="libChapoArt" class="form-control" maxlength="500">Décrivez le chapeau. Sur 500 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libAccrochArt">Accroche paragraphe 1</label>
                    <textarea id="libAccrochArt" name="libAccrochArt" class="form-control" maxlength="100">Sur 100 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="parag1Art">Paragraphe 1</label>
                    <textarea id="parag1Art" name="parag1Art" class="form-control" maxlength="1200">Sur 1200 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libSsTitr1Art">Sous-titre 1</label>
                    <textarea id="libSsTitr1Art" name="libSsTitr1Art" class="form-control" maxlength="100">Sur 100 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="parag2Art">Paragraphe 2</label>
                    <textarea id="parag2Art" name="parag2Art" class="form-control" maxlength="1200">Sur 1200 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libSsTitr2Art">Sous-titre 2</label>
                    <textarea id="libSsTitr2Art" name="libSsTitr2Art" class="form-control" maxlength="100">Sur 100 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="parag3Art">Paragraphe 3</label>
                    <textarea id="parag3Art" name="parag3Art" class="form-control" maxlength="1200">Sur 1200 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="libConclArt">Conclusion</label>
                    <textarea id="libConclArt" name="libConclArt" class="form-control" maxlength="800">Sur 800 car.</textarea>
                </div>
                <br />
                <div class="form-group">
                    <label for="urlPhotArt">Importez l'illustration</label>
                    <input  id="urlPhotArt" name="urlPhotArt" class="btn btn-fonce" type="file" accept=".jpg, .gif, .png, .jpeg" />
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
                        echo('<option value="' . $theme['numThem'] . '">' . $theme['libThem'] . '</option>');
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
                                    echo('<option value="' . $motcle['numMotCle'] . '">' . $motcle['libMotCle'] . '</option>');
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
                            </select>
                        </div>
                    </div>
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <button type="submit" class="btn btn-clair">Confirmer create ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<?php
include '../../../footer.php'; // contains the footer
?>