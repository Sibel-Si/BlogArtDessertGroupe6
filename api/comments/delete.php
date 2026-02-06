<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins(level 1) to access this specific API
check_api_access([1]);

$numCom = ($_POST['numCom']);
if(empty($numCom)){
    header('Location: ../../views/backend/comments/list.php');
}


sql_delete('COMMENT', "numCom = $numCom");


header('Location: ../../views/backend/comments/list.php');