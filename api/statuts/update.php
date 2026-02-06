<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$libStat = ($_POST['libStat']);
$numStat = ($_POST['numStat']);
if(empty($libStat)){
    header('Location: ../../views/backend/statuts/list.php');
}

sql_update('STATUT', "libStat = '$libStat'", "numMotCle = $numStat");

header('Location: ../../views/backend/statuts/list.php');