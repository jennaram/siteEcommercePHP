<?php include 'header.php'; ?>
<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Récupérer les filtres depuis l'URL
$brand = $_GET['brand'] ?? '';
$type = $_GET['type'] ?? '';
$sort = $_GET['sort'] ?? '';

// Requête SQL de base pour récupérer les produits en promotion
$sql = "SELECT p.id_produits, p.nom, p.prix, p.description, p.images, p.promos, m.nom_marque 
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        WHERE p.promos > 0";

// Ajouter les filtres à la requête SQL
if (!empty($brand)) {
    $sql .= " AND m.nom_marque = :brand";
}
if (!empty($type)) {
    $sql .= " AND p.id_type_produits = (SELECT id_type_produits FROM type_produits WHERE nom = :type)";
}

// Ajouter le tri à la requête SQL
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

// Préparer et exécuter la requête SQL
$stmt = $pdo->prepare($sql);

if (!empty($brand)) {
    $stmt->bindValue(':brand', $brand);
}
if (!empty($type)) {
    $stmt->bindValue(':type', $type);
}

$stmt->execute();
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
    <link rel="stylesheet" href="style.css">
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
    <form method="GET" action="promo.php">
        <div class="row gx-2 gy-2"> <!-- Ajout de gx-2 et gy-2 pour l'espacement -->
            <!-- Filtre par marque -->
            <div class="col-md-2"> <!-- Réduire la largeur des colonnes -->
                <select name="brand" class="form-select">
                    <option value="">Toutes les marques</option>
                    <option value="Apple" <?= $brand === 'Apple' ? 'selected' : '' ?>>Apple</option>
                    <option value="Samsung" <?= $brand === 'Samsung' ? 'selected' : '' ?>>Samsung</option>
                    <option value="Dell" <?= $brand === 'Dell' ? 'selected' : '' ?>>Dell</option>
                    <option value="Xiaomi" <?= $brand === 'Xiaomi' ? 'selected' : '' ?>>Xiaomi</option>
                    <option value="Asus" <?= $brand === 'Asus' ? 'selected' : '' ?>>Asus</option>
                    <option value="HP" <?= $brand === 'HP' ? 'selected' : '' ?>>HP</option>
                    <option value="Lenovo" <?= $brand === 'Lenovo' ? 'selected' : '' ?>>Lenovo</option>
                    <option value="Microsoft" <?= $brand === 'Microsoft' ? 'selected' : '' ?>>Microsoft</option>
                    <option value="Huawei" <?= $brand === 'Huawei' ? 'selected' : '' ?>>Huawei</option>
                    <option value="Sony" <?= $brand === 'Sony' ? 'selected' : '' ?>>Sony</option>
                </select>
            </div>

            <!-- Filtre par ordre de tri -->
            <div class="col-md-2"> <!-- Réduire la largeur des colonnes -->
                <select name="sort" class="form-select">
                    <option value="price_asc" <?= $sort === 'price_asc' ? 'selected' : '' ?>>Prix croissant</option>
                    <option value="price_desc" <?= $sort === 'price_desc' ? 'selected' : '' ?>>Prix décroissant</option>
                    <option value="best_sellers" <?= $sort === 'best_sellers' ? 'selected' : '' ?>>Meilleures ventes</option>
                </select>
            </div>

            <!-- Filtre par type de produit -->
            <div class="col-md-2"> <!-- Réduire la largeur des colonnes -->
                <select name="type" class="form-select">
                    <option value="">Tous les types</option>
                    <option value="Smartphone" <?= $type === 'Smartphone' ? 'selected' : '' ?>>Smartphones</option>
                    <option value="Ordinateur" <?= $type === 'Ordinateur' ? 'selected' : '' ?>>Ordinateurs</option>
                    <option value="Tablette" <?= $type === 'Tablette' ? 'selected' : '' ?>>Tablettes</option>
                </select>
            </div>

            <!-- Bouton Filtrer -->
            <div class="col-md-2"> <!-- Réduire la largeur des colonnes -->
                <button type="submit" class="btn btn-primary w-100">Filtrer</button>
            </div>

            <!-- Bouton Réinitialiser -->
            <div class="col-md-2"> <!-- Réduire la largeur des colonnes -->
                <button type="button" id="resetFilters" class="btn btn-secondary w-100">Réinitialiser</button>
            </div>
        </div>
    </form>
</div>
      

    <!-- Section des produits en promotion -->
    <div class="content-section-wrapper mt-4">
        <div class="container">
            <div class="row">
            <?php if (!empty($promoProducts)) : ?>
                <?php foreach ($promoProducts as $product) : ?>
                    <div class="col-md-3 mb-4">
                        <div class="card h-100 position-relative">
                            <!-- Badge promotion -->
                            <div class="position-absolute top-0 start-0 m-2">
                                <span class="badge bg-danger">
                                    -<?= htmlspecialchars($product['promos']) ?>%
                                </span>
                            </div>
                            
                            <img src="images/<?= htmlspecialchars($product['images']) ?>" 
     alt="<?= htmlspecialchars($product['nom']) ?>" 
     class="img-fluid product-image" 
     style="max-width: 300px; height: auto;">
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
                                <a href="ajouter_panier.php?id=<?= htmlspecialchars($product['id_produits']) ?>" class="btn btn-success ms-2">Ajouter au panier</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p class="text-center"><?= $noProductsMessage ?? 'Aucune produit trouvé.' ?></p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>

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
    <script>
    document.getElementById('resetFilters').addEventListener('click', function () {
        window.location.href = window.location.pathname;
    });
</script>
</body>
</html>
<?php include 'footer.php'; ?>