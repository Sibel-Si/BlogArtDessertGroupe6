<?php

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// Only allow Admins and mods(level 1 & 2) to access this specific API
check_api_access([1,2]);

$numMotCle = ($_POST['numMotCle']);
if(empty($numMotCle)){
    header('Location: ../../views/backend/keywords/list.php');
    exit();
}

// Check if the keyword is being used by any article
$articleWithMotCle = sql_select('MOTCLEARTICLE', 'COUNT(*) as count', "numMotCle = $numMotCle");
$articleCount = $articleWithMotCle[0]['count'] ?? 0;

if ($articleCount > 0) {
    // Blocked deletion
    $_SESSION['error_message'] = "Impossible de supprimer ce mot clé : $articleCount article(s) utilise(nt) ce mot clé.";
    header('Location: ../../views/backend/keywords/delete.php?numMotCle=' . $numMotCle);
    exit();
}

// Proceed with deletion
sql_delete('MOTCLE', "numMotCle = $numMotCle");
$_SESSION['success_message'] = "Mot clé supprimé avec succès.";

header('Location: ../../views/backend/keywords/list.php');
exit();