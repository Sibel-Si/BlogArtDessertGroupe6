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

if(isset($_GET['numThem'])){
    $numThem = $_GET['numThem'];
    $thematique = sql_select("THEMATIQUE", "*", "numThem = $numThem");
    if(!$thematique) {
        $_SESSION['error_message'] = "Thématique non trouvée.";
        header('Location: list.php');
        exit();
    }
    $libThem = $thematique[0]['libThem'];
} else {
    $_SESSION['error_message'] = "ID de thématique manquant.";
    header('Location: list.php');
    exit();
}
?>


<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Modification Thématique</h1>
            
           
            <?php if(isset($_SESSION['error_message'])): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
                </div>
            <?php endif; ?>
            <?php if(isset($_SESSION['success_message'])): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-md-12">
           
            <form action="<?php echo ROOT_URL . '/api/thematiques/update.php' ?>" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="libThem">Nom de la thématique <span class="text-danger">*</span></label>
                    <input id="numThem" name="numThem" class="form-control" style="display: none" type="text" value="<?php echo($numThem); ?>" readonly="readonly" />
                    <input id="libThem" name="libThem" class="form-control" type="text" value="<?php echo($libThem); ?>" required />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <button type="submit" class="btn btn-clair">Confirmer modification ?</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function validateForm() {
    const libThem = document.getElementById('libThem').value.trim();
    if (libThem === '') {
        alert('Le nom de la thématique est obligatoire.');
        return false;
    }
    return true;
}
</script>

<?php
include '../../../footer.php'; 
?>