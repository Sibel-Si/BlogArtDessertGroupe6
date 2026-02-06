<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$numArt= ($_POST['numArt']);
$numMemb= ($_POST['numMemb']);
$libCom= ($_POST['libCom']);
if(empty($libCom)){
    header('Location: ../../views/backend/comments/list.php');
}


sql_insert('COMMENT', "libCom, numArt, numMemb", " '$libCom', '$numArt', '$numMemb'");

// Redirect back to the list
header('Location: ../../views/backend/comments/list.php');
exit;