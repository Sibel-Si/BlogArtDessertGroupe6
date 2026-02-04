<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Config + functions (CRUD, ctrlSaisies, etc.)
require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../functions/global.inc.php';
require_once __DIR__ . '/../../functions/ctrlSaisies.php';

// 1. Vérifier que le formulaire est envoyé
if (!isset($_POST['pseudoMemb'], $_POST['passMemb'])) {
    header('Location: /views/backend/security/login.php');
    exit;
}

// 2. Sécurisation des saisies (fonction fournie)
$pseudo = ctrlSaisies($_POST['pseudoMemb']);
$pass   = ctrlSaisies($_POST['passMemb']);

// 3. Vérification champs vides
if ($pseudo === '' || $pass === '') {
    $_SESSION['login_error'] = "Champs obligatoires manquants.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// 4. Récupération du membre (CRUD -> SELECT)
$membre = sql_select(
    'membre',
    '*',
    "pseudoMemb = '$pseudo'"
);

// 5. Vérifier si le membre existe
if (!$membre || count($membre) !== 1) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// 6. Vérification du mot de passe (PLAIN TEXT)
if ($pass !== $membre[0]['passMemb']) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// 7. Connexion réussie → session
$_SESSION['id_user'] = $membre[0]['numMemb'];

// 8. Redirection après login
header('Location: /');
exit;
