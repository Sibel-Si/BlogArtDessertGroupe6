<?php require_once '../../header.php';?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Délices Bordelais</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <section class="stripe-separator"></section>
    
    <section class="hero-banner">
        <h2 class="hero-title">Acteurs</h2>
    </section>

    <section class="stripe-separator"></section>

    <main class="content-grid-container">
        <div class="bg-illustration muffin">🧁</div>
        <div class="bg-illustration pain">🍞</div>
        <div class="bg-illustration croissant">🥐</div>
        <div class="bg-illustration baguette">🥖</div>

        <div class="grid">
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
            <div class="grid-item"></div>
        </div>
    </main>

    <!-- Load JS scripts -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<script href="css/style.css"></script>
<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Della+Respira&display=swap" rel="stylesheet">
<!-- Custom CSS -->
<link rel="stylesheet" href="<?php echo ROOT_URL . '/src/css/style.css' ?>" />


<footer class="row row-cols-5 py-5 my-5 border-top navbar footer-custom">
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
		<li class="nav-item mb-2"><a href="/views/frontend/events.php" class="nav-link p-0 hyperliens">Evénements</a></li>
		<li class="nav-item mb-2"><a href="/views/frontend/actors.php" class="nav-link p-0 hyperliens">Acteurs</a></li>
		<li class="nav-item mb-2"><a href="/views/frontend/original.php" class="nav-link p-0 hyperliens">Insolite</a></li>
	</ul>
	</div>

	<div class="col">
	<h5>Mentions Légales</h5>
	<ul class="nav flex-column">
		<li class="nav-item mb-2"><a href="/views/frontend/rgpd/cgu.php" class="nav-link p-0 hyperliens">CGU</a></li>
		<li class="nav-item mb-2"><a href="/views/frontend/rgpd/rgpd.php" class="nav-link p-0 hyperliens">RGPD et Cookies</a></li>
	</ul>
	</div>
</footer>
</body>
</html>

</body>
</html>
