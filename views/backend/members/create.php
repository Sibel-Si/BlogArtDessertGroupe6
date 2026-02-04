<?php


include '../../../header.php';

// Load statuses for select if available
$statuts = function_exists('sql_select') ? sql_select('STATUT', '*', null, null, 'libStat ASC') : [];
?>

<div class="container d-flex justify-content-center mt-4">
	<div class="w-100" style="max-width:900px;">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h2 class="text-center w-100">Création nouveau Membre</h2>
		</div>

		<div class="card border-0 bg-transparent shadow-none">
			<div class="card-body p-0">
			<form id="memberCreateForm" method="post" action="<?php echo defined('ROOT_URL') ? ROOT_URL . '/api/members/create.php' : '../../api/members/create.php'; ?>">
				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="pseudoMemb">Pseudo</label>
						<input type="text" class="form-control" id="pseudoMemb" name="pseudoMemb" minlength="6" maxlength="70" required>
						<small class="form-text text-muted">6 à 70 caractères. Non modifiable après création.</small>
					</div>
					<div class="form-group col-md-3">
						<label for="prenomMemb">Prénom</label>
						<input type="text" class="form-control" id="prenomMemb" name="prenomMemb">
					</div>
					<div class="form-group col-md-3">
						<label for="nomMemb">Nom</label>
						<input type="text" class="form-control" id="nomMemb" name="nomMemb">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="passMemb">Mot de passe</label>
						<input type="password" class="form-control" id="passMemb" name="passMemb" minlength="8" maxlength="15" required>
						<div class="form-check mt-1">
							<input class="form-check-input" type="checkbox" id="showPass" onclick="togglePassword()">
							<label class="form-check-label" for="showPass">Afficher Mot de passe</label>
						</div>
						<small class="form-text text-muted">8–15 caractères, au moins 1 majuscule, 1 minuscule et 1 chiffre.</small>
					</div>

					<div class="form-group col-md-6">
						<label for="confirmPassMemb">Confirmation du mot de passe</label>
						<input type="password" class="form-control" id="confirmPassMemb" name="confirmPassMemb" minlength="8" maxlength="15" required>
						<div class="form-check mt-1">
							<input class="form-check-input" type="checkbox" id="showConfirmPass" onclick="toggleConfirmPassword()">
							<label class="form-check-label" for="showConfirmPass">Afficher Mot de passe</label>
						</div>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="eMailMemb">Email</label>
						<input type="email" class="form-control" id="eMailMemb" name="eMailMemb" required>
					</div>
					<div class="form-group col-md-6">
						<label for="confirmEmailMemb">Confirmation Email</label>
						<input type="email" class="form-control" id="confirmEmailMemb" name="confirmEmailMemb" required>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label>RGPD</label>
						<div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="accordMemb" id="accordOui" value="1" required>
								<label class="form-check-label" for="accordOui">Oui</label>
							</div>
							<div class="form-check form-check-inline">
								<input class="form-check-input" type="radio" name="accordMemb" id="accordNon" value="0">
								<label class="form-check-label" for="accordNon">Non</label>
							</div>
						</div>
					</div>

					<div class="form-group col-md-6">
						<label for="numStat">Statut</label>
						<select id="numStat" name="numStat" class="form-control">
							<option value="">Choisissez un statut</option>
							<?php foreach ($statuts as $st): ?>
								<option value="<?php echo $st['numStat']; ?>"><?php echo htmlspecialchars($st['libStat']); ?></option>
							<?php endforeach; ?>
						</select>
					</div>
				</div> 

				<div class="form-group">
				<label>Sécurité</label>
				<!-- Google reCAPTCHA v2 -->
				<div class="g-recaptcha" data-sitekey="<?php echo getenv('RECAPTCHA_SITE_KEY'); ?>"></div>
				<small class="form-text text-muted">Vérifiez que vous n'êtes pas un robot.</small>
			</div>

			<div class="d-flex gap-3 mt-4">
				<a href="list.php" class="btn btn-moyen">List</a>
				<button type="submit" class="btn btn-clair">Create</button>
				</div>
			</form>
		</div>
	</div>
</div>

<script>
function togglePassword(){
	var f = document.getElementById('passMemb');
	f.type = (f.type === 'password') ? 'text' : 'password';
}
function toggleConfirmPassword(){
	var f = document.getElementById('confirmPassMemb');
	f.type = (f.type === 'password') ? 'text' : 'password';
}

document.getElementById('memberCreateForm').addEventListener('submit', function(e){
	var pseudo = document.getElementById('pseudoMemb').value.trim();
	if(pseudo.length < 6 || pseudo.length > 70){
		alert('Le pseudo doit contenir entre 6 et 70 caractères.');
		e.preventDefault(); return false;
	}

	var pass = document.getElementById('passMemb').value;
	var confirm = document.getElementById('confirmPassMemb').value;
	var email = document.getElementById('eMailMemb').value.trim();
	var emailc = document.getElementById('confirmEmailMemb').value.trim();

	// password policy
	var passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,15}$/;
	if(!passRegex.test(pass)){
		alert('Le mot de passe doit contenir 8–15 caractères, au moins une majuscule, une minuscule et un chiffre.');
		e.preventDefault(); return false;
	}
	if(pass !== confirm){
		alert('Les mots de passe ne correspondent pas.');
		e.preventDefault(); return false;
	}
	if(email === '' || emailc === '' || email !== emailc){
		alert('Les adresses email doivent être identiques et valides.');
		e.preventDefault(); return false;
	}

	// RGPD radio required check
	var accordOui = document.getElementById('accordOui').checked;
	if(!accordOui){
		var accordNon = document.getElementById('accordNon').checked;
		if(!accordNon){
			alert('Vous devez répondre à la question RGPD.');
			e.preventDefault(); return false;
		}
	}

	// reCAPTCHA check: verify user has completed the challenge
	var recaptchaResponse = document.querySelector('textarea[name="g-recaptcha-response"]');
	if(!recaptchaResponse || recaptchaResponse.value === ''){
		alert('Veuillez cocher la case reCAPTCHA pour confirmer que vous n\'êtes pas un robot.');
		e.preventDefault(); return false;
	}

	// Server-side verification note: After form submission, verify the reCAPTCHA token in api/members/create.php
	// using: https://www.google.com/recaptcha/api/siteverify with your SECRET_KEY
	return true;
});
</script>

