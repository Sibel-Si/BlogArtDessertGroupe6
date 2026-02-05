<?php

session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error_message'] = 'Méthode non autorisée.';
    header('Location: ../../views/backend/members/create.php');
    exit;
}

/*recaptcha_secret = "6LcBgWAsAAAAAPOCwFqU7RpKNOrAZV6tagbaKL5S";
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha_response)) {
    $_SESSION['error_message'] = 'Veuillez compléter le reCAPTCHA.';
    header('Location: ../../views/backend/members/create.php');
    exit;
}

$recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
$recaptcha_post = [
    'secret' => $recaptcha_secret,
    'response' => $recaptcha_response
];

$context = stream_context_create([
    'http' => [
        'method' => 'POST',
        'header' => 'Content-Type: application/x-www-form-urlencoded',
        'content' => http_build_query($recaptcha_post)
    ]
]);

$result = json_decode(file_get_contents($recaptcha_url, false, $context), true);

if (!$result['success'] || $result['score'] < 0.5) {
    $_SESSION['error_message'] = 'Vérification reCAPTCHA échouée. Veuillez réessayer.';
    header('Location: ../../views/backend/members/create.php');
    exit;
}
*/

$pseudoMemb = ctrlSaisies($_POST['pseudoMemb'] ?? '');
$prenomMemb = ctrlSaisies($_POST['prenomMemb'] ?? '');
$nomMemb = ctrlSaisies($_POST['nomMemb'] ?? '');
$passMemb = $_POST['passMemb'] ?? '';
$confirmPassMemb = $_POST['confirmPassMemb'] ?? '';
$eMailMemb = ctrlSaisies($_POST['eMailMemb'] ?? '');
$confirmEmailMemb = ctrlSaisies($_POST['confirmEmailMemb'] ?? '');
$accordMemb = isset($_POST['accordMemb']) ? (int)$_POST['accordMemb'] : 0;
$numStat = isset($_POST['numStat']) ? (int)$_POST['numStat'] : null;

$errors = [];

if (empty($pseudoMemb) || strlen($pseudoMemb) < 6 || strlen($pseudoMemb) > 70) {
    $errors[] = 'Le pseudo doit contenir entre 6 et 70 caractères.';
}

$existing_pseudo = sql_select('MEMBRE', '*', "pseudoMemb = '$pseudoMemb'");
if ($existing_pseudo && count($existing_pseudo) > 0) {
    $errors[] = 'Ce pseudo est déjà utilisé.';
}

if (empty($passMemb) || strlen($passMemb) < 8 || strlen($passMemb) > 15) {
    $errors[] = 'Le mot de passe doit contenir entre 8 et 15 caractères.';
}

if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $passMemb)) {
    $errors[] = 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule et 1 chiffre.';
}

if ($passMemb !== $confirmPassMemb) {
    $errors[] = 'Les mots de passe ne correspondent pas.';
}

if (empty($eMailMemb) || !filter_var($eMailMemb, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email invalide.';
}

$existing_email = sql_select('MEMBRE', '*', "eMailMemb = '$eMailMemb'");
if ($existing_email && count($existing_email) > 0) {
    $errors[] = 'Cet email est déjà utilisé.';
}

if ($eMailMemb !== $confirmEmailMemb) {
    $errors[] = 'Les emails ne correspondent pas.';
}

if (count($errors) > 0) {
    $_SESSION['error_message'] = implode('<br>', $errors);
    header('Location: ../../views/backend/members/create.php');
    exit;
}

$hashed_password = password_hash($passMemb, PASSWORD_DEFAULT);

$attributs = 'pseudoMemb, prenomMemb, nomMemb, passMemb, eMailMemb, accordMemb';
$values = "'$pseudoMemb', '$prenomMemb', '$nomMemb', '$hashed_password', '$eMailMemb', $accordMemb";

if ($numStat) {
    $attributs .= ', numStat';
    $values .= ", $numStat";
}

try {
    sql_insert('MEMBRE', $attributs, $values);
    $_SESSION['success_message'] = 'Membre créé avec succès!';
    header('Location: ../../views/backend/members/list.php');
    exit;
} catch (Exception $e) {
    $_SESSION['error_message'] = 'Erreur lors de la création du membre: ' . $e->getMessage();
    header('Location: ../../views/backend/members/create.php');
    exit;
}

?>