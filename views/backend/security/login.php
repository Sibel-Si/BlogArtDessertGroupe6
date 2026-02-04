<?php
// Header (contient config + session_start)
include '../../../header.php';

// Récupération du message d’erreur
$err = $_SESSION['login_error'] ?? '';
unset($_SESSION['login_error']);
?>

<div class="container mt-5" style="max-width: 500px;">

    <h2 class="mb-4 text-center">
        Se connecter
    </h2>

    <!-- Message d’erreur -->
    <?php if (!empty($err)) : ?>
        <div class="alert alert-danger">
            <?= htmlspecialchars($err) ?>
        </div>
    <?php endif; ?>

    <!-- Formulaire de connexion -->
    <form method="post" action="/api/security/login.php">

        <div class="mb-3">
            <label for="pseudoMemb" class="form-label">Pseudo</label>
            <input
                type="text"
                class="form-control"
                id="pseudoMemb"
                name="pseudoMemb"
                required
            >
        </div>

        <div class="mb-3">
            <label for="passMemb" class="form-label">Mot de passe</label>
            <input
                type="password"
                class="form-control"
                id="passMemb"
                name="passMemb"
                required
            >
        </div>

        <div class="d-grid gap-2">
            <button type="submit" class="btn btn-success">
                Se connecter
            </button>
        </div>

        <div class="text-center mt-3">
            <a href="/views/backend/security/signup.php">
                Pas encore de compte ? S’inscrire
            </a>
        </div>

    </form>
</div>

<?php include '../../../footer.php'; ?>
