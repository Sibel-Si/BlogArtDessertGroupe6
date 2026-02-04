<?php
include '../../../header.php';
<<<<<<< Updated upstream
?>
=======
?>

<!-- CARAMEL MAIN BAND WITH "NOM DU BLOG" -->
<div class="main-caramel-band">
    <h2>INSCRIPTIONS</h2>
</div>

<div class="form-container">
    <div class="form-card">
        <h3>👤 Créer un Compte</h3>
        
        <form action="<?php echo ROOT_URL . '/api/members/create.php' ?>" method="post" onsubmit="return validateSignupForm()">
            
            <div class="form-group">
                <label for="pseudo">Pseudo *</label>
                <input id="pseudo" name="pseudo" type="text" placeholder="Choisissez votre pseudo" required />
            </div>

            <div class="form-group">
                <label for="firstName">Prénom *</label>
                <input id="firstName" name="firstName" type="text" placeholder="Votre prénom" required />
            </div>

            <div class="form-group">
                <label for="lastName">Nom *</label>
                <input id="lastName" name="lastName" type="text" placeholder="Votre nom" required />
            </div>

            <div class="form-group">
                <label for="email">E-Mail *</label>
                <input id="email" name="email" type="email" placeholder="Votre adresse e-mail" required />
            </div>

            <div class="form-group">
                <label for="password">Mot de Passe *</label>
                <input id="password" name="password" type="password" placeholder="Entrez un mot de passe sécurisé" required />
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
                <button type="submit" class="btn-create">Create</button>
                <a href="login.php" class="btn-already">Déjà un compte ?</a>
            </div>
        </form>
    </div>
</div>

<!-- Line-art decorations -->
<svg class="line-art-decoration line-art-1" viewBox="0 0 100 100" style="position: absolute; top: 60px; right: 40px; width: 60px; opacity: 0.15;">
    <!-- Muffin -->
    <ellipse cx="50" cy="30" rx="20" ry="15" fill="none" stroke="currentColor" stroke-width="0.8"/>
    <ellipse cx="50" cy="50" rx="25" ry="12" fill="none" stroke="currentColor" stroke-width="0.8"/>
</svg>

<svg class="line-art-decoration line-art-2" viewBox="0 0 100 100" style="position: absolute; bottom: 200px; left: 30px; width: 70px; opacity: 0.15;">
    <!-- Bread loaf -->
    <ellipse cx="50" cy="50" rx="30" ry="35" fill="none" stroke="currentColor" stroke-width="0.8"/>
    <line x1="30" y1="50" x2="70" y2="50" stroke="currentColor" stroke-width="0.8"/>
</svg>

<svg class="line-art-decoration line-art-3" viewBox="0 0 100 100" style="position: absolute; top: 120px; right: 20px; width: 80px; opacity: 0.15; transform: rotate(-30deg);">
    <!-- Baguette -->
    <line x1="10" y1="80" x2="90" y2="20" stroke="currentColor" stroke-width="1.5"/>
</svg>

<script>
function validateSignupForm() {
    const pseudo = document.getElementById('pseudo').value.trim();
    const firstName = document.getElementById('firstName').value.trim();
    const lastName = document.getElementById('lastName').value.trim();
    const email = document.getElementById('email').value.trim();
    const password = document.getElementById('password').value.trim();

    if (pseudo === '' || firstName === '' || lastName === '' || email === '' || password === '') {
        alert('Tous les champs sont obligatoires.');
        return false;
    }
    if (!email.includes('@')) {
        alert('Veuillez entrer une adresse e-mail valide.');
        return false;
    }
    if (password.length < 6) {
        alert('Le mot de passe doit contenir au moins 6 caractères.');
        return false;
    }
    return true;
}
</script>

<?php require_once '../../../footer.php'; ?>
>>>>>>> Stashed changes
