<?php

include '../../../header.php';
check_page_access([1, 2]); 


// 1) Беремо всіх членів для першого select
$membres = sql_select("membre", "*", "1=1");

// 2) Якщо вже вибрали члена (через GET), то підготуємо список доступних статей
$selectedNumMemb = isset($_GET['numMemb']) ? (int)$_GET['numMemb'] : 0;

$articles = [];
if ($selectedNumMemb > 0) {
    // Вибираємо статті, які ЦЕЙ membre ще НЕ має в likeart
    // (тобто немає запису likeart для пари numMemb+numArt)
    $articles = sql_select(
        "article",
        "*",
        "numArt NOT IN (SELECT numArt FROM likeart WHERE numMemb = $selectedNumMemb)"
    );
} else {
    // Якщо membre ще не вибраний — можна показати пусто або всі
    $articles = [];
}
?>

<div class="container">
  <div class="row">
    <div class="col-md-12">
      <h1>Liker Article</h1>
    </div>

    <div class="col-md-12">

      <!-- Форма 1 (GET): тільки для вибору membre і перезавантаження сторінки -->
      <form method="get" action="create.php">
        <div class="form-group">
          <label for="numMemb">Membre :</label>
          <select id="numMemb" name="numMemb" class="form-control" onchange="this.form.submit()">
            <option value="0">--- Choisissez un membre ---</option>
            <?php foreach ($membres as $m): ?>
              <option value="<?php echo (int)$m['numMemb']; ?>"
                <?php if ($selectedNumMemb === (int)$m['numMemb']) echo "selected"; ?>>
                <?php echo $m['pseudoMemb'] . " (numéro " . $m['numMemb'] . ")"; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>
      </form>

      <br>

      <!-- Форма 2 (POST): реальне створення like -->
      <form action="<?php echo ROOT_URL . '/api/likes/create.php' ?>" method="post">

        <!-- Передаємо вибраного membre в POST -->
        <input type="hidden" name="numMemb" value="<?php echo $selectedNumMemb; ?>">

        <div class="form-group">
          <label for="numArt">Article :</label>
          <select id="numArt" name="numArt" class="form-control" <?php echo ($selectedNumMemb > 0) ? "" : "disabled"; ?>>
            <option value="0">--- Choisissez un article ---</option>

            <?php foreach ($articles as $a): ?>
              <option value="<?php echo (int)$a['numArt']; ?>">
                <?php echo $a['libTitrArt']; ?>
              </option>
            <?php endforeach; ?>
          </select>
        </div>

        <br>

        <p style="color:red;">
          Remarque : Dès le membre sélectionné, seuls les articles non encore likés par ce membre s'afficheront.
        </p>

        <div class="form-group mt-2">
          <a href="list.php" class="btn btn-moyen">List</a>

          <button type="submit" class="btn btn-clair" <?php echo ($selectedNumMemb > 0) ? "" : "disabled"; ?>>
            Create
          </button>
        </div>

      </form>

    </div>
  </div>
</div>
