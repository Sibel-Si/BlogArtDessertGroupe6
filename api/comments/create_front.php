<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numArt= ($_POST['numArt']);
$numMemb= ($_POST['numMemb']);
$libCom= ($_POST['libCom']);


sql_insert('COMMENT', "libCom, numArt, numMemb", " '$libCom', '$numArt', '$numMemb'");

// Redirect back to the article page instead of the list
header("Location: /views/frontend/articles/article1.php?numArt=" . $numArt);
exit;