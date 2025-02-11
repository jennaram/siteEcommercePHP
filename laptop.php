<?php include 'header.php'; ?>

<?php
// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Établir la connexion à la base de données
$db = getDBConnection();

// Exemple de requête pour obtenir des produits
$query = "SELECT * FROM produits";
$stmt = $db->prepare($query);
$stmt->execute();

// Récupérer tous les produits
$produits = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Afficher les produits
foreach ($produits as $produit) {
    echo $produit['nom'] . " - " . $produit['prix'] . "<br>";
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Styles de base */
        .promo-banner {
            background-color: #BEA6D1;
            color: black;
            transition: background-color 0.3s, color 0.3s;
        }

        .promo-button {
            background-color: #FDD835;
            border-color: #FDD835;
            color: black;
            transition: background-color 0.3s, color 0.3s;
        }

        .content-section-wrapper {
            transition: background-color 0.3s, color 0.3s;
            padding: 3rem 0;  /* Ajoute de l'espace vertical */
        }

        footer {
            transition: background-color 0.3s, color 0.3s;
        }

        /* Styles pour le mode sombre */
        [data-bs-theme="dark"] {
            background-color: #212529;
            color: white;
        }

        [data-bs-theme="dark"] .navbar {
            background-color: #343a40 !important;
        }

        [data-bs-theme="dark"] .nav-link {
            color: white !important;
        }

        [data-bs-theme="dark"] .form-control {
            background-color: #495057;
            color: white;
            border-color: #6c757d;
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: #bbb;
        }

        [data-bs-theme="dark"] .btn-outline-secondary {
            border-color: white;
            color: white;
        }

        [data-bs-theme="dark"] .btn-outline-secondary:hover {
            background-color: white;
            color: black;
        }

        /* Styles spécifiques pour le bandeau promo en mode sombre */
        [data-bs-theme="dark"] .promo-banner {
            background-color: #3d322f;
            color: white;
        }

        [data-bs-theme="dark"] .promo-button {
            background-color: #b39b00;
            border-color: #b39b00;
            color: white;
        }

        /* Styles pour le contenu principal en mode sombre */
        [data-bs-theme="dark"] .content-section-wrapper {
            background-color: #343a40;
            color: white;
        }

        [data-bs-theme="dark"] .content-section h1,
        [data-bs-theme="dark"] .content-section p {
            color: white;
        }

        /* Styles pour le footer en mode sombre */
        [data-bs-theme="dark"] footer {
            background-color: #343a40;
            color: white;
        }

        [data-bs-theme="dark"] footer a {
            color: #fff;
        }

        [data-bs-theme="dark"] footer a:hover {
            color: #FDD835;
        }
    </style>
</head>
<body>
    <!-- Bandeau promotionnel -->
    <div class="promo-banner py-4">
        <div class="container">
            <div class="row align-items-center">
            <div class="col-md-6 text-start">
                <h1 class="fw-bold" style="font-size: 1.8rem; white-space: nowrap;">Découvrez nos PC & Macbook</h1>
                <p class="lead" style="font-size: 1.1rem; white-space: nowrap;">Profitez de nos offres exclusives sur une large sélection de produits.</p>
                <a href="promo.php" class="btn btn-lg" style="background-color: #FDD835; border-color: #FDD835; color: black;">
                    Découvrir nos offres
                </a>
                </div>
                <div class="col-md-6 text-end">
                    <img src="images/pc portables.png" alt="PC portables" class="img-fluid rounded" style="max-width: 40%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Paragraphe supplémentaire -->
    <div class="content-section-wrapper">
        <div class="container content-section">
            <h1>Nos PC & Macbook</h1>
            
             <!-- Filtres de recherche -->
    <div class="container mt-4">
        <form method="GET" action="index.php">
            <div class="row">
                <div class="col-md-3">
                    <select name="brand" class="form-select">
                        <option value="">Toutes les marques</option>
                        <option value="Apple">Apple</option>
                        <option value="Samsung">Samsung</option>
                        <option value="Dell">Dell</option>
                        <!-- Ajoutez d'autres marques ici -->
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="price_asc">Prix croissant</option>
                        <option value="price_desc">Prix décroissant</option>
                        <option value="best_sellers">Meilleures ventes</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>
        </div>
    </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const darkModeSwitch = document.getElementById('darkModeSwitch');
            const navbar = document.getElementById('navbar');

            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                navbar.classList.replace('navbar-light', 'navbar-dark');
                navbar.classList.replace('bg-light', 'bg-dark');
                darkModeSwitch.checked = true;
            }

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
<?php include 'footer.php'; ?>