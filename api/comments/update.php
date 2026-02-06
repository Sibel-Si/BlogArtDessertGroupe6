<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numCom = ($_GET['numCom']);
//si bouton oui pressé on valide le commentaire
if(isset($_GET["validate1"=="oui"])){
    $commentaire = sql_update("COMMENT", "attModOK dtModCom delLogiq", "attModOK = 1 delLogiq = 0 dtModCom =". time('d/m/Y H:i:s'));
}elseif(isset($_GET["validate1" =="non"])){
    $commentaire = sql_update("COMMENT", "attModOK delLogiq dtModCom", "delLogiq = 1 dtModCom =". time('d/m/Y H:i:s'));
}
header('Location: ../../views/backend/comments/list.php');
// sql_update('COMMENT', 'numCom', "'$dtCreaCom'");