<?php
include '../../../header.php'; // contains the header and call to config.php
?>
<?php
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
                    <a href="list.php" class="btn btn-primary">List</a>
                    <button type="submit" class="btn btn-success">Confirmer create ?</button>
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


