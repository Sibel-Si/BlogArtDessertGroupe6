<?php 
require_once 'header.php';
//sql_connect();
?>

<!-- BANDE RAYÉE SUPÉRIEURE -->
<div class="striped-band-top"></div>
<div class="button-group">
	<a href="#admin" class="btn-custom">ADMIN</a>
	<a href="#search" class="btn-custom">RECHERCHE</a>

<!-- BANNIÈRE HÉRO CARAMEL AVEC TITRE -->
<div class="hero-banner">
    <h1>Les Délices<br>Bordelais</h1>
<div class="header-banner">
	<h1>Les Délices Bordelais <span class="emoji">🥐</span></h1>
</div>

<!-- BANDE RAYÉE INFÉRIEURE -->
<div class="striped-band-bottom"></div>
<div class="striped-section"></div>

<div class="central-band">
	<h2>SAVEURS GOURMANDES DU SUD-OUEST</h2>
</div>

<!-- CONTENEUR DES IMAGES ASYMÉTRIQUES -->
<div class="hero-images-container">
    <!-- Image gauche (chevauche bande sup + bannière) -->
    <div class="image-left">
        <img src="<?php echo ROOT_URL . '/src/images/cannele.jpg'; ?>" alt="Cannelés Bordelais">
    </div>
<div class="striped-section"></div>

<div class="content-section">
	<div class="images-grid">
		<div class="image-wrapper">
			<div class="pastry-image asymmetric-1">
				<img src="src/images/cannele.jpg" alt="Cannelé Bordelais">
				<div class="pastry-caption">CANNELÉS AUTHENTIQUES</div>
			</div>
		</div>
		<div class="image-wrapper">
			<div class="pastry-image asymmetric-2">
				<img src="src/images/fondant-chocolat.jpg" alt="Fondant au Chocolat">
				<div class="pastry-caption">FONDANT AU CHOCOLAT</div>
			</div>
		</div>
	</div>
</div>

    <!-- Image droite (chevauche bannière + bande inf) -->
    <div class="image-right">
        <img src="<?php echo ROOT_URL . '/src/images/fondant-chocolat.jpg'; ?>" alt="Fondant au Chocolat">
    </div>
</div>

<?php require_once 'footer.php'; ?>
