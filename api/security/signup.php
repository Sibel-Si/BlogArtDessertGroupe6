<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config/pdo.php';

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

    $passHash = password_hash($pass, PASSWORD_DEFAULT);

    // 🔥 Récupération du statut "Membre"
    $stmt = $pdo->prepare("SELECT numStat FROM statut WHERE libStat = 'Membre'");
    $stmt->execute();
    $numStat = $stmt->fetchColumn();

    try {
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
