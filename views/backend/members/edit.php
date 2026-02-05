<?php

include '../../../header.php';

if (!isset($_GET['numM'])) {
    $_SESSION['error_message'] = "ID du membre manquant.";
    header('Location: list.php');
    exit();
}

$numM = $_GET['numM'];

$member = function_exists('sql_select') ? sql_select('MEMBRE', '*', "numMemb = $numM") : null;
if (!$member) {
    $_SESSION['error_message'] = "Membre non trouvé.";
    header('Location: list.php');
    exit();
}

$member = $member[0];

$statuts = function_exists('sql_select') ? sql_select('STATUT', '*', null, null, 'libStat ASC') : [];

$dtCrea = isset($member['dtCreaMemb']) ? $member['dtCreaMemb'] : 'N/A';
?>

<div class="flex-grow-1">

<div class="container d-flex justify-content-center mt-4">
	<div class="w-100" style="max-width:900px;">
		<div class="d-flex justify-content-between align-items-center mb-3">
			<h2 class="text-center w-100">Modification Membre</h2>
		</div>

		<?php if(isset($_SESSION['success_message'])): ?>
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<?php echo $_SESSION['success_message']; unset($_SESSION['success_message']); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<?php if(isset($_SESSION['error_message'])): ?>
			<div class="alert alert-danger alert-dismissible fade show" role="alert">
				<?php echo $_SESSION['error_message']; unset($_SESSION['error_message']); ?>
				<button type="button" class="close" data-dismiss="alert" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
		<?php endif; ?>

		<div class="card border-0 bg-transparent shadow-none">
			<div class="card-body p-0">
			<form id="memberEditForm" method="post" action="<?php echo defined('ROOT_URL') ? ROOT_URL . '/api/members/update.php' : '../../api/members/update.php'; ?>">

				<input type="hidden" name="numM" value="<?php echo htmlspecialchars($numM); ?>">

				<div class="form-row">
					<div class="form-group col-md-3">
						<label for="numMembDisplay">Numéro</label>
						<input type="text" class="form-control" id="numMembDisplay" value="<?php echo htmlspecialchars($member['numMemb']); ?>" readonly>
					</div>
					<div class="form-group col-md-3">
						<label for="pseudoDisplay">Pseudo</label>
						<input type="text" class="form-control" id="pseudoDisplay" value="<?php echo htmlspecialchars($member['pseudoMemb']); ?>" readonly>
						<small class="form-text text-muted">Non modifiable</small>
					</div>
					<div class="form-group col-md-6">
						<label for="dtCreaDisplay">Date de création</label>
						<input type="text" class="form-control" id="dtCreaDisplay" value="<?php echo htmlspecialchars($dtCrea); ?>" readonly>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="prenomMemb">Prénom</label>
						<input type="text" class="form-control" id="prenomMemb" name="prenomMemb" value="<?php echo htmlspecialchars($member['prenomMemb'] ?? ''); ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="nomMemb">Nom</label>
						<input type="text" class="form-control" id="nomMemb" name="nomMemb" value="<?php echo htmlspecialchars($member['nomMemb'] ?? ''); ?>">
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="passMemb">Mot de passe</label>
						<input type="password" class="form-control" id="passMemb" name="passMemb" minlength="8" maxlength="15">
						<div class="form-check mt-1">
							<input class="form-check-input" type="checkbox" id="showPass" onclick="togglePassword()">
							<label class="form-check-label" for="showPass">Afficher Mot de passe</label>
						</div>
						<small class="form-text text-muted">Laisser vide pour garder le mot de passe actuel. Si changement : 8–15 caractères, au moins 1 majuscule, 1 minuscule et 1 chiffre.</small>
					</div>

					<div class="form-group col-md-6">
						<label for="numStat">Statut</label>
						<select id="numStat" name="numStat" class="form-control">
							<option value="">Choisissez un statut</option>
							<?php foreach ($statuts as $st): ?>
								<option value="<?php echo $st['numStat']; ?>" <?php echo (isset($member['numStat']) && $member['numStat'] == $st['numStat']) ? 'selected' : ''; ?>>
									<?php echo htmlspecialchars($st['libStat']); ?>
								</option>
							<?php endforeach; ?>
						</select>
					</div>
				</div>

				<div class="form-row">
					<div class="form-group col-md-6">
						<label for="eMailMemb">Email</label>
						<input type="email" class="form-control" id="eMailMemb" name="eMailMemb" value="<?php echo htmlspecialchars($member['eMailMemb'] ?? ''); ?>">
					</div>
					<div class="form-group col-md-6">
						<label for="confirmEmailMemb">Confirmation Email</label>
						<input type="email" class="form-control" id="confirmEmailMemb" name="confirmEmailMemb" value="<?php echo htmlspecialchars($member['eMailMemb'] ?? ''); ?>">
					</div>
				</div>

				<div class="d-flex gap-3 mt-4">
					<a href="list.php" class="btn btn-moyen">List</a>
					<button type="submit" class="btn btn-fonce">Confirmer Edit ?</button>
				</div>
			</form>
		</div>
	</div>
</div>

</div>

<script src="https://www.google.com/recaptcha/api.js" async defer></script>

<script>
function togglePassword(){
	var f = document.getElementById('passMemb');
	f.type = (f.type === 'password') ? 'text' : 'password';
}

document.getElementById('memberEditForm').addEventListener('submit', function(e){
	var email = document.getElementById('eMailMemb').value.trim();
	var emailc = document.getElementById('confirmEmailMemb').value.trim();
	var pass = document.getElementById('passMemb').value;

	if(pass !== ''){
		var passRegex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[\s\S]{8,15}$/;
		if(!passRegex.test(pass)){
			alert('Le mot de passe doit contenir 8–15 caractères, au moins une majuscule, une minuscule et un chiffre.');
			e.preventDefault(); return false;
		}
	}

	if(email !== emailc){
		alert('Les adresses email doivent être identiques.');
		e.preventDefault(); return false;
	}

	return true;
});
</script>

<?php
include '../../../footer.php';
?>