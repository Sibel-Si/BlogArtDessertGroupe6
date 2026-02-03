<?php
// Це API файл
// Він не показує HTML
// Він отримує дані з форми і видаляє рядок з БД

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // конфіг і з’єднання з БД
require_once '../../functions/ctrlSaisies.php';         // функції захисту/перевірок

// 1) Забираємо numMemb з POST
$numMemb = (int)($_POST['numMemb'] ?? 0);

// 2) Забираємо numArt з POST
$numArt  = (int)($_POST['numArt'] ?? 0);

// 3) Видаляємо рядок із likeart
// Важливо: видаляємо саме по двох ключах
// Бо в likeart немає одного id
sql_delete(
    "likeart",
    "numMemb = $numMemb AND numArt = $numArt"
);

// 4) Повертаємося назад на список
header('Location: ../../views/backend/likes/list.php');
