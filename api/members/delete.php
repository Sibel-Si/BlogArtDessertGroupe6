<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/query/connect.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Only allow Admins (level 1) to access this specific API
check_api_access([1]);


$numM = isset($_POST['numM']) ? (int)$_POST['numM'] : 0;
if(empty($numM)){
    header('Location: ../../views/backend/members/list.php');
}
if ($numM <= 0) {
    $_SESSION['error_message'] = "Identifiant membre invalide.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}

/* $recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
if (empty($recaptchaToken)) {
    $_SESSION['error_message'] = "Veuillez vérifier reCAPTCHA.";
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}

$recaptchaSecretKey = "6LcBgWAsAAAAAPOCwFqU7RpKNOrAZV6tagbaKL5S";

$recaptchaResponse = file_get_contents(
    'https://www.google.com/recaptcha/api/siteverify',
    false,
    stream_context_create([
        'http' => [
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query([
                'secret' => $recaptchaSecretKey,
                'response' => $recaptchaToken
            ])
        ]
    ])
);

$recaptchaData = json_decode($recaptchaResponse, true);

if (empty($recaptchaData['success']) || $recaptchaData['score'] < 0.5) {
    $_SESSION['error_message'] = "Vérification reCAPTCHA échouée.";
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}

*/ 


$member = sql_select('MEMBRE', '*', "numMemb = $numM");
if (!$member || !isset($member[0])) {
    $_SESSION['error_message'] = "Membre non trouvé.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}
$member = $member[0];

// Dependency Checks
$comCount = sql_select('COMMENT', 'COUNT(*) as count', "numMemb = $numM")[0]['count'] ?? 0;
$likeCount = sql_select('LIKEART', 'COUNT(*) as count', "numMemb = $numM")[0]['count'] ?? 0;

if ( $comCount > 0 || $likeCount > 0) {
    $_SESSION['error_message'] = "Impossible de supprimer ce membre : il possède encore des commentaires ($comCount) ou des likes ($likeCount).";
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}

try {
    global $DB; // Tell PHP to use the global database variable
    
    if (!$DB) {
        sql_connect(); // This function populates $DB internally
    }

    // Double check that it worked
    if (!$DB) {
        throw new Exception("La connexion à la base de données a échoué.");
    }

    $DB->beginTransaction();

    $stmt = $DB->prepare("DELETE FROM COMMENT WHERE numMemb = :numMemb");
    $stmt->execute([':numMemb' => $numM]);

    $stmt = $DB->prepare("DELETE FROM LIKEART WHERE numMemb = :numMemb");
    $stmt->execute([':numMemb' => $numM]);

    $stmt = $DB->prepare("DELETE FROM MEMBRE WHERE numMemb = :numMemb");
    $stmt->execute([':numMemb' => $numM]);

    $DB->commit();

    $_SESSION['success_message'] = "Le membre #$numM a été supprimé.";
    header('Location: ../../views/backend/members/list.php');
    exit();

} catch (Exception $e) {
    // Safety: check if $DB is an object before calling rollBack
    if (isset($DB) && $DB instanceof PDO && $DB->inTransaction()) {
        $DB->rollBack();
    }
    $_SESSION['error_message'] = "Erreur : " . $e->getMessage();
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}
?>