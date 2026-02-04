<?php


//PHP — це “посередник” між: базою даних і веб-сторінкою 
// Він: питає базу даних: «дай мені інформацію» отримує відповідь показує її у вигляді таблиці

// Підключаємо header сайту (меню, bootstrap, початок HTML)
// Без цього сторінка виглядала б «порожньою»
include '../../../header.php';

//   Головний рядок - Запит до бази даних / Отримуємо ВСІ записи з таблиці likeart 
// "1=1" означає: без фільтра, просто взяти все
$likes = sql_select("likeart", "*", "1=1");
?>

<!-- Контейнер Bootstrap, щоб все було красиво вирівняно -->
<div class="container">

  <h1>Articles (Un)Likes</h1>

  <!-- Початок таблиці -->
  <table class="table">

    <!-- Заголовки колонок таблиці -->
    <thead>
      <tr>
        <th>Membre</th>     <!-- Хто лайкнув -->
        <th>Article</th>    <!-- Яку статтю -->
        <th>Chapeau Article</th>   <!-- Який шапо -->
        <th>Statut</th>     <!-- Like або Unlike -->
        <th>Actions</th>    <!-- Кнопки Edit / Delete -->
      </tr>
    </thead>

    <!-- Тіло таблиці -->
    <tbody>

    <?php
    // Ми беремо по одному рядку з таблиці likeart
    // і кладемо його в змінну $l

    // Ось тут PHP починає передавати дані в HTML / «Я буду показувати дані по одному рядку»
    //$likes — це список рядків з таблиці likeart
    //$likes — все разом / $l — один елемент з цього всього / foreach перебирає всі елементи по черзі
    foreach ($likes as $l): 
    ?>

      <?php
        // Зберігаємо ID користувача з поточного рядка
        $numMemb = $l['numMemb'];

        // Зберігаємо ID статті з поточного рядка
        $numArt  = $l['numArt'];

        // Зберігаємо статус лайка (1 = like, 0 = unlike)
        // (int) перетворює значення на число
        $likeA   = (int)$l['likeA'];

        // Отримуємо інформацію про користувача
        // [0] — бо sql_select повертає масив, а нам потрібен перший елемент
        $m = sql_select("membre", "*", "numMemb = $numMemb")[0];
        //«Знайди в базі даних користувача, у якого номер = $numMemb, і збережи цього користувача в змінну $m»

        // Отримуємо інформацію про статтю
        $a = sql_select("article", "*", "numArt = $numArt")[0];

        // Отримуємо інфориацію про шапку статті 
        $chapo = $a['libChapoArt'];

      ?>

      <!-- Початок одного рядка таблиці -->
      <tr>

        <!-- Колонка з ім’ям користувача та його ID 
         «Візьми ім’я з бази даних і напиши його на сторінці»-->
        <td>
          <?php echo $m['pseudoMemb'] . " ($numMemb)"; ?>
        </td>

        <!-- Колонка з назвою статті -->
        <td>
          <?php echo $a['libTitrArt']; ?>
        </td>

        <td>
          <?php echo $chapo; ?>
         </td>

        <!-- Колонка зі статусом like / unlike -->
        <td
          style="color:<?php
            // Якщо likeA = 1 → рожевий
            // Якщо likeA = 0 → помаранчевий
            echo $likeA ? 'green' : 'red';
          ?>"
        >
          <?php
            // Якщо likeA = 1 → показуємо "like"
            // Якщо likeA = 0 → показуємо "unlike"
            echo $likeA ? 'like' : 'unlike';
          ?>
        </td>

        <!-- Колонка з кнопками -->
        <td>

          <!-- Кнопка Edit -->
          <!-- Передаємо numMemb і numArt в URL -->
            <!-- a — це звичайне посилання
             href — це адреса сторінки, куди ми перейдемо після кліку
             ?numMemb=...&numArt=... - Це передача інформації через адресу сайту. 
             Ми бачимо результата в адресі сайту що відповідає нашим вальор-->

          <a 
            href="edit.php?numMemb=<?php echo $numMemb; ?>&numArt=<?php echo $numArt; ?>"
            class="btn btn-moyen btn-sm"
          > 
          <!-- Тут текст посилання — Edit -->
            Edit 
          
          </a>

          <!-- Кнопка Delete -->
          <!-- Так само передаємо numMemb і numArt -->
          <a
            href="delete.php?numMemb=<?php echo $numMemb; ?>&numArt=<?php echo $numArt; ?>"
            class="btn btn-fonce btn-sm"
          >
            Delete
          </a>

        </td>
      </tr>

    <?php
    // Кінець циклу foreach
    endforeach;
    ?>

    </tbody>
  </table>

  <!-- Кнопка для створення нового лайка -->
  <a href="create.php" class="btn btn-clair">Create</a>

</div>