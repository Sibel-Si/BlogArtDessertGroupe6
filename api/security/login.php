<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/pdo.php'; // тут є $pdo
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pseudo = isset($_POST['pseudoMemb']) ? trim(ctrlSaisies($_POST['pseudoMemb'])) : '';
$pass   = isset($_POST['passMemb'])   ? trim(ctrlSaisies($_POST['passMemb']))   : '';

if ($pseudo === '' || $pass === '') {
    $_SESSION['login_error'] = "Pseudo ou mot de passe manquant.";
    header('Location: /views/backend/security/login.php');
    exit;
}

$stmt = $pdo->prepare("SELECT * FROM membre WHERE pseudoMemb = :pseudo LIMIT 1");
$stmt->execute([':pseudo' => $pseudo]);
$m = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$m) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// пароль у тебе зараз у відкритому вигляді (12345678), тому порівняння таке:
$passDb = $m['passMemb'] ?? '';
$isOk = false;

// якщо потім зробиш password_hash(), це теж буде працювати:
if (is_string($passDb) && str_starts_with($passDb, '$2y$')) {
    $isOk = password_verify($pass, $passDb);
} else {
    $isOk = hash_equals((string)$passDb, (string)$pass);
}

if (!$isOk) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// OK
$_SESSION['numMemb']    = (int)$m['numMemb'];
$_SESSION['pseudoMemb'] = $m['pseudoMemb'];
$_SESSION['numStat']    = (int)$m['numStat'];

// Redirection : admin/modo -> back, membre -> front
// (якщо у вас інші значення numStat — просто поміняєш умову)
if ($_SESSION['numStat'] !== 1) {
    header('Location: /');
} else {
    header('Location: /views/backend/dashboard.php');
}
exit;
