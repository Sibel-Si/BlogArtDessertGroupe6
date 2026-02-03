<?php
/**
 * Check if user is logged in with SESSION
 */
session_start();

if(isset($_SESSION["USER_ID"])){ //trouver le nom donné dans login.php et l'utiliser dans les guillemets
    header("Location : index.php");
    exit();
}else{
    header("Location: login.php");
    echo("Votre session est invalide.");
}
if(isset($_POST["USER_ID"]) &&($_POST["password"])){
    return $pseudo= $_SESSION["USER_ID"];
    trim($pseudo);
    return $motdepasse= $_SESSION["password"];
    trim($motdepasse);
    header("Location:index.php?success");
}

if(!isset($_SESSION["USER_ID"])){ //trouver le nom donné dans login.php et l'utiliser dans les guillemets
    header("Location : login.php");
    session_destroy();
}

 // hint : $_SESSION['USER_ID']
 // define constant ID_USER if user is logged in with define function

?>