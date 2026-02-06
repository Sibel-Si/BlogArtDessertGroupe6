<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$libMotCle = ($_POST['libMotCle']);
if(empty($libMotCle)){
    header('Location: ../../views/backend/keywords/list.php');
}

sql_insert('MOTCLE', 'libMotCle', "'$libMotCle'");


header('Location: ../../views/backend/keywords/list.php');