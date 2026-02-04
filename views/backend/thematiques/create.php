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
?>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <h1>Création nouvelle Thématique</h1>
            
            
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
            
            <form action="<?php echo ROOT_URL . '/api/thematiques/create.php' ?>" method="post" onsubmit="return validateForm()">
                <div class="form-group">
                    <label for="libThem">Nom de la thématique <span class="text-danger">*</span></label>
                    <input id="libThem" name="libThem" class="form-control" type="text" autofocus="autofocus" required />
                </div>
                <br />
                <div class="form-group mt-2">
                    <a href="list.php" class="btn btn-moyen">List</a>
                    <button type="submit" class="btn btn-clair">Confirmer create ?</button>
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