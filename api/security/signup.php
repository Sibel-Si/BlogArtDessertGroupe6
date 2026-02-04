<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$pseudo = isset($_POST['pseudoMemb']) ? trim(ctrlSaisies($_POST['pseudoMemb'])) : '';
$pass   = isset($_POST['passMemb'])   ? trim(ctrlSaisies($_POST['passMemb']))   : '';

// mini contrôles (comme CdC)
if (strlen($pseudo) < 6 || strlen($pseudo) > 70 || strlen($pass) < 1) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe invalide.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// 1) On récupère le membre par pseudo
$membre = sql_select(
    "membre",
    "*",
    "pseudoMemb = '" . addslashes($pseudo) . "'"
);

// Pas trouvé
if (empty($membre)) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

$m = $membre[0];

// 2) Vérif password :
// - si tu as des mots de passe en clair => comparaison simple
// - si plus tard tu passes à password_hash => password_verify marche
$passDb = $m['passMemb'] ?? '';

$isOk = false;
if (is_string($passDb) && str_starts_with($passDb, '$2y$')) { // hash bcrypt типово
    $isOk = password_verify($pass, $passDb);
} else {
    $isOk = hash_equals((string)$passDb, (string)$pass);
}

if (!$isOk) {
    $_SESSION['login_error'] = "Pseudo ou mot de passe incorrect.";
    header('Location: /views/backend/security/login.php');
    exit;
}

// 3) OK -> session
$_SESSION['numMemb']    = (int)($m['numMemb'] ?? 0);
$_SESSION['pseudoMemb'] = $m['pseudoMemb'] ?? $pseudo;

// якщо у тебе є статут у membre (FK), збережи його теж (залежить від твоєї BDD):
if (isset($m['numStat'])) {
    $_SESSION['numStat'] = (int)$m['numStat'];
}

// Redirection
header('Location: /');
exit;
