<?php


require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numCom = ($_GET['numCom']);
$commentaire = sql_select("COMMENT", "*", "numCom = $numCom");

//si commentaire validé et qu'il n'y a rien dans le texte, on l'update
if(isset($_GET["validate"[0]]))&&(!isset($_GET["notifComKOAff"])){
    $commentaire = sql_update("COMMENT", "numCom", "attModOK = 1");
}

//si commentaire non validé et qu'il n'y a rien dans le texte, on donne une erreur
if(!isset($_GET["validate"[0]])&&(!isset($_GET["notifComKOAff"]))){
    echo("Il faut écrire pourquoi le commentaire doit être effacé.");
    header("Location : /views/backend/comments/delete.php?error");
}

//si commentaire non validé et qu'il y a quelque chose dans le texte, on delete le libellé commentaire
if(!isset($_GET["validate"[0]])&&(isset($_GET["notifComKOAff"]))){
    $commentaire = sql_update("COMMENT", "numCom libCom", "delLogiq = 1");
    if(isset($_GET["afficheoui"])){
        $commentaire = sql_delete("COMMENT", "libCom", "delLogiq = 1");
    }elseif(isset($_GET["affichenon"])){
        
    }
}


// sql_delete('COMMENT', "numCom = $numCom");

header('Location: ../../views/backend/comments/list.php');