<?php

session_start();
require_once '../../config.php';

$numM = isset($_POST['numM']) ? (int)$_POST['numM'] : 0;
if ($numM <= 0) {
    $_SESSION['error_message'] = "Identifiant membre invalide.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}

$recaptchaToken = $_POST['g-recaptcha-response'] ?? '';
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

$member = sql_select('MEMBRE', '*', "numMemb = $numM");
if (!$member || !isset($member[0])) {
    $_SESSION['error_message'] = "Membre non trouvé.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}
$member = $member[0];

try {
    $DB = sql_connect();
    $DB->beginTransaction();

    $stmt = $DB->prepare("DELETE FROM COMMENT WHERE numMemb = :numMemb");
    $stmt->execute([':numMemb' => $numM]);

    $stmt = $DB->prepare("DELETE FROM LIKEART WHERE numMemb = :numMemb");
    $stmt->execute([':numMemb' => $numM]);

    $stmt = $DB->prepare("DELETE FROM MEMBRE WHERE numMemb = :numMemb");
    $stmt->execute([':numMemb' => $numM]);

    $DB->commit();

    $_SESSION['success_message'] = "Le membre #$numM ({$member['pseudoMemb']}) a été supprimé avec succès.";
    header('Location: ../../views/backend/members/list.php');
    exit();

} catch (Exception $e) {
    if ($DB->inTransaction()) $DB->rollBack();
    $_SESSION['error_message'] = "Erreur lors de la suppression : " . $e->getMessage();
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}
?>