<?php
include '../../../header.php';

$err = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<?php if (!empty($err)) : ?>
    <div class="alert alert-danger"><?= htmlspecialchars($err) ?></div>
<?php endif; ?>

<div class="container mt-5" style="max-width: 500px;">
    
    <h2 class="mb-4 text-center">
        <i class="bi bi-person"></i> Se connecter
    </h2>

    <form method="post" action="/api/security/login.php">

        <!-- PSEUDO -->
        <label class="form-label">Pseudo</label>
        <input type="text" name="pseudoMemb" class="form-control"  required >

        <!-- PASSWORD -->
        <label class="form-label mt-3">Mot de passe</label>
        <input type="password" name="passMemb" class="form-control" required >

        <!-- AFFICHER MDP -->
        <div class="form-check mt-2">
            <input class="form-check-input" type="checkbox" id="showPass" onclick="togglePassword()">
            <label class="form-check-label" for="showPass">
                Afficher MDP
            </label>
        </div>

        <!-- CAPTCHA (visuel seulement si вже є) -->
        <div class="mt-3">
            <button type="button" class="btn btn-light w-100" disabled>
                Captcha
            </button>
        </div>

        <!-- SUBMIT -->
        <div class="mt-4">
            <button type="submit" class="btn btn-success w-100">
                Se connecter
            </button>
        </div>

        <!-- SIGNUP -->
        <div class="text-center mt-3">
            <a href="/views/backend/security/signup.php">
                Pas de compte ? Créer un
            </a>
        </div>
    </form>
</div>

<script>
function togglePassword() {
    const input = document.querySelector('input[name="passMemb"]');
    input.type = (input.type === 'password') ? 'text' : 'password';
}
</script>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>

