<?php
//load config
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
<<<<<<< Updated upstream
<<<<<<< Updated upstream
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
      <form class="d-flex" role="search">
          <input class="" type="search" placeholder="Rechercher sur le site…" aria-label="Search" >
      </form>
      <a class="btn btn-fonce m-1" href="/views/frontend/search.php" role="button">Recherche avancée</a>
      <a class="btn btn-fonce m-1" href="/views/backend/security/login.php" role="button">Login</a>
      <a class="btn btn-fonce m-1" href="/views/backend/security/signup.php" role="button">Sign up</a>
    </div>
  </div>
</nav>

<?php include_once __DIR__ . '/src/cookie_banner.php'; ?>
=======
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Délices Bordelais - Blog</title>
    
    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts Import -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/src/css/style.css'; ?>">
</head>
<body>
    <!-- TOP BAR (Strate 1) -->
    <div class="top-bar">
        <div class="top-bar-inner">
            <span class="text">welcome to the blog made buy blogartstudio</span>
            <div class="icons">
                <a href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/index.php'; ?>" title="Accueil">🏠</a>
            </div>
        </div>
    </div>

    <!-- LOGO SECTION (Strate 2) -->
    <div class="logo-section">
        <div class="logo-left">
            <h1>Les Délices <span class="bordelais">Bordelais</span> <span class="cannele">🥐</span></h1>
        </div>
        <div class="logo-right">
            <a href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/views/backend/security/login.php'; ?>" class="btn-pill">ADMIN</a>
            <a href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/views/frontend/search.php'; ?>" class="btn-pill">RECHERCHE</a>
        </div>
    </div>

    <!-- STRIPED BAR (Strate 3) -->
    <div class="striped-bar"></div>
>>>>>>> Stashed changes
=======
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Les Délices Bordelais - Blog</title>
    
    <!-- Google Fonts Preconnect -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    
    <!-- Google Fonts Import -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600&display=swap" rel="stylesheet">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom CSS -->
    <link rel="stylesheet" href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/src/css/style.css'; ?>">
</head>
<body>
    <!-- TOP BAR (Strate 1) -->
    <div class="top-bar">
        <div class="top-bar-inner">
            <span class="text">welcome to the blog made buy blogartstudio</span>
            <div class="icons">
                <a href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/index.php'; ?>" title="Accueil">🏠</a>
            </div>
        </div>
    </div>

    <!-- LOGO SECTION (Strate 2) -->
    <div class="logo-section">
        <div class="logo-left">
            <h1>Les Délices <span class="bordelais">Bordelais</span> <span class="cannele">🥐</span></h1>
        </div>
        <div class="logo-right">
            <a href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/views/backend/security/login.php'; ?>" class="btn-pill">ADMIN</a>
            <a href="<?php echo (defined('ROOT_URL') ? ROOT_URL : '') . '/views/frontend/search.php'; ?>" class="btn-pill">RECHERCHE</a>
        </div>
    </div>

    <!-- STRIPED BAR (Strate 3) -->
    <div class="striped-bar"></div>
>>>>>>> Stashed changes
