<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$libStat = ($_POST['libStat']);
$numStat = ($_POST['numStat']);

sql_update('STATUT', "libStat = '$libStat'", "numMotCle = $numStat");

header('Location: ../../views/backend/statuts/list.php');