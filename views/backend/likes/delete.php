<?php
session_start();
require_once ROOT_URL . '/functions/security.php';

// Define the required level (e.g., 1 for Admin, 2 for Moderator)
$required_level = 1; 

if (!check_access($required_level)) {
    // Redirect unauthorized users to login or an error page
    header("Location: login.php?error=unauthorized");
    exit(); // Always exit after a header redirect
}

// PHP — посередник між базою даних і сторінкою
// Ця сторінка НЕ видаляє нічого
// Вона тільки:
// 1) бере numMemb і numArt з URL
// 2) знаходить відповідний рядок у БД (likeart)
// 3) показує інформацію користувачу
// 4) дає кнопку "Confirmer Delete ?"

include '../../../header.php'; // підключаємо header (bootstrap, меню, початок HTML)

// Перевіряємо: чи в URL є обидва параметри
// delete.php?numMemb=2&numArt=5
if (isset($_GET['numMemb']) && isset($_GET['numArt'])) {

    // Беремо номер користувача з URL, перетворюємо на int
    // щоб було безпечніше і точно число
    $numMemb = (int)$_GET['numMemb'];

    // Беремо номер статті з URL, перетворюємо на int
    $numArt  = (int)$_GET['numArt'];

    // Дістаємо з БД конкретний рядок із likeart
    // Тут важливо: в likeart ключ складається з 2 полів:
    // numMemb + numArt
    $likeRow = sql_select(
        "likeart",
        "*",
        "numMemb = $numMemb AND numArt = $numArt"
    )[0]; // [0] бо sql_select повертає масив рядків

    // Забираємо значення likeA (1=like, 0=unlike)
    $likeA = (int)$likeRow['likeA'];

    // Дістаємо інформацію про користувача для красивого показу
    $m = sql_select("membre", "*", "numMemb = $numMemb")[0];

    // Дістаємо інформацію про статтю для красивого показу
    $a = sql_select("article", "*", "numArt = $numArt")[0];
}
?>

<!-- HTML частина сторінки -->
<div class="container">
  <div class="row">

    <div class="col-md-12">
      <h1>Suppression Article (Un)Liké</h1>
    </div>

    <div class="col-md-12">

      <!--
        Ця форма відправляє дані в api/likes/delete.php
        Саме API робить DELETE в базі даних
      -->
      <form action="<?php echo ROOT_URL . '/api/likes/delete.php'; ?>" method="post">

        <!--
          Це hidden поля:
          - їх не видно
          - але вони ВІДПРАВЛЯЮТЬСЯ в POST
          Вони обов’язкові, бо:
          API має знати, який саме рядок delete робити
          (а рядок визначається парою numMemb + numArt)
        -->
        <input type="hidden" name="numMemb" value="<?php echo $numMemb; ?>">
        <input type="hidden" name="numArt" value="<?php echo $numArt; ?>">

        <!-- Поле Membre (тільки показ, disabled) -->
        <div class="form-group">
          <label>Membre</label>

          <!--
            disabled = не можна змінити
            і значення не відправляється
            (але це не проблема, бо ми відправляємо numMemb через hidden)
          -->
          <input class="form-control" type="text" value="<?php echo $m['pseudoMemb'] . ' (numéro ' . $numMemb . ')'; ?>" disabled>
        </div>

        <br>

        <!-- Поле Article (тільки показ, disabled) -->
        <div class="form-group">
          <label>Article</label>

          <input class="form-control" type="text" value="<?php echo $a['libTitrArt']; ?>"
                 disabled>
        </div>

        <br>

        <!-- Показуємо like/unlike (тільки показ, disabled) -->
        <div class="form-group">
          <label>Article liké ?</label><br>

          <!--
            Тут radio disabled:
            - користувач не може міняти
            - це просто “перевірка перед видаленням”
          -->
          <input type="radio" <?php if ($likeA === 1) echo "checked"; ?> disabled>
          <label>Like</label>

          &nbsp;&nbsp;

          <input type="radio" <?php if ($likeA === 0) echo "checked"; ?> disabled>
          <label>Unlike</label>
        </div>

        <br>

        <!-- Кнопки -->
        <div class="form-group mt-2">

          <!-- Повернутись до списку -->
          <a href="list.php" class="btn btn-moyen">List</a>

          <!--
            submit = підтвердити
            → відправить форму в api/likes/delete.php
            → там буде реальний DELETE
          -->
          <button type="submit" class="btn btn-fonce">
            Confirmer Delete ?
          </button>

        </div>

      </form>

    </div>
  </div>
</div>
