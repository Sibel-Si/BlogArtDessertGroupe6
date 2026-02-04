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

// Check if the thematique is being used by any article
$articlesWithThem = sql_select('ARTICLE', 'COUNT(*) as count', "numThem = $numThem");
$articleCount = $articlesWithThem[0]['count'] ?? 0;

if ($articleCount > 0) {
    // Thematique cannot be deleted because it's associated with articles
    $_SESSION['error_message'] = "Impossible de supprimer cette thématique : $articleCount article(s) utilise(nt) cette thématique.";
    header('Location: ../../views/backend/thematiques/delete.php?numThem=' . $numThem);
    exit();
}

// Proceed with deletion
sql_delete('THEMATIQUE', "numThem = $numThem");
$_SESSION['success_message'] = "Thématique supprimée avec succès.";

header('Location: ../../views/backend/thematiques/list.php');

