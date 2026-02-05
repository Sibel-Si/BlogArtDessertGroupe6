<?php require_once 'header.php'; ?>

  <section class="hero-mock">
    <div class="hero-mock-inner">

      <div class="hero-band">
        <h1 class="hero-title">Les Délices<br>Bordelais</h1>
      </div>

      <!-- LEFT image -->
      <div class="mock-img mock-img-left">
        <img src="/src/images/-27.jpg" alt="Canelé bordelais">
      </div>

      <!-- RIGHT image -->
      <div class="mock-img mock-img-right">
        <img src="/src/images/-28.jpg" alt="Croissant">
      </div>

    </div>
  </section>
  <section class="home-section2">
    <div class="home-section2-inner">

      <!-- LEFT big image -->
      <div class="s2-left">
        <img src="/src/images/fb56daae739c9bdb50421bc77543bc4f.jpg" alt="Image pâtisserie">
      </div>
      


      <!-- RIGHT text content -->
      <div class="s2-right">
        
        </div>
        

        <div class="s2-text">
          <p>
            Bienvenue sur <strong>Les Délices Bordelais</strong>, un blog dédié aux
            saveurs gourmandes du Sud-Ouest. Découvrez des recettes authentiques,
            des spécialités locales et l’univers de la pâtisserie bordelaise. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Aenean scelerisque erat sed finibus consequat. Aliquam elementum dolor nibh, mollis congue nulla tincidunt sed. Curabitur quis tristique erat, eget finibus sapien. Nam vehicula felis venenatis erat dignissim suscipit. Donec auctor sagittis leo vel sodales. Praesent eget justo suscipit nunc blandit sodales a sed nibh. Morbi suscipit porta mauris, quis interdum ipsum ornare sed. In in diam ac velit cursus convallis. Nunc tincidunt enim id tellus ornare sagittis. Pellentesque tortor magna, tincidunt ut neque in, porttitor lacinia eros. Duis sit amet dapibus nunc. Orci varius natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Praesent ligula ante, faucibus eleifend posuere id, ornare imperdiet tortor. Sed sollicitudin hendrerit dignissim. Donec sagittis enim sed enim tristique, ut faucibus turpis venenatis. Cras justo elit, convallis eu dolor scelerisque, ornare auctor libero.
          </p>
        </div>
      </div>

    </div>
    
  </section>


<?php
/* якщо sql_select() не бачить — підключи лоадер функцій */
require_once __DIR__ . '/functions/global.inc.php';

/*AJOUT FILTRE THEMATIQUE (SANS CASSER TON CODE) */
/* 1) Беремо всі тематики для кнопок */
$themes = sql_select("thematique", "numThem, libThem", null, null, "numThem ASC", null);

/* 2) Яка тематика вибрана (через GET) */
$them = isset($_GET['them']) ? intval($_GET['them']) : 0;

/* 3) WHERE для статей */
$where = null;
if ($them > 0) {
  $where = "numThem = " . $them;   // ok, бо intval()
}


/* Забираємо статті з БД (тепер з фільтром) */
$articles = sql_select(
  "article",
  "numArt, libTitrArt, libChapoArt, libAccrochArt, urlPhotArt, dtCreaArt, numThem",
  $where,
  null,
  "dtCreaArt DESC",
  6
);
?>

  <section class="home-articles py-4">
    <div class="container">
      <h3 class="mb-4">Nos articles</h3>

      <!--  AJOUT BOUTONS FILTRE  -->
      <div class="d-flex flex-wrap gap-2 mb-4">
        <a href="?them=0"
           class="btn btn-moyen <?= ($them === 0 ? 'active' : '') ?>">
          Tout
        </a>

        <?php foreach ($themes as $t): ?>
          <a href="?them=<?= (int)$t['numThem'] ?>"
             class="btn btn-clair <?= ($them === (int)$t['numThem'] ? 'active' : '') ?>">
            <?= htmlspecialchars($t['libThem']) ?>
          </a>
        <?php endforeach; ?>
      </div>
    

      <div class="row row-cols-1 row-cols-md-3 row-cols-lg-3 g-4">
        <?php foreach ($articles as $a): ?>
          <?php
            $img = !empty($a['urlPhotArt'])
              ? "/src/uploads/" . $a['urlPhotArt']
              : "/src/images/article.png";
          ?>
          <div class="col">

            <a href="/views/frontend/articles/article1.php?numArt=<?= (int)$a['numArt'] ?>"
               class="text-decoration-none text-reset">

              <article class="card h-100">
                <img
                  src="<?= htmlspecialchars($img) ?>"
                  class="card-img-top"
                  alt="Image article"
                >

                <div class="card-body">
                  <h5 class="card-title mb-2">
                    <?= htmlspecialchars($a['libTitrArt'] ?? '') ?>
                  </h5>

                  <p class="card-text mb-2">
                    <?= htmlspecialchars($a['libChapoArt'] ?? '') ?>
                  </p>

                  <p class="card-text">
                    <small class="text-muted">
                      <?= htmlspecialchars($a['libAccrochArt'] ?? '') ?>
                    </small>
                  </p>
                </div>
              </article>

            </a>

          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </section>

<?php require_once 'footer.php'; ?>

</main>

<?php require_once 'footer.php'; ?>
