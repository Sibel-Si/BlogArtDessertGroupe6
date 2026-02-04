<?php
require_once '../../header.php';

?>
<!-- <h1>Recherche Avancée</h1>
<h2>Rechercher par thèmes</h2>
<h2>Recherche libre</h2> -->
<br/>
<h2>Rechercher par mots clés</h2>

<?php 

//SELECT * FROM article WHERE libTitrArt LIKE '%n%';

//on reprend avec un $_post les éléments placés dans la barre de recherche
$motcle= $_POST["recherche"];

//si motcle existe, on la place dans une variable
if(isset($motcle)){
    $rechercheTitr = $motcle["recherche"];
}

//on fait une recherche dans la BDD avec les requetes souhaitees
$recherFinal = sql_select("ARTICLE", "*", "libTitrArt LIKE '%$rechercheTitr%'");

?>
<?php echo($recherFinal); ?>

<?php
require_once '../../footer.php';
?>