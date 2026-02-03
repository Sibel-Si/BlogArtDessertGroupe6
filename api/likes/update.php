<?php
// Це API файл: він працює тільки з базою даних
// Він отримує дані з форми (POST) і робить UPDATE

require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php'; // Підключає конфіг (доступ до БД, константи)
require_once '../../functions/ctrlSaisies.php';         // Функції для безпеки/перевірок (у вашому шаблоні)

// 1) Забираємо numMemb з POST
// Якщо поля немає — ставимо 0
$numMemb = (int)($_POST['numMemb'] ?? 0);

// 2) Забираємо numArt з POST
$numArt  = (int)($_POST['numArt'] ?? 0);

// 3) Забираємо likeA з POST (0 або 1)
$likeA   = (int)($_POST['likeA'] ?? 0);

// 4) Захист: likeA має бути тільки 0 або 1
if ($likeA !== 0 && $likeA !== 1) {
    $likeA = 0;
}

// 5) Робимо UPDATE в таблиці likeart
// Встановлюємо likeA
// Для конкретного рядка, який визначається парою numMemb + numArt
sql_update(
    "likeart",
    "likeA = $likeA",
    "numMemb = $numMemb AND numArt = $numArt"
);

// 6) Повертаємось на list.php
header('Location: ../../views/backend/likes/list.php');

