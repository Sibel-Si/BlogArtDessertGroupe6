<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/global.inc.php'; // Ensure this is included for sql_update
require_once '../../functions/ctrlSaisies.php';

// 1. Use POST because your form method="post"
$numCom = (int)($_POST['numCom'] ?? 0);
$notifComKOAff = ctrlSaisies($_POST["notifComKOAff"] ?? "");
$validate = $_POST["validate1"] ?? "";

if ($numCom > 0) {
    if ($validate === "oui") {
        // Validation: reset rejection reason and set moderation to 1
        sql_update("COMMENT", "attModOK=1, notifComKOAff=''", "numCom = $numCom");
        
    } elseif ($validate === "non") {
        // Refusal: Logic delete, set date, and save the reason
        // Use single quotes for strings in your sql_update
        $dateNow = date('Y-m-d H:i:s');
        sql_update(
            "COMMENT", 
            "delLogiq=1, dtDelLogCom='$dateNow', notifComKOAff='$notifComKOAff', attModOK=0", 
            "numCom = $numCom"
        );
    }
}

header('Location: ../../views/backend/comments/list.php');
exit;