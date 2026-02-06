<?php
include '../../../header.php';
check_page_access([1, 2]); 


if(isset($_SESSION['success_message'])) {
    echo '<div class="container mt-3"><div class="alert alert-success">'.$_SESSION['success_message'].'</div></div>';
    unset($_SESSION['success_message']);
}
if(isset($_SESSION['error_message'])) {
    echo '<div class="container mt-3"><div class="alert alert-danger">'.$_SESSION['error_message'].'</div></div>';
    unset($_SESSION['error_message']);
}

$numM = isset($_GET['numM']) ? (int)$_GET['numM'] : 0;
if ($numM <= 0) {
    $_SESSION['error_message'] = "Identifiant membre invalide.";
    header('Location: list.php');
    exit();
}

$member = sql_select('MEMBRE', '*', "numMemb = $numM");
if (!$member || !isset($member[0])) {
    $_SESSION['error_message'] = "Membre non trouvé.";
    header('Location: list.php');
    exit();
}
$member = $member[0];

$statLib = '—';
if (isset($member['numStat'])) {
    $s = sql_select('STATUT', 'libStat', 'numStat = ' . $member['numStat']);
    if ($s && count($s) > 0) $statLib = $s[0]['libStat'];
}

$dtCreation = isset($member['dtCreaMemb']) ? date('d/m/Y H:i:s', strtotime($member['dtCreaMemb'])) : '—';
?>

<script src="https://www.google.com/recaptcha/api.js?render=6LcBgWAsAAAAAJXlt-QCfOoIE1-qSXXHNFCa0usb"></script>

<style>
html, body { height: 100%; }
body { display: flex; flex-direction: column; }
main { flex: 1; }
</style>

<main>
<div class="container mt-5">
    <div class="d-flex justify-content-center">
        <div style="max-width:900px; width:100%;">
            <h2 class="text-center mb-4">Suppression Membre</h2>

            <form id="deleteForm" method="POST" action="<?php echo defined('ROOT_URL') ? ROOT_URL . '/api/members/delete.php' : '../../../api/members/delete.php'; ?>">
                <input type="hidden" name="numM" value="<?php echo htmlspecialchars($member['numMemb']); ?>">
                <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Numéro</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo $member['numMemb']; ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Pseudo</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo $member['pseudoMemb']; ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Date de création</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo $dtCreation; ?>" readonly>
                </div>

                <div class="form-row">
                    <div class="form-group col-md-6 text-right">
                        <label class="font-weight-bold d-block">Prénom</label>
                        <input type="text" class="form-control ml-auto d-inline-block" style="max-width:280px;" value="<?php echo $member['prenomMemb']; ?>" readonly>
                    </div>
                    <div class="form-group col-md-6 text-right">
                        <label class="font-weight-bold d-block">Nom</label>
                        <input type="text" class="form-control ml-auto d-inline-block" style="max-width:280px;" value="<?php echo $member['nomMemb']; ?>" readonly>
                    </div>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">eMail</label>
                    <input type="email" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo $member['eMailMemb']; ?>" readonly>
                </div>

                <div class="form-group text-right">
                    <label class="font-weight-bold d-block">Statut</label>
                    <input type="text" class="form-control ml-auto d-inline-block" style="max-width:600px;" value="<?php echo $statLib; ?>" readonly>
                </div>

                <div class="form-group text-right mt-4">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <?php if(!$isBlocked): ?>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Confirmer la suppression définitive de ce membre ?');">
                    Supprimer le membre
                </button>
            <?php else: ?>
                <button type="button" class="btn btn-danger" disabled>Suppression bloquée</button>
            <?php endif; ?>                </div>

            </form>

        </div>
    </div>
</div>
</main>

<script>
document.getElementById('deleteForm').addEventListener('submit', function(e){
    e.preventDefault();
    grecaptcha.ready(function() {
        grecaptcha.execute('6LcBgWAsAAAAAJXlt-QCfOoIE1-qSXXHNFCa0usb', {action: 'delete'})
        .then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
            document.getElementById('deleteForm').submit();
        });
    });
});
</script>

<?php include '../../../footer.php'; ?>