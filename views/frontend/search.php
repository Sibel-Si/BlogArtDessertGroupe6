<?php
require_once '../../header.php';

$recherFinal = [];
$motcles_raw = isset($_GET["recherche"]) ? trim($_GET["recherche"]) : "";

if (!empty($motcles_raw)) {
    $motcles = explode(" ", $motcles_raw);
    $tab_champs = ["libTitrArt", "libChapoArt", "libAccrochArt", "parag1Art", "libSsTitr1Art", "parag2Art", "libSsTitr2Art", "parag3Art", "libConclArt"];
    $where = "";

    foreach ($motcles as $cle => $motcle) {
        if ($cle > 0) { $where .= " AND "; }
        $where .= "(";
        $conditions = [];
        foreach ($tab_champs as $champ) {
            $conditions[] = $champ . " LIKE '%" . $motcle . "%'";
        }
        $where .= implode(" OR ", $conditions);
        $where .= ")";
    }

    // UPDATED: Added numArt and urlPhotArt to the SELECT list
    $recherFinal = sql_select("ARTICLE", "numArt, libTitrArt, libChapoArt, libAccrochArt, urlPhotArt", $where);
}
?>

<div class="container py-5 home-articles">
    <h2>Rechercher par mots clés</h2>
    
    <nav class="navbar mb-5">
        <div class="container-fluid">
            <form class="d-flex w-100" role="search" action="<?= $_SERVER["PHP_SELF"] ?>" method="get">
                <input class="form-control " id="recherche" name="recherche" type="search" 
                       placeholder="Rechercher sur le site..." aria-label="Search" 
                       value="<?= htmlspecialchars($motcles_raw) ?>">
                <button class="btn btn-fonce" type="submit">Rechercher</button>
            </form>
        </div>
    </nav>

    <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-4">
        <?php if (!empty($recherFinal)): ?>
            <?php foreach ($recherFinal as $a): 
                $img = !empty($a['urlPhotArt'])
                  ? "/src/uploads/" . $a['urlPhotArt']
                  : "/src/images/article.png";
            ?>
                <div class="col">
                    <a href="/views/frontend/articles/article1.php?numArt=<?= (int)$a['numArt'] ?>"
                       class="text-decoration-none text-reset">
                        <article class="card h-100">
                            <img src="<?= htmlspecialchars($img) ?>" class="card-img-top" alt="Image article">
                            <div class="card-body">
                                <h5 class="card-title mb-2">
                                    <?= htmlspecialchars($a['libTitrArt'] ?? '') ?>
                                </h5>
                                <p class="card-text mb-2">
                                    <?= htmlspecialchars($a['libChapoArt'] ?? '') ?>
                                </p>
                                <p class="card-text">
                                    <small class="text-muted">
                                        <?= htmlspecialchars($a['libAccrochArt'] ?? '') ?>
                                    </small>
                                </p>
                            </div>
                        </article>
                    </a>
                </div>
            <?php endforeach; ?>
        <?php elseif (!empty($motcles_raw)): ?>
            <div class="col-12">
                <p class="text-muted">Aucun article ne correspond à votre recherche.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php
require_once '../../footer.php';
?>