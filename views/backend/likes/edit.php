<?php


// PHP — посередник між базою даних і HTML
// На цій сторінці ми:
// 1) беремо дані з URL (кого і яку статтю редагуємо)
// 2) дістаємо поточний like/unlike з БД
// 3) показуємо форму з radio (Like/Unlike)

include '../../../header.php'; // Підключаємо header (bootstrap, меню, початок HTML)

// Перевіряємо, чи в URL є обидва параметри:
// edit.php?numMemb=2&numArt=5
if (isset($_GET['numMemb']) && isset($_GET['numArt'])) {

    // Беремо numMemb з URL і перетворюємо на число
    // (int) — щоб уникнути “літери замість числа” і підвищити безпеку
    $numMemb = (int)$_GET['numMemb'];

    // Беремо numArt з URL і перетворюємо на число
    $numArt  = (int)$_GET['numArt'];

    // Дістаємо з БД рядок з таблиці likeart,
    // який відповідає цій парі: numMemb + numArt
    // Це наш “конкретний лайк”
    $likeRow = sql_select("likeart", "*", "numMemb = $numMemb AND numArt = $numArt")[0]; // [0] — бо sql_select повертає масив рядків, беремо перший

    // Беремо поле likeA:
    // likeA = 1 означає like
    // likeA = 0 означає unlike
    $likeA = (int)$likeRow['likeA'];

    // Дістаємо дані користувача (membre),
    // щоб показати його pseudo на сторінці (але не редагувати)
    $m = sql_select("membre", "*", "numMemb = $numMemb")[0];

    // Дістаємо дані статті (article),
    // щоб показати назву статті (але не редагувати)
    $a = sql_select("article", "*", "numArt = $numArt")[0];
}
?>

<!-- Bootstrap контейнер -->
<div class="container">

  <div class="row">

    <div class="col-md-12">
      <h1>Modification Article (un)Liké</h1>
    </div>

    <div class="col-md-12">

      <!--
        Ця форма відправляє дані в api/likes/update.php
        method="post" означає: дані не в URL, а “всередині” запиту
      -->
      <form action="<?php echo ROOT_URL . '/api/likes/update.php'; ?>" method="post">

        <!--
          Обов’язково передаємо numMemb і numArt,
          бо likeart має складний ключ (2 числа).
          Це hidden: не видно, але ВІДПРАВЛЯЄТЬСЯ.
        -->
        <input type="hidden" name="numMemb" value="<?php echo $numMemb; ?>">
        <input type="hidden" name="numArt" value="<?php echo $numArt; ?>">

        <!-- Поле Membre (тільки для показу, disabled) -->
        <div class="form-group">
          <label>Membre</label>

          <!--
            disabled означає:
            - користувач не може змінити
            - і це поле НЕ відправиться в POST
            Але нам це ок, бо numMemb ми вже передаємо через hidden вище
          -->
          <input class="form-control" type="text" value="<?php echo $m['pseudoMemb'] . ' (numéro ' . $numMemb . ')'; ?>" disabled>
        </div>

        <br>

        <!-- Поле Article (тільки для показу, disabled) -->
        <div class="form-group">
          <label>Article</label>

          <input class="form-control" type="text" value="<?php echo $a['libTitrArt']; ?>" disabled>
        </div>

        <br>

        <!-- Тут ми реально редагуємо like/unlike -->
        <div class="form-group">
          <label>Article (un)Liké ?</label><br>

          <!--
            radio кнопка Like
            value="1" означає likeA = 1
            checked ставимо якщо в БД зараз likeA == 1
          -->
          <input type="radio"id="like" name="likeA" value="1"
                 <?php if ($likeA === 1) echo "checked"; ?>>
          <label for="like">Like</label>

          &nbsp;&nbsp;

          <!--
            radio кнопка Unlike
            value="0" означає likeA = 0
            checked ставимо якщо в БД зараз likeA == 0
          -->
          <input type="radio" id="unlike" name="likeA" value="0"
                 <?php if ($likeA === 0) echo "checked"; ?>>
          <label for="unlike">Unlike</label>
        </div>

        <br>

        <!-- Кнопки внизу -->
        <div class="form-group mt-2">

          <!-- Повернутись на список -->
          <a href="list.php" class="btn btn-moyen">List</a>

          <!--
            submit — відправляє форму
            після цього запрацює api/likes/update.php
          -->
          <button type="submit" class="btn btn-fonce">
            Confirmer Edit ?
          </button>

        </div>

      </form>

    </div>
  </div>
</div>
