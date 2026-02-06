<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);




$articleData = [
    'libTitrArt' => ctrlSaisies($_POST['libTitrArt'] ?? ''),
    'dtCreaArt' => ctrlSaisies($_POST['dtCreaArt'] ?? ''),
    'libChapoArt' => ctrlSaisies($_POST['libChapoArt'] ?? ''),
    'libAccrochArt' => ctrlSaisies($_POST['libAccrochArt'] ?? ''),
    'parag1Art' => ctrlSaisies($_POST['parag1Art'] ?? ''),
    'libSsTitr1Art' => ctrlSaisies($_POST['libSsTitr1Art'] ?? ''),
    'parag2Art' => ctrlSaisies($_POST['parag2Art'] ?? ''),
    'libSsTitr2Art' => ctrlSaisies($_POST['libSsTitr2Art'] ?? ''),
    'parag3Art' => ctrlSaisies($_POST['parag3Art'] ?? ''),
    'libConclArt' => ctrlSaisies($_POST['libConclArt'] ?? ''),
    'numThem' => ctrlSaisies($_POST['numThem'] ?? ''),
    'numMotCle' => $_POST['numMotCle'] ?? [],
    'urlPhotArt' => '',
];
$test = $articleData["libTitrArt"];
if(empty($test)){
    header('Location: ../../views/backend/articles/list.php');
}

require_once '../../functions/upload_image.php';

sql_insert(
    'ARTICLE',
    'libTitrArt, dtCreaArt, libChapoArt, libAccrochArt, parag1Art, libSsTitr1Art, parag2Art, libSsTitr2Art, parag3Art, libConclArt, urlPhotArt, numThem',
    "'{$articleData['libTitrArt']}', '{$articleData['dtCreaArt']}', '{$articleData['libChapoArt']}', '{$articleData['libAccrochArt']}', '{$articleData['parag1Art']}', '{$articleData['libSsTitr1Art']}', '{$articleData['parag2Art']}', '{$articleData['libSsTitr2Art']}', '{$articleData['parag3Art']}', '{$articleData['libConclArt']}','{$articleData['urlPhotArt']}', '{$articleData['numThem']}'"
);

$articleRows = sql_select('ARTICLE', 'numArt', "libTitrArt = '{$articleData['libTitrArt']}'");
$articleNum = null;
if(!empty($articleRows) && isset($articleRows[0]['numArt'])){
    $articleNum = $articleRows[0]['numArt'];
}

$numMotCles = $articleData['numMotCle'];
if($articleNum && is_array($numMotCles)){
    foreach($numMotCles as $numMotCle){
        $numMotCle = ctrlSaisies($numMotCle);
        sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', "{$articleNum}, {$numMotCle}");
    }
}

header('Location: ../../views/backend/articles/list.php');