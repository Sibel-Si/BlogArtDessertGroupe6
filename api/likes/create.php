<?php
// Це API-файл
// Він НЕ показує HTML
// Його єдина роль — працювати з БД

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

// 1) Забираємо дані з форми (POST)
$numMemb = (int)($_POST['numMemb'] ?? 0);
$numArt  = (int)($_POST['numArt'] ?? 0);

// 2) Перевіряємо, що дані коректні
if ($numMemb > 0 && $numArt > 0) {

    // 3) Перевіряємо: чи такий like вже існує
    // (щоб не створити дубль)
    $exists = sql_select(
        "likeart",
        "*",
        "numMemb = $numMemb AND numArt = $numArt"
    );

    // 4) Якщо такого запису ще НЕМА
    if (empty($exists)) {

        // 5) Створюємо новий like
        // likeA = 1 означає "liked"
        sql_insert(
            "likeart",
            "numMemb, numArt, likeA",
            "$numMemb, $numArt, 1"
        );
    }
}

// 6) Повертаємо користувача назад на список
header('Location: ../../views/backend/likes/list.php');
