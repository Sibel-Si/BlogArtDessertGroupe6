<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once '../../functions/ctrlSaisies.php';

$numMemb = (int)($_POST['numMemb'] ?? 0);
$numArt  = (int)($_POST['numArt'] ?? 0);

// Мінімальна перевірка
if ($numMemb > 0 && $numArt > 0) {

    // Перевірка: чи вже існує така пара (щоб не було дубля)
    $exists = sql_select("likeart", "*", "numMemb = $numMemb AND numArt = $numArt");

    if (empty($exists)) {
        // За замовчуванням ставимо likeA = 1 (liked)
        sql_insert("likeart", "numMemb, numArt, likeA", "$numMemb, $numArt, 1");
    }
}

header('Location: ../../views/backend/likes/list.php');
