<?php
require_once '../../header.php';


?>

<?php 

//SELECT libTitrArt FROM article WHERE libTitrArt LIKE '%n%';

$motcle = $_GET["recherche"] ?? "";
$recherche = null;
$recherFinal = null;

//si motcle existe, on la place dans une variable
if(isset($motcle)){
    $recherFinal = sql_select("ARTICLE", "libTitrArt", "libTitrArt LIKE '%$motcle%'");
}

// var_dump($_SERVER);
?>

<!-- <h1>Recherche Avancée</h1>
<h2>Rechercher par thèmes</h2>
<h2>Recherche libre</h2> -->

<br/>
<!--search bar de la page-->
<h2>Rechercher par mots clés</h2>
<br />
    <nav class="navbar bg-body-tertiary">
    <div class="container-fluid">
        <form class="d-flex" role="search"  action="<?php echo($_SERVER["PHP_SELF"]) ?>" method="get">
        <input class="form-control me-2" id="recherche" name ="recherche" type="search" placeholder="Rechercher sur le site..." aria-label="Search" value="<?php echo($motcle) ?>">
        </form>
    </div>
    </nav>

<!--tableau d'affichage-->
<table class="table">
<thead>
    <tr>
        <th scope="col">Résultats Mots Clés</th>
    </tr>
</thead>
<tbody>
    <tr>
        <td><?php 
        foreach ($recherFinal as $recherche){ //affichage des recherches
            echo($recherche)["libTitrArt"];
            ?><br /><?php
        }
        // var_dump($recherFinal);
        ?></td>
    </tr>
</tbody>
</table>


<?php
require_once '../../footer.php';
?>