<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$numThem = ($_POST['numThem']);
$libThem = ($_POST['libThem']);
if(empty($libThem)){
    header('Location: ../../views/backend/thematiques/list.php');
}

// Validate that libThem is not empty
if (empty($libThem)) {
    $_SESSION['error_message'] = "Le nom de la thématique est obligatoire.";
    header('Location: ../../views/backend/thematiques/edit.php?numThem=' . $numThem);
    exit();
}

sql_update('THEMATIQUE', "libThem = '$libThem'", "numThem = $numThem");
$_SESSION['success_message'] = "Thématique mise à jour avec succès.";

header('Location: ../../views/backend/thematiques/list.php');

