<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$dtCreaCom = ($_GET['dtCreaCom']);

sql_update('COMMENT', 'numCom', "'$dtCreaCom'");


header('Location: ../../views/backend/comments/list.php');