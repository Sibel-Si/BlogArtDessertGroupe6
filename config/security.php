<?php
// root/config/security.php

if (session_status() === PHP_SESSION_NONE) session_start();

if (!defined('IS_LOGGED_IN')) {
    define('IS_LOGGED_IN', isset($_SESSION['id_user']));
}

/**
 * Universal redirect helper that works even after HTML/Header is sent
 */
function safe_redirect($url) {
    if (!headers_sent()) {
        // Option 1: Standard PHP redirect (Best)
        header('Location: ' . $url);
    } else {
        // Option 2: JavaScript + Meta fallback (If HTML already started)
        echo '<script type="text/javascript">window.location.href="' . $url . '";</script>';
        echo '<noscript><meta http-equiv="refresh" content="0;url=' . $url . '" /></noscript>';
    }
    exit;
}

function check_page_access($allowed_levels = []) {
    if (!IS_LOGGED_IN) {
        $_SESSION['login_alert'] = "Veuillez vous connecter pour voir cette page.";
        safe_redirect('/views/backend/security/login.php');
    }

    if (!empty($allowed_levels)) {
        if (!isset($_SESSION['numStat']) || !in_array($_SESSION['numStat'], $allowed_levels)) {
            safe_redirect('/?error=unauthorized');
        }
    }
}

function check_api_access($allowed_levels = []) {
    if (!IS_LOGGED_IN || (!empty($allowed_levels) && !in_array($_SESSION['numStat'], $allowed_levels))) {
        // Note: APIs usually don't send HTML headers early, 
        // but we'll keep it clean.
        if (!headers_sent()) {
            header('HTTP/1.1 403 Forbidden');
        }
        echo json_encode(['error' => 'Access Denied']);
        exit;
    }
}


/**
 * Checks if a user is logged in.
 * If not, redirects to index using JS (since headers are already sent).
 */
function check_login_and_redirect() {
    // 1. Check if the constant or session exists
    if (!defined('IS_LOGGED_IN') || !IS_LOGGED_IN) {
        
        // 2. We use JavaScript because HTML/Header text is already in the browser buffer
        echo '<script type="text/javascript">
                window.location.href = "/index.php";
              </script>';
        
        // 3. Meta refresh fallback (for users with JS disabled)
        echo '<noscript>
                <meta http-equiv="refresh" content="0;url=/index.php">
              </noscript>';
        
        // 4. Stop the rest of the script from executing
        exit;
    }
}