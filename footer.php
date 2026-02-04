<!-- Load JS scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script href="css/style.css"></script>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Della+Respira&display=swap" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo ROOT_URL . '/src/css/style.css' ?>" />

<!-- <footer>
	footer
	<p>BlogArt'26</p>
	<ul>
		<li>Sterenn Piga-Chavigny</li>
		<li>Viktoriia Rudenko</li>
		<li>Yassmine Rgana El Hami</li>
		<li>Maïlyse Wilson</li>
		<li>Sever Sibel</li>
	</ul>
	<div>
		<p>Plan du Site :</p>
		<p>Evenement</p>
		<p>Acteur</p>
		<p>Insolite</p>
	</div>
	<div>
		<p>Mentions légales</p>
		<p><a href="/views/frontend/rgpd/rgpd.php">RGPD</a></p>
		<p><a href="/views/frontend/rgpd/cgu.php">CGU</a></p>
	</div>
</footer> -->


<footer class="row row-cols-5 py-5 my-5 border-top navbar">
	<div class="col">
	<a href="/" class="d-flex align-items-center mb-3 link-dark text-decoration-none">
		<svg class="bi me-2" width="40" height="32"><use xlink:href="#bootstrap"></use></svg>
	</a>
	<p class="">Blog'Art 2026</p>
	</div>

	<div class="col">

	</div>

	<div class="col">
	<h5>Crédits du Site</h5>
	<ul class="nav flex-column">
		<li class="nav-item mb-2">Sterenn Piga-Chavigny</li>
		<li class="nav-item mb-2">Viktoriia Rudenko</li>
		<li class="nav-item mb-2">Yassmine Rgana El Hami</li>
		<li class="nav-item mb-2">Maïlyse Wilson</li>
		<li class="nav-item mb-2">Sibel Sever</li>
	</ul>
	</div>

	<div class="col">
	<h5>Plan du Site</h5>
	<ul class="nav flex-column">
		<li class="nav-item mb-2"><a href="/views/frontend/events.php" class="nav-link p-0 text-muted">Evénements</a></li>
		<li class="nav-item mb-2"><a href="/views/frontend/actors.php" class="nav-link p-0 text-muted">Acteurs</a></li>
		<li class="nav-item mb-2"><a href="/views/frontend/original.php" class="nav-link p-0 text-muted">Insolite</a></li>
	</ul>
	</div>

	<div class="col">
	<h5>Mentions Légales</h5>
	<ul class="nav flex-column">
		<li class="nav-item mb-2"><a href="/views/frontend/rgpd/cgu.php" class="nav-link p-0 text-muted">CGU</a></li>
		<li class="nav-item mb-2"><a href="/views/frontend/rgpd/rgpd.php" class="nav-link p-0 text-muted">RGPD et Cookies</a></li>
	</ul>
	</div>
</footer>
</body>
</html>