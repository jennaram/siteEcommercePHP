<?php include 'header.php'; ?>
<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Requête SQL pour récupérer les produits en promotion
$sql = "SELECT p.id_produits, p.nom, p.prix, p.description, p.images, p.promos, m.nom_marque 
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        WHERE p.promos > 0
        LIMIT 4";
$stmt = $pdo->query($sql);
$promoProducts = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Promos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Styles de base */
        .promo-banner {
            background-color: #A6AED1;
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
                <h1 class="fw-bold" style="font-size: 1.8rem; white-space: nowrap;">Profitez des promos !</h1>
                <p class="lead" style="font-size: 1.1rem; white-space: nowrap;">Profitez de nos offres exclusives sur une large sélection de produits.</p>
                <a href="promo.php" class="btn btn-lg" style="background-color: #FDD835; border-color: #FDD835; color: black;">
                    Découvrir nos offres
                </a>
                </div>
                <div class="col-md-6 text-end">
                    <img src="images/promos.png" alt="Nos bons plans" class="img-fluid rounded" style="max-width: 38%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Paragraphe supplémentaire -->
    <div class="content-section-wrapper">
        <div class="container content-section">
            <h1>Des promotions jusqu'à -30% ! </h1>
            
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
                    <select name="type" class="form-select">
                        <option value="">Tous les types</option>
                        <option value="smartphone">Smartphones</option>
                        <option value="laptop">Ordinateurs portables</option>
                        <option value="tablet">Tablettes</option>
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

    <!-- Section des produits en promotion -->
<div class="content-section-wrapper mt-4">
    <div class="container">
        <div class="row">
            <?php foreach ($promoProducts as $product) : ?>
                <div class="col-md-3 mb-4">
                    <div class="card h-100 position-relative">
                        <!-- Badge promotion -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">
                                -<?= htmlspecialchars($product['promos']) ?>%
                            </span>
                        </div>
                        
                        <img src="images/<?= htmlspecialchars($product['images']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['nom']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text"><strong>Marque :</strong> <?= htmlspecialchars($product['nom_marque']) ?></p>
                            
                            <!-- Prix avec promotion -->
                            <div class="d-flex align-items-center gap-2">
                                <p class="card-text mb-0">
                                    <strong>Prix :</strong> 
                                    <span class="text-decoration-line-through text-muted">
                                        <?= number_format($product['prix'], 2, ',', ' ') ?> €
                                    </span>
                                    <span class="text-danger fw-bold">
                                        <?= number_format($product['prix'] * (1 - $product['promos']/100), 2, ',', ' ') ?> €
                                    </span>
                                </p>
                            </div>
                            
                            <a href="produit.php?id=<?= htmlspecialchars($product['id_produits']) ?>&promo=1" class="btn btn-primary mt-3">Voir le produit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
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