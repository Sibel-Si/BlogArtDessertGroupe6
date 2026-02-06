<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numCom = ($_POST['numCom']);


sql_delete('COMMENT', "numCom = $numCom");


header('Location: ../../views/backend/comments/list.php');