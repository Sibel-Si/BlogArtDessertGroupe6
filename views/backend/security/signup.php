<?php
include '../../../header.php';
?>
<div class="container mt-5" style="max-width: 500px;">

    <h2 class="mb-4 text-center">
        <i class="bi bi-person-plus"></i> Inscription
    </h2>

    <form method="post" action="/api/security/signup.php">

        <label class="form-label">Pseudo (non modifiable)</label>
        <input type="text" name="pseudoMemb" class="form-control" required>

        <label class="form-label mt-3">Prénom</label>
        <input type="text" name="prenomMemb" class="form-control" required>

        <label class="form-label mt-3">Nom</label>
        <input type="text" name="nomMemb" class="form-control" required>

        <label class="form-label mt-3">E-mail</label>
        <input type="email" name="emailMemb" class="form-control" required>

        <label class="form-label mt-3">Confirmez e-mail</label>
        <input type="email" name="emailMembConfirm" class="form-control" required>

        <label class="form-label mt-3">Mot de passe</label>
        <input type="password" name="passMemb" class="form-control" required>

        <label class="form-label mt-3">Confirmez mot de passe</label>
        <input type="password" name="passMembConfirm" class="form-control" required>

        <label class="form-label mt-3">J'accepte que mes informations soient conservées</label>
        <div class="d-flex gap-3">
            <div>
                <input type="radio" id="accordOui" name="accordMemb" value="1" required>
                <label for="accordOui">Oui</label>
            </div>
            <div>
                <input type="radio" id="accordNon" name="accordMemb" value="0" required>
                <label for="accordNon">Non</label>
            </div>
        </div>

        <div class="mt-4">
            <button type="submit" class="btn btn-success w-100">Créer mon compte</button>
        </div>

    </form>
</div>

<?php
include $_SERVER['DOCUMENT_ROOT'] . '/footer.php';
?>