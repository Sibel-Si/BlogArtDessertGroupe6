<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

session_start();

$pseudo = $_POST['pseudoMemb'] ?? '';
$pass   = $_POST['passMemb'] ?? '';

// 🔒 Тут у тебе ВЖЕ є logique membre → tu peux la brancher plus tard
// Для MMI достатньо redirect

// Exemple simple (à adapter à ton code existant)
$membre = sql_select(
    "membre",
    "*",
    "pseudoMemb = '$pseudo'"
);

if (!empty($membre)) {
    $_SESSION['numMemb'] = $membre[0]['numMemb'];
    $_SESSION['pseudoMemb'] = $membre[0]['pseudoMemb'];

    header('Location: /');
    exit;
}

// Sinon
header('Location: /views/backend/security/login.php');
exit;
