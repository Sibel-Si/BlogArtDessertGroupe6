<?php 
require_once 'header.php';
//sql_connect();

?>
    <meta charset="UTF-8">
    <title>Les Délices Bordelais</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Google Font proche de ta maquette -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">

  
    </head>

    <body>

        <!-- HEADER -->
        <header class="py-3 mb-4">
            <div class="container d-flex justify-content-between align-items-center">
                <h1 class="h3 m-0">Les Délices Bordelais</h1>

                <nav>
                    <a href="login.php" class="btn btn-outline-dark me-2">Login</a>
                    <a href="signup.php" class="btn btn-caramel">Sign Up</a>
                </nav>
            </div>
        </header>

        <div class="container">

            <!-- CARD PRINCIPALE -->
            <div class="card mb-5">
                <div class="row g-0">
                    <div class="col-md-4">
                        <img src="https://picsum.photos/400/300" class="img-fluid" alt="Image du blog">
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <h2 class="card-title">Les Délices Bordelais</h2>
                            <p class="card-text">Le blog gourmand autour des spécialités bordelaises.</p>
                            <a href="#" class="btn btn-caramel">Découvrir</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CATÉGORIES -->
            <h3 class="mb-3">Catégories</h3>
            <div class="row mb-5">

                <div class="col-md-4">
                    <div class="card category-card text-center p-4">
                        <h4 class="card-title">Canelé</h4>
                        <a href="#" class="btn btn-caramel mt-2">Voir</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card category-card text-center p-4">
                        <h4 class="card-title">Croissant</h4>
                        <a href="#" class="btn btn-caramel mt-2">Voir</a>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card category-card text-center p-4">
                        <h4 class="card-title">Baguette</h4>
                        <a href="#" class="btn btn-caramel mt-2">Voir</a>
                    </div>
                </div>

            </div>

            <!-- ARTICLES RÉCENTS -->
            <h3 class="mb-3">Articles récents</h3>
            <div class="row mb-5">

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://picsum.photos/400/250?1" class="card-img-top" alt="Article 1">
                        <div class="card-body">
                            <h5 class="card-title">Titre article 1</h5>
                            <p class="card-text">Petit résumé de l’article...</p>
                            <a href="#" class="btn btn-caramel">Lire</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://picsum.photos/400/250?2" class="card-img-top" alt="Article 2">
                        <div class="card-body">
                            <h5 class="card-title">Titre article 2</h5>
                            <p class="card-text">Petit résumé de l’article...</p>
                            <a href="#" class="btn btn-caramel">Lire</a>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4">
                    <div class="card">
                        <img src="https://picsum.photos/400/250?3" class="card-img-top" alt="Article 3">
                        <div class="card-body">
                            <h5 class="card-title">Titre article 3</h5>
                            <p class="card-text">Petit résumé de l’article...</p>
                            <a href="#" class="btn btn-caramel">Lire</a>
                        </div>
                    </div>
                </div>

            </div>

        </div>

        <!-- FOOTER -->
        <footer class="text-center py-4 mt-5">
            <p class="m-0">Blog'Art 26</p>
            <p class="m-0">Crédits site — Plan du site — CGU — RGPD — Mentions légales</p>
        </footer>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    </body>

</html>

<?php require_once 'footer.php'; ?>