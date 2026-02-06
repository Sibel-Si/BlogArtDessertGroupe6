<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

// Expecting POST with at least numArt
$numArt = ctrlSaisies($_POST['numArt'] ?? '');
if(empty($numArt)){
    header('Location: ../../views/backend/articles/list.php');
}

// Fetch current article to get old image filename
$currentArticles = sql_select('ARTICLE', 'urlPhotArt', "numArt = $numArt");
$oldImageFile = null;
if(!empty($currentArticles) && isset($currentArticles[0]['urlPhotArt'])){
    $oldImageFile = $currentArticles[0]['urlPhotArt'];
}

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
    'urlPhotArt' => $oldImageFile ?: '',
];

// Handle file upload and update urlPhotArt if new file is uploaded
require_once '../../functions/upload_image.php';

// If a new image was uploaded, delete the old one
if($oldImageFile && $articleData['urlPhotArt'] !== $oldImageFile){
    $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . basename($oldImageFile);
    if(file_exists($oldImagePath)){
        if(!unlink($oldImagePath)){
            error_log("Failed to delete old image file: $oldImagePath");
        }
    }
}

// Build SET clause for sql_update
$set = [];
$set[] = "libTitrArt = '" . addslashes($articleData['libTitrArt']) . "'";
$set[] = "dtCreaArt = '" . addslashes($articleData['dtCreaArt']) . "'";
$set[] = "libChapoArt = '" . addslashes($articleData['libChapoArt']) . "'";
$set[] = "libAccrochArt = '" . addslashes($articleData['libAccrochArt']) . "'";
$set[] = "parag1Art = '" . addslashes($articleData['parag1Art']) . "'";
$set[] = "libSsTitr1Art = '" . addslashes($articleData['libSsTitr1Art']) . "'";
$set[] = "parag2Art = '" . addslashes($articleData['parag2Art']) . "'";
$set[] = "libSsTitr2Art = '" . addslashes($articleData['libSsTitr2Art']) . "'";
$set[] = "parag3Art = '" . addslashes($articleData['parag3Art']) . "'";
$set[] = "libConclArt = '" . addslashes($articleData['libConclArt']) . "'";
$set[] = "urlPhotArt = '" . addslashes($articleData['urlPhotArt']) . "'";
$set[] = "numThem = '" . addslashes($articleData['numThem']) . "'";

$sqlSet = implode(', ', $set);

// Update ARTICLE
sql_update('ARTICLE', $sqlSet, "numArt = {$numArt}");

// Replace keywords: delete existing, then insert selected
sql_delete('MOTCLEARTICLE', "numArt = {$numArt}");

if(is_array($articleData['numMotCle'])){
    foreach($articleData['numMotCle'] as $numMotCle){
        $numMotCle = ctrlSaisies($numMotCle);
        if($numMotCle === '') continue;
        sql_insert('MOTCLEARTICLE', 'numArt, numMotCle', "{$numArt}, {$numMotCle}");
    }
}

header('Location: ../../views/backend/articles/list.php');
