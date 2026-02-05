<?php
require_once 'config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Blog'Art</title>
    <!-- Bootstrap CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous" />
    <link rel="shortcut icon" type="image/x-icon" href="src/images/article1.png" />
    <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Della+Respira&display=swap" rel="stylesheet">
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo ROOT_URL . '/src/css/style.css' ?>" />
</head>
<body>
<nav class=" navbar-expand-lg navbar">
  <div class="container-fluid">
    <div>
      <img src="<?php echo ROOT_URL . '/src/images/canele-illu.png'?>" alt="Logo Les Délices Bordelais" height="50" class="d-inline-block align-text-top"/>
      <a class="navbar-brand navbar d-inline-block  align-text-top" href="#">Les Délices Bordelais</a>
    </div>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link btn btn-fonce" aria-current="page" href="/">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link btn btn-fonce" href="/views/backend/dashboard.php">Admin</a>
        </li>
      </ul>
    </div>
    <!--right align-->
    <div class="d-flex">
      <form class="d-flex" role="search"> <!--quand on cherche une mot sur barre de recherche, ça amène vers page search avec lien article-->
          <input class="" type="search" placeholder="Rechercher sur le site…" name ="recherche" aria-label="Search" value ="<?php echo isset($_GET['recherche']) ? $_GET['recherche'] : ''?>">
      </form>
      <a class="btn btn-fonce m-1" href="/views/backend/security/login.php" role="button">Login</a>
      <a class="btn btn-fonce m-1" href="/views/backend/security/signup.php" role="button">Sign up</a>
    </div>
  </div>
</nav>

<?php include_once __DIR__ . '/src/cookie_banner.php'; ?>
