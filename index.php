<?php 
require_once 'header.php';
?>

<!-- BOUTONS EN HAUT À DROITE -->
<div class="homepage-buttons">
    <a href="/views/backend/security/login.php" class="homepage-btn">ADMIN</a>
    <a href="/views/frontend/search.php" class="homepage-btn">RECHERCHE</a>
</div>

<!-- BANNIÈRE SUPÉRIEURE BEIGE -->
<div class="homepage-banner">
    <h1 class="homepage-title">Les Délices Bordelais <span class="emoji-cannele">🥐</span></h1>
</div>

<!-- BANDES RAYURES BICOLORES -->
<div class="homepage-stripes stripes-1"></div>

<!-- BANDE CARAMEL CENTRALE AVEC SLOGAN -->
<div class="homepage-caramel-band">
    <h2>SAVEURS GOURMANDES DU SUD-OUEST</h2>
</div>

<!-- BANDES RAYURES BICOLORES -->
<div class="homepage-stripes stripes-2"></div>

<!-- SECTION PRINCIPALE AVEC IMAGES ASYMÉTRIQUES -->
<div class="homepage-content">
    <div class="homepage-images">
        <!-- Image 1: Cannelés (haut gauche, asymétrique) -->
        <div class="image-box image-cannele">
            <img src="/src/images/cannele.jpg" alt="Cannelés Bordelais">
            <div class="image-caption">CANNELÉS AUTHENTIQUES</div>
        </div>

        <!-- Image 2: Fondant au Chocolat (bas droite, asymétrique) -->
        <div class="image-box image-fondant">
            <img src="/src/images/fondant-chocolat.jpg" alt="Fondant au Chocolat">
            <div class="image-caption">FONDANT AU CHOCOLAT</div>
        </div>
    </div>
</div>

<!-- DÉCORATION FINALE -->
<div class="homepage-decoration">
    🥐 ✨ 🍰 ✨ 🥐
</div>

<?php require_once 'footer.php'; ?>
