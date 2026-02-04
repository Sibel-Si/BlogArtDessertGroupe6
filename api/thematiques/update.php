<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numThem = ($_POST['numThem']);
$libThem = ($_POST['libThem']);

// Validate that libThem is not empty
if (empty($libThem)) {
    $_SESSION['error_message'] = "Le nom de la thématique est obligatoire.";
    header('Location: ../../views/backend/thematiques/edit.php?numThem=' . $numThem);
    exit();
}

sql_update('THEMATIQUE', "libThem = '$libThem'", "numThem = $numThem");
$_SESSION['success_message'] = "Thématique mise à jour avec succès.";

header('Location: ../../views/backend/thematiques/list.php');

