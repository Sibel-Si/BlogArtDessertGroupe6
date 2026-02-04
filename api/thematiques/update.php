<?php
session_start();
require_once ROOT_URL . '/functions/security.php';

// Define the required level (e.g., 1 for Admin, 2 for Moderator)
$required_level = 1; 

if (!check_access($required_level)) {
    // Redirect unauthorized users to login or an error page
    header("Location: login.php?error=unauthorized");
    exit(); // Always exit after a header redirect
}

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

