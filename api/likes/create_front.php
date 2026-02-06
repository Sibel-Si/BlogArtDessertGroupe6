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
    // 1. Fetch the record
    $result = sql_select("likeart", "likeA", "numMemb = $numMemb AND numArt = $numArt");

    // 2. Extract the actual value from the array
    // Most sql_select functions return: ['likeA' => 1] or [['likeA' => 1]]
    $currentStatus = null;
    if (!empty($result)) {
        // If it's a nested array (multi-row), use $result[0]['likeA']
        // If it's a single row array, use $result['likeA']
        $currentStatus = isset($result[0]['likeA']) ? $result[0]['likeA'] : ($result['likeA'] ?? null);
    }

    if ($currentStatus === null) {
        // Doesn't exist: Insert
        sql_insert("likeart", "numMemb, numArt, likeA", "$numMemb, $numArt, 1");
    } else {
        // Toggle: If it was 1, set to 0. Otherwise, set to 1.
        $newStatus = ($currentStatus == 1) ? 0 : 1;
        
        sql_update(
            "likeart",
            "likeA = $newStatus",
            "numMemb = $numMemb AND numArt = $numArt"
        );
    }
}


// Redirect back to the article page instead of the list
header("Location: " . $_SERVER['HTTP_REFERER'] ?: "/views/frontend/articles/article.php?numArt=$numArt");
exit;