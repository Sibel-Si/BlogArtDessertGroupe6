<?php


include '../../config.php';

// Debug log incoming requests (helps verify the endpoint is reached)
$logFile = __DIR__ . '/../../logs/delete_debug.log';
@mkdir(dirname($logFile), 0777, true);
file_put_contents($logFile, date('c') . ' IP:' . ($_SERVER['REMOTE_ADDR'] ?? 'cli') . ' START POST:' . json_encode($_POST) . ' GET:' . json_encode($_GET) . PHP_EOL, FILE_APPEND);

// Récupérer l'ID du membre depuis le POST
$numM = isset($_POST['numM']) ? (int)$_POST['numM'] : 0;

// Vérifier que l'ID est valide
if ($numM <= 0) {
    $_SESSION['error_message'] = "Identifiant membre invalide.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}

// Vérifier reCAPTCHA
$recaptchaToken = isset($_POST['g-recaptcha-response']) ? $_POST['g-recaptcha-response'] : '';
if (empty($recaptchaToken)) {
    $_SESSION['error_message'] = "Veuillez vérifier reCAPTCHA.";
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}

// Valider reCAPTCHA avec la clé secrète
$recaptchaSecretKey = '6Le_DFssAAAAAJpj-HhvD9XxN6Pz2LJyoqkIpzWY';
$recaptchaResponse = file_get_contents('https://www.google.com/recaptcha/api/siteverify', false, 
    stream_context_create(array(
        'http' => array(
            'method' => 'POST',
            'header' => 'Content-Type: application/x-www-form-urlencoded',
            'content' => http_build_query(array(
                'secret' => $recaptchaSecretKey,
                'response' => $recaptchaToken
            ))
        )
    ))
);

$recaptchaData = json_decode($recaptchaResponse, true);
// Support reCAPTCHA v2 (checkbox) and v3 (score).
if (empty($recaptchaData['success']) || (isset($recaptchaData['score']) && $recaptchaData['score'] < 0.5)) {
    $_SESSION['error_message'] = "Vérification reCAPTCHA échouée.";
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}

// Charger les informations du membre
$member = function_exists('sql_select') ? sql_select('MEMBRE', '*', "numMemb = $numM") : null;

if (!$member || !isset($member[0])) {
    $_SESSION['error_message'] = "Membre non trouvé.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}

$member = $member[0];

// Supprimer le membre et ses associations (COMMENT, LIKEART)
try {
    $DB = sql_connect();
    $DB->beginTransaction();

    // Supprimer les commentaires du membre
    $stmt = $DB->prepare("DELETE FROM COMMENT WHERE numMemb = :numMemb");
    $stmt->bindParam(':numMemb', $numM, PDO::PARAM_INT);
    $stmt->execute();

    // Supprimer les likes du membre
    $stmt = $DB->prepare("DELETE FROM LIKEART WHERE numMemb = :numMemb");
    $stmt->bindParam(':numMemb', $numM, PDO::PARAM_INT);
    $stmt->execute();

    // Supprimer le membre
    $stmt = $DB->prepare("DELETE FROM MEMBRE WHERE numMemb = :numMemb");
    $stmt->bindParam(':numMemb', $numM, PDO::PARAM_INT);
    $stmt->execute();

    $DB->commit();
    $_SESSION['success_message'] = "Le membre #" . $numM . " (" . $member['pseudoMemb'] . ") a été supprimé avec succès.";
    file_put_contents($logFile, date('c') . ' IP:' . ($_SERVER['REMOTE_ADDR'] ?? 'cli') . ' DELETED numM:' . $numM . PHP_EOL, FILE_APPEND);
    header('Location: ../../views/backend/members/list.php');
    exit();

} catch (Exception $e) {
    if (isset($DB) && $DB->inTransaction()) {
        $DB->rollBack();
    }
    file_put_contents($logFile, date('c') . ' IP:' . ($_SERVER['REMOTE_ADDR'] ?? 'cli') . ' ERROR:' . $e->getMessage() . PHP_EOL, FILE_APPEND);
    $_SESSION['error_message'] = "Erreur lors de la suppression du membre : " . $e->getMessage();
    header('Location: ../../views/backend/members/delete.php?numM=' . $numM);
    exit();
}
?>