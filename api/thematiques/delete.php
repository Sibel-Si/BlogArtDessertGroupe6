<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$numThem = ($_POST['numThem']);
if(empty($numThem)){
    header('Location: ../../views/backend/thematiques/list.php');
}

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

