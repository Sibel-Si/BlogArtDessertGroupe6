<?php
// root/config/security.php

if (session_status() === PHP_SESSION_NONE) session_start();

if (!defined('IS_LOGGED_IN')) {
    define('IS_LOGGED_IN', isset($_SESSION['id_user']));
}

/**
 * RENAMED to avoid conflict with functions/security.php
 */
function check_page_access($allowed_levels = []) {
    if (!IS_LOGGED_IN) {
        $_SESSION['login_alert'] = "Veuillez vous connecter pour voir cette page.";
        header('Location: /views/backend/security/login.php');
        exit;
    }

    if (!empty($allowed_levels)) {
        if (!isset($_SESSION['numStat']) || !in_array($_SESSION['numStat'], $allowed_levels)) {
            header('Location: /?error=unauthorized');
            exit;
        }
    }
}

// Keep check_api_access as is, or rename to check_api_auth if needed
function check_api_access($allowed_levels = []) {
    if (!IS_LOGGED_IN || (!empty($allowed_levels) && !in_array($_SESSION['numStat'], $allowed_levels))) {
        header('HTTP/1.1 403 Forbidden');
        echo json_encode(['error' => 'Access Denied']);
        exit;
    }
}