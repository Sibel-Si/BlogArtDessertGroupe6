<?php
include '../../../header.php';

$err = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<!-- <script src="https://www.google.com/recaptcha/api.js?render=6LcBgWAsAAAAAAJXlt-QCfOoIE1-qSXXHNFCa0usb"></script> -->
<div class="container mt-5" style="max-width: 500px;">

    <h2 class="mb-4 text-center">Se connecter</h2>

    <?php if (!empty($err)) : ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($err) ?>
        </div>
    <?php endif; ?>

    <form id="loginForm" method="post" action="/api/security/login.php">

        <div class="mb-3">
            <label for="pseudoMemb" class="form-label">Pseudo</label>
            <input type="text" class="form-control" id="pseudoMemb" name="pseudoMemb" required>
        </div>

        <div class="mb-3">
            <label for="passMemb" class="form-label">Mot de passe</label>
            <input type="password" class="form-control" id="passMemb" name="passMemb" required>
        </div>

        <input type="hidden" name="g-recaptcha-response" id="g-recaptcha-response">

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">Se connecter</button>
        </div>

        <div class="text-center mt-3">
            <a href="/views/backend/security/signup.php">Pas encore de compte ? S’inscrire</a>
        </div>

    </form>
</div>

<!--
<script>
document.getElementById('loginForm').addEventListener('submit', function(e) {
    e.preventDefault();
    grecaptcha.ready(function() {
        grecaptcha.execute('6LcBgWAsAAAAAJXlt-QCfOoIE1-qSXXHNFCa0usb', {action: 'login'})
        .then(function(token) {
            document.getElementById('g-recaptcha-response').value = token;
            document.getElementById('loginForm').submit();
        });
    });
});
</script>
-->

<?php include '../../../footer.php'; ?>
