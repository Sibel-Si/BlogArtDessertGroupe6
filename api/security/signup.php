<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/query/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/query/select.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/query/insert.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $pseudo     = trim($_POST['pseudoMemb']);
    $prenom     = trim($_POST['prenomMemb']);
    $nom        = trim($_POST['nomMemb']);
    $email      = trim($_POST['emailMemb']);
    $email2     = trim($_POST['emailMembConfirm']);
    $pass       = $_POST['passMemb'];
    $pass2      = $_POST['passMembConfirm'];
    $accord     = $_POST['accordMemb'] ?? null;

    $errors = [];

    // Validation
    if ($email !== $email2) $errors[] = "Les emails ne correspondent pas.";
    if ($pass !== $pass2) $errors[] = "Les mots de passe ne correspondent pas.";
    if ($accord !== "1") $errors[] = "Vous devez accepter la conservation des données.";

    if (!empty($errors)) {
        foreach ($errors as $e) echo "<p style='color:red;'>$e</p>";
        exit;
    }

    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    $statut = sql_select('statut', 'numStat', "libStat = 'Membre'");
    if (empty($statut)) {
        echo "<p style='color:red;'>Erreur : statut 'Membre' introuvable.</p>";
        exit;
    }
    $numStat = $statut[0]['numStat'];

    // --- PREPARING DATA FOR YOUR 3-ARGUMENT INSERT FUNCTION ---

    // 1. Column names string
    $attributs = "pseudoMemb, prenomMemb, nomMemb, eMailMemb, passMemb, accordMemb, dtCreaMemb, numStat";

    // 2. Values string (Note: Strings must be wrapped in single quotes)
    // We use addslashes to prevent errors with names like O'Connor
    $values = "'" . addslashes($pseudo) . "', "
            . "'" . addslashes($prenom) . "', "
            . "'" . addslashes($nom) . "', "
            . "'" . addslashes($email) . "', "
            . "'" . $passHash . "', "
            . (int)$accord . ", "
            . "NOW(), "
            . (int)$numStat;

    // 3. Call with EXACTLY 3 arguments
    sql_insert('membre', $attributs, $values);

    header("Location: /views/backend/security/login.php?signup=success");
    exit;
}

    // Redirection
    header("Location: /views/backend/security/login.php?signup=success");
    exit;

    //Le recaptcha à sauter avec le push 

?>