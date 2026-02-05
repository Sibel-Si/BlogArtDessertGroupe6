<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/defines.php';
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

    if ($email !== $email2) {
        $errors[] = "Les emails ne correspondent pas.";
    }

    if ($pass !== $pass2) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    if ($accord !== "1") {
        $errors[] = "Vous devez accepter la conservation des données.";
    }

    if (!empty($errors)) {
        foreach ($errors as $e) {
            echo "<p style='color:red;'>$e</p>";
        }
        exit;
    }

    //Hash du mot de passe
    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    //Récupération du statut "Membre" via sql_select()
    $statut = sql_select(
        'statut',
        'numStat',
        "libStat = 'Membre'"
    );

    if (empty($statut)) {
        echo "<p style='color:red;'>Erreur : statut 'Membre' introuvable.</p>";
        exit;
    }

    $numStat = $statut[0]['numStat'];

    //Insertion via sql_insert()
    $values = [
        'pseudoMemb' => $pseudo,
        'prenomMemb' => $prenom,
        'nomMemb'    => $nom,
        'eMailMemb'  => $email,
        'passMemb'   => $passHash,
        'accordMemb' => $accord,
        'dtCreaMemb' => date('Y-m-d H:i:s'),
        'numStat'    => $numStat
    ];

    sql_insert('membre', $values);

    // Redirection
    header("Location: /views/backend/security/login.php?signup=success");
    exit;

    //Le recaptcha à sauter avec le push 
}
?>