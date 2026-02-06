<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$libThem = ($_POST['libThem']);
if(empty($libThem)){
    header('Location: ../../views/backend/thematiques/list.php');
}

sql_insert('THEMATIQUE', 'libThem', "'$libThem'");


header('Location: ../../views/backend/thematiques/list.php');