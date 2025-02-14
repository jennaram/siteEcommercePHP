<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start(); // Démarre la session uniquement si aucune session n'est active
}
?>
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
    <!-- Message de notification -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success alert-dismissible fade show m-0" role="alert">
            <?php echo $_SESSION['message']; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        <?php unset($_SESSION['message']); ?>
    <?php endif; ?>

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

                <!-- Barre de recherche -->
                <form class="d-flex me-3" action="search.php" method="GET">
                    <div class="input-group">
                        <input class="form-control" type="search" name="query" placeholder="Rechercher" aria-label="Search" required>
                        <button class="btn btn-outline-secondary" type="submit">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>

                <!-- Icônes utilisateur et panier -->
                <div class="d-flex align-items-center">
                    <?php if (isset($_SESSION['id_users'])): ?>
                        <!-- Utilisateur connecté -->
                        <div class="dropdown me-3">
                            <a class="nav-link dropdown-toggle" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle fs-5"></i>
                                <span class="ms-1"><?php echo htmlspecialchars($_SESSION['prenom']); ?></span>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person me-2"></i>Mon profil</a></li>
                                <li><a class="dropdown-item" href="orders.php"><i class="bi bi-box me-2"></i>Mes commandes</a></li>
                                <?php if (isset($_SESSION['admin']) && $_SESSION['admin'] == 1): ?>
                                    <li><a class="dropdown-item" href="admin.php"><i class="bi bi-gear me-2"></i>Administration</a></li>
                                <?php endif; ?>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="logout.php"><i class="bi bi-box-arrow-right me-2"></i>Déconnexion</a></li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Utilisateur non connecté -->
                        <a class="nav-link me-3" href="user.php">
                            <i class="bi bi-person fs-5"></i>
                        </a>
                    <?php endif; ?>
                    <a class="nav-link me-3 position-relative" href="cart.php">
    <i class="bi bi-cart3 fs-5"></i>
    <?php if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])): ?>
        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
            <?= array_sum(array_column($_SESSION['panier'], 'quantite')) ?>
        </span>
    <?php endif; ?>
</a>
                </div>

                <!-- Bouton Connexion / Déconnexion -->
                <a class="btn btn-primary ms-2" href="<?php echo isset($_SESSION['id_users']) ? 'logout.php' : 'user.php'; ?>">
                    <?php echo isset($_SESSION['id_users']) ? 'Déconnexion' : 'Connexion'; ?>
                </a>
            </div>
        </div>

        <!-- Bouton de bascule dark/light -->
<div class="form-check form-switch ms-2">
    <input class="form-check-input" type="checkbox" role="switch" id="darkModeSwitch">
    <label class="form-check-label" for="darkModeSwitch">
        <i class="bi bi-moon-stars"></i>
    </label>
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
</body>
</html>
