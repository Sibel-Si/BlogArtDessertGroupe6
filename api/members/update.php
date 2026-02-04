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

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';

// Check if member ID is provided
if (!isset($_POST['numM'])) {
    $_SESSION['error_message'] = "ID du membre manquant.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}

$numM = $_POST['numM'];

// Get current member
if (!function_exists('sql_select')) {
    $_SESSION['error_message'] = "Erreur système : fonction sql_select non disponible.";
    header('Location: ../../views/backend/members/edit.php?numM=' . $numM);
    exit();
}

$member = sql_select('MEMBRE', '*', "numMemb = $numM");
if (!$member) {
    $_SESSION['error_message'] = "Membre non trouvé.";
    header('Location: ../../views/backend/members/list.php');
    exit();
}

$member = $member[0];

// Get form data
$prenomMemb = isset($_POST['prenomMemb']) ? $_POST['prenomMemb'] : '';
$nomMemb = isset($_POST['nomMemb']) ? $_POST['nomMemb'] : '';
$passMemb = isset($_POST['passMemb']) ? $_POST['passMemb'] : '';
$eMailMemb = isset($_POST['eMailMemb']) ? $_POST['eMailMemb'] : '';
$numStat = isset($_POST['numStat']) ? $_POST['numStat'] : '';

// Validate emails if changed
$confirmEmailMemb = isset($_POST['confirmEmailMemb']) ? $_POST['confirmEmailMemb'] : '';
if ($eMailMemb !== '' && $eMailMemb !== $confirmEmailMemb) {
    $_SESSION['error_message'] = "Les adresses email ne correspondent pas.";
    header('Location: ../../views/backend/members/edit.php?numM=' . $numM);
    exit();
}

// Validate password if provided
if ($passMemb !== '') {
    if (strlen($passMemb) < 8 || strlen($passMemb) > 15) {
        $_SESSION['error_message'] = "Le mot de passe doit contenir entre 8 et 15 caractères.";
        header('Location: ../../views/backend/members/edit.php?numM=' . $numM);
        exit();
    }
    // Check password complexity (at least 1 uppercase, 1 lowercase, 1 digit)
    if (!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)/', $passMemb)) {
        $_SESSION['error_message'] = "Le mot de passe doit contenir au moins une majuscule, une minuscule et un chiffre.";
        header('Location: ../../views/backend/members/edit.php?numM=' . $numM);
        exit();
    }
}

try {
    global $DB;
    if (!$DB) {
        sql_connect();
    }

    $DB->beginTransaction();

    // Build UPDATE query
    $updates = array();
    if ($prenomMemb !== '') {
        $updates[] = "prenomMemb = '" . addslashes($prenomMemb) . "'";
    }
    if ($nomMemb !== '') {
        $updates[] = "nomMemb = '" . addslashes($nomMemb) . "'";
    }
    if ($passMemb !== '') {
        // Hash password using password_hash (PHP 5.5+)
        $hashedPass = password_hash($passMemb, PASSWORD_BCRYPT);
        $updates[] = "passMemb = '" . addslashes($hashedPass) . "'";
    }
    if ($eMailMemb !== '') {
        $updates[] = "eMailMemb = '" . addslashes($eMailMemb) . "'";
    }
    if ($numStat !== '') {
        $updates[] = "numStat = $numStat";
    }

    if (count($updates) > 0) {
        $updateQuery = "UPDATE MEMBRE SET " . implode(', ', $updates) . ", dtMajMemb = NOW() WHERE numMemb = $numM";
        $request = $DB->prepare($updateQuery);
        $request->execute();
    }

    $DB->commit();

    $_SESSION['success_message'] = "Vous avez bien modifié le membre #" . $numM;
    header('Location: ../../views/backend/members/list.php');

} catch (Exception $e) {
    if ($DB) {
        $DB->rollBack();
    }
    $_SESSION['error_message'] = "Erreur lors de la modification : " . $e->getMessage();
    header('Location: ../../views/backend/members/edit.php?numM=' . $numM);
}
?>
