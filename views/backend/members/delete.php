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

include '../../../header.php';



// Afficher messages flash
if(isset($_SESSION['success_message'])):
    echo '<div class="container mt-3"><div class="alert alert-success alert-dismissible fade show" role="alert">'.$_SESSION['success_message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
    unset($_SESSION['success_message']);
endif;
if(isset($_SESSION['error_message'])):
    echo '<div class="container mt-3"><div class="alert alert-fonce alert-dismissible fade show" role="alert">'.$_SESSION['error_message'].'<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></div>';
    unset($_SESSION['error_message']);
endif;

// Récupérer l'ID du membre depuis l'URL
$numM = isset($_GET['numM']) ? (int)$_GET['numM'] : 0;

if ($numM <= 0) {
        $_SESSION['error_message'] = "Identifiant membre invalide.";
        header('Location: list.php');
        exit();
}

// Charger le membre
$member = function_exists('sql_select') ? sql_select('MEMBRE', '*', "numMemb = $numM") : null;
if (!$member || !isset($member[0])) {
        $_SESSION['error_message'] = "Membre non trouvé.";
        header('Location: list.php');
        exit();
}
$member = $member[0];

// Statut
$statLib = '—';
if (isset($member['numStat'])) {
        $s = function_exists('sql_select') ? sql_select('STATUT', 'libStat', 'numStat = ' . $member['numStat']) : null;
        if ($s && count($s) > 0) $statLib = $s[0]['libStat'];
}

// Date format
$dtCreation = isset($member['dtCreaMemb']) ? date('d/m/Y H:i:s', strtotime($member['dtCreaMemb'])) : '—';
?>

<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <div style="max-width:900px; width:100%;">
            <h2 class="text-center mb-4">Suppression Membre</h2>

            <form id="deleteForm" method="POST" action="<?php echo defined('ROOT_URL') ? ROOT_URL . '/api/members/delete.php' : '../../../api/members/delete.php'; ?>">
                <input type="hidden" name="numM" value="<?php echo htmlspecialchars($member['numMemb']); ?>">
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response" value="">

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Numéro</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo htmlspecialchars($member['numMemb']); ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Pseudo</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo htmlspecialchars($member['pseudoMemb']); ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Date de création</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo htmlspecialchars($dtCreation); ?>" readonly>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 text-right">
                        <label class="font-weight-bold d-block">Prénom</label>
                        <input type="text" class="form-control ml-auto d-inline-block" style="max-width:280px;" value="<?php echo htmlspecialchars($member['prenomMemb'] ?? ''); ?>" readonly>
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <label class="font-weight-bold d-block">Nom</label>
                        <input type="text" class="form-control ml-auto d-inline-block" style="max-width:280px;" value="<?php echo htmlspecialchars($member['nomMemb'] ?? ''); ?>" readonly>
                    </div>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">eMail</label>
                    <input type="email" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo htmlspecialchars($member['eMailMemb']); ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Statut</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo htmlspecialchars($statLib); ?>" readonly>
                </div>

                <div class="form-group text-right mb-4">
                    <div class="d-inline-block">
                        <div class="g-recaptcha" data-sitekey="6Le_DFssAAAAACV0VEfu0yIR-_bRWUgI4EEKPDJ_"></div>
                    </div>
                </div>

                <div class="form-group text-right">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <button type="submit" class="btn btn-fonce ">Confirmer Delete ?</button>
                </div>

            </form>

        </div>
    </div>
</div>

<!-- reCAPTCHA -->
<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<?php include '../../../footer.php'; ?>