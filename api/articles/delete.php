<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$numArt = ctrlSaisies($_POST['numArt'] ?? '');
if(empty($numArt)){
    header('Location: ../../views/backend/articles/list.php');
    exit();
}

// Dependency Check: Block if there are comments
$comments = sql_select('COMMENT', 'COUNT(*) as count', "numArt = $numArt");
$commentCount = $comments[0]['count'] ?? 0;

if ($commentCount > 0) {
    $_SESSION['error_message'] = "Impossible de supprimer cet article : $commentCount commentaire(s) y sont attaché(s). Supprimez les commentaires d'abord.";
    header('Location: ../../views/backend/articles/delete.php?numArt=' . $numArt);
    exit();
}

// Get article data for image cleanup
$articles = sql_select('ARTICLE', '*', "numArt = $numArt");
$imageFile = (!empty($articles) && isset($articles[0]['urlPhotArt'])) ? $articles[0]['urlPhotArt'] : null;

// 1. Delete links with keywords (safe to delete automatically)
sql_delete('MOTCLEARTICLE', "numArt = $numArt");

// 2. Delete the article
sql_delete('ARTICLE', "numArt = $numArt");

// 3. Delete physical image file
if($imageFile){
    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . basename($imageFile);
    if(file_exists($imagePath)){
        unlink($imagePath);
    }
}

$_SESSION['success_message'] = "Article supprimé avec succès.";
header('Location: ../../views/backend/articles/list.php');
exit();