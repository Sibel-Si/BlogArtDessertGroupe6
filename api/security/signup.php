<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/pdo.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $pseudo     = trim($_POST['pseudoMemb'] ?? '');
    $prenom     = trim($_POST['prenomMemb'] ?? '');
    $nom        = trim($_POST['nomMemb'] ?? '');
    $email      = trim($_POST['emailMemb'] ?? '');
    $email2     = trim($_POST['emailMembConfirm'] ?? '');
    $pass       = $_POST['passMemb'] ?? '';
    $pass2      = $_POST['passMembConfirm'] ?? '';
    $accord     = $_POST['accordMemb'] ?? null;
    $captchaRes = $_POST['g-recaptcha-response'] ?? '';

    $errors = [];

    $secretKey = "6LcBgWAsAAAAAPOCwFqU7RpKNOrAZV6tagbaKL5S";
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify");
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
        'secret'   => $secretKey,
        'response' => $captchaRes
    ]));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $captchaSuccess = json_decode($response);

    if (!$captchaSuccess->success || $captchaSuccess->score < 0.5) {
        $errors[] = "La vérification de sécurité a échoué (Bot suspecté).";
    }

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

    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    try {
        $stmt = $pdo->prepare("SELECT numStat FROM statut WHERE libStat = 'Membre'");
        $stmt->execute();
        $numStat = $stmt->fetchColumn();

        $sql = "INSERT INTO membre 
                (pseudoMemb, prenomMemb, nomMemb, eMailMemb, passMemb, accordMemb, dtCreaMemb, numStat)
                VALUES 
                (:pseudo, :prenom, :nom, :email, :pass, :accord, NOW(), :numStat)";

        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':pseudo'   => $pseudo,
            ':prenom'   => $prenom,
            ':nom'      => $nom,
            ':email'    => $email,
            ':pass'     => $passHash,
            ':accord'   => ($accord === "1") ? 1 : 0,
            ':numStat'  => $numStat
        ]);

        header("Location: /views/backend/security/login.php?signup=success");
        exit;

    } catch (PDOException $e) {
        echo "<p style='color:red;'>Erreur : " . $e->getMessage() . "</p>";
        exit;
    }
}