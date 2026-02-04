<?php
session_start();
require_once ROOT_URL . '/functions/security.php';

// Define the required level (e.g., 1 for Admin, 2 for Moderator)
$required_level = 1; 

if (!check_access($required_level)) {
    // Redirect unauthorized users to login or an error page
    header("Location: login.php?error=unauthorized");
    exit(); // Always exit after a header redirect
}

session_start();
require_once '../../config.php';

// Vérifier la méthode POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    $_SESSION['error_message'] = 'Méthode non autorisée.';
    header('Location: ../../views/backend/members/create.php');
    exit;
}

// Vérifier le reCAPTCHA
$recaptcha_secret = getenv('RECAPTCHA_SECRET_KEY');
$recaptcha_response = $_POST['g-recaptcha-response'] ?? '';

if (empty($recaptcha_response)) {
    $_SESSION['error_message'] = 'Veuillez compléter le reCAPTCHA.';
    header('Location: ../../views/backend/members/create.php');
    exit;
}

// Valider le reCAPTCHA avec Google
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

// Récupérer et nettoyer les données du formulaire
$pseudoMemb = ctrlSaisies($_POST['pseudoMemb'] ?? '');
$prenomMemb = ctrlSaisies($_POST['prenomMemb'] ?? '');
$nomMemb = ctrlSaisies($_POST['nomMemb'] ?? '');
$passMemb = $_POST['passMemb'] ?? '';
$confirmPassMemb = $_POST['confirmPassMemb'] ?? '';
$eMailMemb = ctrlSaisies($_POST['eMailMemb'] ?? '');
$confirmEmailMemb = ctrlSaisies($_POST['confirmEmailMemb'] ?? '');
$accordMemb = isset($_POST['accordMemb']) ? (int)$_POST['accordMemb'] : 0;
$numStat = isset($_POST['numStat']) ? (int)$_POST['numStat'] : null;

// Validations
$errors = [];

// Valider pseudo
if (empty($pseudoMemb) || strlen($pseudoMemb) < 6 || strlen($pseudoMemb) > 70) {
    $errors[] = 'Le pseudo doit contenir entre 6 et 70 caractères.';
}

// Vérifier si le pseudo existe déjà
$existing_pseudo = sql_select('MEMBRE', '*', "pseudoMemb = '$pseudoMemb'");
if ($existing_pseudo && count($existing_pseudo) > 0) {
    $errors[] = 'Ce pseudo est déjà utilisé.';
}

// Valider mot de passe
if (empty($passMemb) || strlen($passMemb) < 8 || strlen($passMemb) > 15) {
    $errors[] = 'Le mot de passe doit contenir entre 8 et 15 caractères.';
}

// Vérifier complexité du mot de passe
if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $passMemb)) {
    $errors[] = 'Le mot de passe doit contenir au moins 1 majuscule, 1 minuscule et 1 chiffre.';
}

// Vérifier correspondance des mots de passe
if ($passMemb !== $confirmPassMemb) {
    $errors[] = 'Les mots de passe ne correspondent pas.';
}

// Valider email
if (empty($eMailMemb) || !filter_var($eMailMemb, FILTER_VALIDATE_EMAIL)) {
    $errors[] = 'Email invalide.';
}

// Vérifier si l'email existe déjà
$existing_email = sql_select('MEMBRE', '*', "eMailMemb = '$eMailMemb'");
if ($existing_email && count($existing_email) > 0) {
    $errors[] = 'Cet email est déjà utilisé.';
}

// Vérifier correspondance des emails
if ($eMailMemb !== $confirmEmailMemb) {
    $errors[] = 'Les emails ne correspondent pas.';
}

// S'il y a des erreurs, rediriger
if (count($errors) > 0) {
    $_SESSION['error_message'] = implode('<br>', $errors);
    header('Location: ../../views/backend/members/create.php');
    exit;
}

// Hasher le mot de passe
$hashed_password = password_hash($passMemb, PASSWORD_DEFAULT);

// Préparer les données pour l'insertion
$attributs = 'pseudoMemb, prenomMemb, nomMemb, passMemb, eMailMemb, accordMemb';
$values = "'$pseudoMemb', '$prenomMemb', '$nomMemb', '$hashed_password', '$eMailMemb', $accordMemb";

if ($numStat) {
    $attributs .= ', numStat';
    $values .= ", $numStat";
}

// Insérer le nouveau membre
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
