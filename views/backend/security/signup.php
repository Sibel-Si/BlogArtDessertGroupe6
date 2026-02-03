<?php
include '../../../header.php';
?>

<div class="button-group">
    <a href="/" class="btn-custom">HOME</a>
</div>

<div class="form-container">
    <div class="form-decoration-1">🥐</div>
    <div class="form-decoration-2">🥖</div>
    <div class="form-decoration-3">🧁</div>
    <div class="form-decoration-4">🍞</div>

    <div class="form-title">Créer un Compte</div>

    <form action="<?php echo ROOT_URL . '/api/members/create.php' ?>" method="post" onsubmit="return validateSignupForm()">
        
        <div class="form-group">
            <label for="pseudo">Pseudo <span style="color: var(--caramel);">*</span></label>
            <input 
                id="pseudo" 
                name="pseudo" 
                type="text" 
                placeholder="Choisissez votre pseudo" 
                required 
            />
        </div>

        <div class="form-group">
            <label for="firstName">Prénom <span style="color: var(--caramel);">*</span></label>
            <input 
                id="firstName" 
                name="firstName" 
                type="text" 
                placeholder="Votre prénom" 
                required 
            />
        </div>

        <div class="form-group">
            <label for="lastName">Nom <span style="color: var(--caramel);">*</span></label>
            <input 
                id="lastName" 
                name="lastName" 
                type="text" 
                placeholder="Votre nom" 
                required 
            />
        </div>

        <div class="form-group">
            <label for="email">E-Mail <span style="color: var(--caramel);">*</span></label>
            <input 
                id="email" 
                name="email" 
                type="email" 
                placeholder="Votre adresse e-mail" 
                required 
            />
        </div>

        <div class="form-group">
            <label for="password">Mot de Passe <span style="color: var(--caramel);">*</span></label>
            <input 
                id="password" 
                name="password" 
                type="password" 
                placeholder="Entrez un mot de passe sécurisé" 
                required 
            />
        </div>

        <div class="captcha-box">
            🔒 Captcha - Vérification de sécurité
        </div>

        <?php if(isset($_SESSION['error_message'])): ?>
            <div style="background-color: #ffcccc; border: 2px solid #cc0000; padding: 12px; border-radius: 8px; color: #cc0000; margin: 15px 0;">
                <?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
            </div>
        <?php endif; ?>

        <?php if(isset($_SESSION['success_message'])): ?>
            <div style="background-color: #ccffcc; border: 2px solid #00cc00; padding: 12px; border-radius: 8px; color: #00cc00; margin: 15px 0;">
                <?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
            </div>
        <?php endif; ?>

        <div class="form-buttons">
            <button type="submit" class="btn-create">Créer mon Compte</button>
            <a href="login.php" class="btn-secondary">Déjà un compte ?</a>
        </div>
    </form>
</div>

<script>
function validateSignupForm() {
    const pseudo = document.getElementById('pseudo').value.trim();
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (pseudo === '') {
        alert('Le pseudo est obligatoire.');
        return false;
    }
    if (firstName === '') {
        alert('Le prénom est obligatoire.');
        return false;
    }
    if (lastName === '') {
        alert('Le nom est obligatoire.');
        return false;
    }
    if (email === '') {
        alert('L\'adresse e-mail est obligatoire.');
        return false;
    }
    if (!email.includes('@')) {
        alert('Veuillez entrer une adresse e-mail valide.');
        return false;
    }
    if (password === '') {
        alert('Le mot de passe est obligatoire.');
        return false;
    }
    if (password.length < 6) {
        alert('Le mot de passe doit contenir au moins 6 caractères.');
        return false;
    }
    return true;
}
</script>

<style>
    .form-container {
        background: linear-gradient(135deg, rgba(245, 241, 232, 0.95), rgba(232, 220, 200, 0.95));
    }

    .form-group input:hover {
        background-color: #E0D4B8;
    }

    .btn-secondary {
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    .btn-secondary:hover {
        text-decoration: none;
        color: white !important;
    }
</style>

<?php require_once '../../../footer.php'; ?>
