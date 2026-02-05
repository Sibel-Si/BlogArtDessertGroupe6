<?php
require_once 'config.php';
require_once __DIR__ . '/config/security.php'; // Load security logic

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check for login alerts
$login_alert = $_SESSION['login_alert'] ?? '';
unset($_SESSION['login_alert']);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog'Art</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" />
    <link rel="shortcut icon" type="image/x-icon" href="src/images/article1.png" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Della+Respira&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo ROOT_URL . '/src/css/style.css' ?>" />
</head>
<body>
<nav class="navbar-expand-lg navbar">
  <div class="container-fluid">
    <div>
      <img src="<?php echo ROOT_URL . '/src/images/canele-illu.png'?>" alt="Logo" height="50" class="d-inline-block align-text-top"/>
      <a class="navbar-brand navbar d-inline-block align-text-top" href="/">Les Délices Bordelais</a>
    </div>
    
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link btn btn-fonce" href="/">Home</a></li>
        <?php if (IS_LOGGED_IN && in_array($_SESSION['numStat'], [1, 2])): ?>
            <li class="nav-item">
                <a class="nav-link btn btn-fonce" href="/views/backend/dashboard.php">Admin</a>
            </li>
        <?php endif; ?>
      </ul>
    </div>

    <div class="d-flex align-items-center">
      <form class="d-flex me-2" role="search">
          <input type="search" placeholder="Rechercher..." name="recherche" value="<?= isset($_GET['recherche']) ? htmlspecialchars($_GET['recherche']) : '' ?>">
      </form>

      <?php if (IS_LOGGED_IN): ?>
          <span class="me-2 text-dark"><strong><?= htmlspecialchars($_SESSION['pseudoMemb']) ?></strong></span>
          <a class="btn btn-fonce m-1" href="/api/security/disconnect.php" role="button">Logout</a>
      <?php else: ?>
          <a class="btn btn-fonce m-1" href="/views/backend/security/login.php" role="button">Login</a>
          <a class="btn btn-fonce m-1" href="/views/backend/security/signup.php" role="button">Sign up</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<?php if ($login_alert): ?>
    <div class="container mt-2">
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <?= htmlspecialchars($login_alert) ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    </div>
<?php endif; ?>

<?php include_once __DIR__ . '/src/cookie_banner.php'; ?>