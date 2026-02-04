<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Expecting POST with at least numArt
$numArt = ctrlSaisies($_POST['numArt'] ?? '');
if(empty($numArt)){
    die('Missing article id');
}

// Get article data to retrieve image filename BEFORE deletion
$articles = sql_select('ARTICLE', '*', "numArt = $numArt");
$imageFile = null;
if(!empty($articles) && isset($articles[0]['urlPhotArt'])){
    $imageFile = $articles[0]['urlPhotArt'];
}

// Delete associated keywords
sql_delete('MOTCLEARTICLE',"numArt = $numArt");

// Delete article
sql_delete('ARTICLE',"numArt = $numArt");

// Delete image file after article is deleted from database
if($imageFile && !empty($imageFile)){
    $imagePath = $_SERVER['DOCUMENT_ROOT'] . '/src/uploads/' . basename($imageFile);
    if(file_exists($imagePath)){
        if(!unlink($imagePath)){
            error_log("Failed to delete image file: $imagePath");
        }
    }
}

header('Location: ../../views/backend/articles/list.php');
