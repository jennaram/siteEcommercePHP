<?php session_start();?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechPulse</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar">
        <div class="container">
            <!-- Logo -->
            <a class="navbar-brand" href="index.php">
                <img src="images/techpulse-logo.png" alt="TechPulse Logo" width="300" height="150" class="d-inline-block align-top">
            </a>

            <!-- Bouton de menu pour mobile -->
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <!-- Contenu de la navbar -->
            <div class="collapse navbar-collapse" id="navbarNav">
                <!-- Liens de navigation -->
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link fw-bold text-danger" href="promo.php">Promos</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="smartphones.php">Smartphones</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="laptop.php">Ordinateurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link fw-bold" href="tablettes.php">Tablettes</a>
                    </li>
                </ul>

                <div class="search-container me-3">
    <form class="search-form" action="search.php" method="GET">
        <input type="text" class="search-input" name="q" placeholder="Rechercher...">
        <button type="button" class="search-toggle btn btn-link">
            <i class="bi bi-search fs-5"></i>
        </button>
    </form>
</div>


                

               <!-- Icônes utilisateur et panier -->
<div class="d-flex align-items-center">
    <a class="nav-link me-1" href="user.php">
        <i class="bi bi-person fs-5"></i>
    </a>
    <a class="nav-link me-1 position-relative" href="cart.php">
    <i class="bi bi-cart3 fs-5"></i>
    <?php if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= array_sum(array_column($_SESSION['panier'], 'quantite')) ?>
        </span>
    <?php endif; ?>
</a>
    <a class="nav-link me-1" href="logout.php">
        <i class="bi bi-box-arrow-right fs-5"></i>
    </a>
    <?php if (isset($_SESSION['user_id'])): ?> 
        <a class="nav-link me-2 text-danger" href="logout.php">
            <i class="bi bi-box-arrow-right fs-5"></i>
        </a>
    <?php endif; ?>
</div>

                    <!-- Bouton de bascule dark/light -->
                    <div class="form-check form-switch ms-2">
                        <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                        <label class="form-check-label" for="darkModeSwitch">
                            <i class="bi bi-moon-stars"></i>
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Script pour le mode sombre -->
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const darkModeSwitch = document.getElementById('darkModeSwitch');
            const navbar = document.getElementById('navbar');

            // Appliquer le bon thème au chargement
            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                navbar.classList.replace('navbar-light', 'navbar-dark');
                navbar.classList.replace('bg-light', 'bg-dark');
                darkModeSwitch.checked = true;
            }

            // Gestion du changement de mode
            darkModeSwitch.addEventListener('change', function () {
                if (this.checked) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                    navbar.classList.replace('navbar-light', 'navbar-dark');
                    navbar.classList.replace('bg-light', 'bg-dark');
                    localStorage.setItem('darkMode', 'true');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                    navbar.classList.replace('navbar-dark', 'navbar-light');
                    navbar.classList.replace('bg-dark', 'bg-light');
                    localStorage.setItem('darkMode', 'false');
                }
            });
        });
    </script>
    <script>
document.addEventListener('DOMContentLoaded', function() {
    const searchToggle = document.querySelector('.search-toggle');
    const searchInput = document.querySelector('.search-input');

    searchToggle.addEventListener('click', function() {
        searchInput.classList.toggle('active');
        if (searchInput.classList.contains('active')) {
            searchInput.focus();
        }
    });

    // Fermer la recherche si on clique en dehors
    document.addEventListener('click', function(event) {
        if (!event.target.closest('.search-container')) {
            searchInput.classList.remove('active');
        }
    });
});
</script>
</body>
</html>