<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechPulse</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons - Assurez-vous d'avoir cette ligne -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
<nav class="navbar navbar-expand-lg">
    <div class="container">
        <!-- Tout le contenu de la navbar -->
        <a class="navbar-brand" href="index.php">
            <img src="images/techpulse-logo.png" alt="TechPulse Logo" width="300" height="150" class="d-inline-block align-top">
        </a>

        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarNav">
            <!-- Liens de navigation (à gauche) -->
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
             <!-- Barre de recherche -->
             <form class="d-flex me-3" action="search.php" method="GET">
    <div class="input-group">
        <input class="form-control" type="search" name="query" placeholder="Rechercher" aria-label="Search" required>
        <button class="btn btn-outline-secondary" type="submit">
            <i class="bi bi-search"></i>
        </button>
    </div>
</form>

            <!-- Conteneur des éléments de droite -->
            <div class="d-flex align-items-center">
                <!-- Icône Person -->
                <a class="nav-link me-3" href="user.php">
                    <i class="bi bi-person fs-5"></i>
                </a>
                
                <!-- Icône Panier -->
                <a class="nav-link me-3" href="cart.php">
                    <i class="bi bi-cart3 fs-5"></i>
                </a>

                <!-- Bouton de bascule dark/light -->
                <div class="form-check form-switch ms-2">
                    <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
                    <label class="form-check-label" for="darkModeSwitch">
                        <i class="bi bi-moon-stars"></i>
                    </label>
                </div>
            </div>
        </div>
    </nav>

    

    <!-- Scripts Bootstrap à la fin du body -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Script pour le mode sombre -->
    <script>
        const darkModeSwitch = document.getElementById('darkModeSwitch');
        
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            darkModeSwitch.checked = true;
        }

        darkModeSwitch.addEventListener('change', () => {
            if (darkModeSwitch.checked) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('darkMode', 'false');
            }
        });
    </script>
</body>
</html>