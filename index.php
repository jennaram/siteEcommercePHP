<?php include 'header.php'; ?>

<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Récupérer les paramètres de filtrage
$brand = $_GET['brand'] ?? ''; // Marque sélectionnée
$sort = $_GET['sort'] ?? '';   // Ordre de tri sélectionné
$type = $_GET['type'] ?? '';   // Type de produit sélectionné

// Construire la requête SQL de base
$sql = "SELECT p.id_produits, p.nom, p.prix, p.description, p.images, m.nom_marque, t.nom AS type_produit
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        JOIN type_produits t ON p.id_type_produits = t.id_type_produits
        WHERE 1=1"; // Condition toujours vraie pour faciliter l'ajout de filtres

// Ajouter les filtres à la requête
if (!empty($brand)) {
    $sql .= " AND m.nom_marque = :brand";
}
if (!empty($type)) {
    $sql .= " AND t.nom = :type";
}

// Ajouter l'ordre de tri
switch ($sort) {
    case 'price_asc':
        $sql .= " ORDER BY p.prix ASC";
        break;
    case 'price_desc':
        $sql .= " ORDER BY p.prix DESC";
        break;
    case 'best_sellers':
        $sql .= " ORDER BY p.nombre_ventes DESC";
        break;
    default:
        $sql .= " ORDER BY p.nom ASC"; // Tri par défaut
}

// Préparer et exécuter la requête
$stmt = $pdo->prepare($sql);

// Binder les paramètres de filtrage
if (!empty($brand)) {
    $stmt->bindValue(':brand', $brand, PDO::PARAM_STR);
}
if (!empty($type)) {
    $stmt->bindValue(':type', $type, PDO::PARAM_STR);
}

$stmt->execute();
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Requête SQL pour récupérer les 3 meilleures ventes
$sql = "SELECT p.id_produits, p.nom, p.prix, p.description, p.images, m.nom_marque 
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        ORDER BY p.nombre_ventes DESC
        LIMIT 3";
$stmt = $pdo->query($sql);
$bestSellers = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            background-color: #D1B0A6;
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
                <h1 class="fw-bold" style="font-size: 1.8rem; white-space: nowrap;">Découvrez nos bons plans</h1>
                <p class="lead" style="font-size: 1.1rem; white-space: nowrap;">Profitez de nos offres exclusives sur une large sélection de produits.</p>
                <a href="promo.php" class="btn btn-lg" style="background-color: #FDD835; border-color: #FDD835; color: black;">
                    Découvrir nos offres
                </a>
                </div>
                <div class="col-md-6 text-end">
                    <img src="images/matos.png" alt="Nos bons plans" class="img-fluid rounded" style="max-width: 80%; height: auto;">
                </div>
            </div>
        </div>
    </div>
     <!-- Section des meilleures ventes -->
<div class="content-section-wrapper">
    <div class="container content-section">
        <h1>Nos meilleures ventes</h1>
        <div class="row">
            <?php foreach ($bestSellers as $product) : ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 position-relative">
                        <!-- Badge Top ventes -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="badge bg-danger">
                                <i class="bi bi-award"></i> Top ventes
                            </span>
                        </div>
                        <img src="images/<?= htmlspecialchars($product['images']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['nom']) ?>">
                        <div class="card-body">
                            <h5 class="card-title"><?= htmlspecialchars($product['nom']) ?></h5>
                            <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                            <p class="card-text"><strong>Marque :</strong> <?= htmlspecialchars($product['nom_marque']) ?></p>
                            <p class="card-text"><strong>Prix :</strong> <?= number_format($product['prix'], 2, ',', ' ') ?> €</p>
                            <a href="produit.php?id=<?= htmlspecialchars($product['id_produits']) ?>" class="btn btn-primary">Voir le produit</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>

    <!-- Filtres de recherche -->
    <div class="container mt-4">
        <form method="GET" action="index.php">
            <div class="row">
                <div class="col-md-3">
                    <select name="brand" class="form-select">
                        <option value="">Toutes les marques</option>
                        <option value="Apple" <?= $brand === 'Apple' ? 'selected' : '' ?>>Apple</option>
                        <option value="Samsung" <?= $brand === 'Samsung' ? 'selected' : '' ?>>Samsung</option>
                        <option value="Dell" <?= $brand === 'Dell' ? 'selected' : '' ?>>Dell</option>
                        <!-- Ajoutez d'autres marques ici -->
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Prix croissant</option>
                        <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Prix décroissant</option>
                        <option value="best_sellers" <?= $sort === 'best_sellers' ? 'selected' : '' ?>>Meilleures ventes</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="type" class="form-select">
                        <option value="">Tous les types</option>
                        <option value="Smartphone" <?= $type === 'Smartphone' ? 'selected' : '' ?>>Smartphones</option>
                        <option value="Ordinateur Portable" <?= $type === 'Ordinateur Portable' ? 'selected' : '' ?>>Ordinateurs portables</option>
                        <option value="Tablette" <?= $type === 'Tablette' ? 'selected' : '' ?>>Tablettes</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <button type="submit" class="btn btn-primary w-100">Filtrer</button>
                </div>
            </div>
        </form>
    </div>

  <!-- Section des produits filtrés -->
  <div class="content-section-wrapper">
        <div class="container content-section">
            <h1>Résultats de la recherche</h1>
            <div class="row">
                <?php if (count($products) > 0) : ?>
                    <?php foreach ($products as $product) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="images/<?= htmlspecialchars($product['images']) ?>" class="card-img-top" alt="<?= htmlspecialchars($product['nom']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($product['nom']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($product['description']) ?></p>
                                    <p class="card-text"><strong>Marque :</strong> <?= htmlspecialchars($product['nom_marque']) ?></p>
                                    <p class="card-text"><strong>Type :</strong> <?= htmlspecialchars($product['type_produit']) ?></p>
                                    <p class="card-text"><strong>Prix :</strong> <?= number_format($product['prix'], 2, ',', ' ') ?> €</p>
                                    <a href="produit.php?id=<?= htmlspecialchars($product['id_produits']) ?>" class="btn btn-primary">Voir le produit</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p class="text-center">Aucun produit trouvé.</p>
                    </div>
                <?php endif; ?>
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
