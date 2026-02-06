<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$numCom = ($_POST['numCom']);
$libCom = ($_POST['libCom']);
if(empty($numCom)){
    header('Location: ../../views/backend/comments/list.php');
}

sql_update('COMMENT', "libCom = '$libCom'", "numCom = $numCom");

header('Location: ../../views/backend/comments/list.php');