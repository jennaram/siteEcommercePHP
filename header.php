<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechPulse</title>
    <!-- Lien vers le fichier CSS de Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Lien vers le fichier CSS des icônes Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <!-- Logo à gauche -->
        <a class="navbar-brand" href="index.php">
            <img src="images/techpulse-logo.png" alt="TechPulse Logo" width="300" height="150" class="d-inline-block align-top">
    
        </a>
        <!-- Bouton pour le menu responsive -->
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <!-- Liens de navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link" href="about.php">Qui sommes nous ?</a>
                </li>
               
                <li class="nav-item">
                    <a class="nav-link" href="help.php">Besoin d'aide ?</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contactez-nous</a>
                </li>
            </ul>
            <!-- Icône "Person" tout à droite -->
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                        <i class="bi bi-person"></i> <!-- Icône Bootstrap Person -->
                    </a>
                </li>
            </ul>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item">
                    <a class="nav-link" href="#">
                    <i class="bi bi-cart3"></i> <!-- Icône Bootstrap Panier-->
                    </a>       
            </ul>
             <!-- Bouton de bascule dark/light -->
             <li class="nav-item">
                    <div class="form-check form-switch">
                        <input class="form-check-input" type="checkbox" role="switch" id="flexSwitchCheckChecked">
                        <label class="form-check-label" for="flexSwitchCheckChecked">Mode sombre</label>
                    </div>
                </li>
        </div>
    </nav>
                <!-- Menu déroulant "Catégories" en dessous -->
            <ul class="navbar-nav flex-column w-100">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Catégories
                    </a>
                    <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                        <a class="dropdown-item" href="smartphones.php">Smartphones</a>
                        <a class="dropdown-item" href="ordinateurs.php">Ordinateurs portables</a>
                        <a class="dropdown-item" href="tablettes.php">Tablettes</a>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Scripts JavaScript de Bootstrap -->
    <script src="js/jquery-3.5.1.slim.min.js"></script>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>