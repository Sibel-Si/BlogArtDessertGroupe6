<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/config.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/global.inc.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/functions/ctrlSaisies.php';

// Protect the API: only logged-in users
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: /');
    exit;
}

$numMemb = (int)($_POST['numMemb'] ?? 0);
$numArt  = (int)($_POST['numArt'] ?? 0);

if ($numMemb > 0 && $numArt > 0) {
    // Check if like already exists
    $exists = sql_select("likeart", "*", "numMemb = $numMemb AND numArt = $numArt");

    if (empty($exists)) {
        sql_insert("likeart", "numMemb, numArt, likeA", "$numMemb, $numArt, 1");
    } else {
        // Optional: Toggle like (delete if exists)
        sql_delete("likeart", "numMemb = $numMemb AND numArt = $numArt");
    }
}

// Redirect back to the article page instead of the list
header("Location: " . $_SERVER['HTTP_REFERER'] ?: "/views/frontend/articles/article.php?numArt=$numArt");
exit;