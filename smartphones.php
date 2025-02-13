<?php include 'header.php'; ?>
<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Récupérer les filtres depuis l'URL
$brand = $_GET['brand'] ?? '';
$sort = $_GET['sort'] ?? '';

// Requête SQL de base pour récupérer les smartphones
$sql = "SELECT p.id_produits, p.nom, p.prix, p.description, p.images, m.nom_marque 
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        WHERE p.id_type_produits = 2"; // 2 est l'ID pour "Smartphone"

// Ajouter les filtres à la requête SQL
if (!empty($brand)) {
    $sql .= " AND m.nom_marque = :brand";
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
        // Pas de tri par défaut, on pourrait trier par nom: $sql .= " ORDER BY p.nom ASC";
        break;
}

// Préparer et exécuter la requête SQL
$stmt = $pdo->prepare($sql);

if (!empty($brand)) {
    $stmt->bindValue(':brand', $brand);
}

$stmt->execute();
$smartphones = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Si aucun produit n'est trouvé, afficher un message
if (empty($smartphones)) {
    $noProductsMessage = "Aucun smartphone trouvé pour cette sélection.";
}
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smartphones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body class="page-smartphones">
    <!-- Bandeau promotionnel -->
    <div class="promo-banner py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-start">
                    <h1 class="fw-bold" style="font-size: 1.8rem; white-space: nowrap;">Nos derniers smartphones !</h1>
                    <p class="lead" style="font-size: 1.1rem; white-space: nowrap;">Profitez de nos offres exclusives sur une large sélection de produits.</p>
                    <a href="promo.php" class="btn btn-lg" style="background-color: #FDD835; border-color: #FDD835; color: black;">
                        Découvrir nos offres
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <img src="images/iPhone15-Pro-Max-All-Colors .png" alt="smartphones" class="img-fluid rounded" style="max-width: 40%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Paragraphe supplémentaire -->
    <div class="content-section-wrapper">
        <div class="container content-section">
            <h1>Nos smartphones</h1>
            
            <!-- Filtres de recherche -->
            <div class="container mt-4">
                <form method="GET" action="smartphones.php">
                    <div class="row">
                        <div class="col-md-3">
                            <select name="brand" class="form-select">
                                <option value="">Toutes les marques</option>
                                <option value="Apple" <?= $brand === 'Apple' ? 'selected' : '' ?>>Apple</option>
                                <option value="Samsung" <?= $brand === 'Samsung' ? 'selected' : '' ?>>Samsung</option>
                                <option value="Xiaomi" <?= $brand === 'Xiaomi' ? 'selected' : '' ?>>Xiaomi</option>
                                <option value="Asus" <?= $brand === 'Asus' ? 'selected' : '' ?>>Asus</option>
                                <option value="Huawei" <?= $brand === 'Huawei' ? 'selected' : '' ?>>Huawei</option>
                                <option value="Sony" <?= $brand === 'Sony' ? 'selected' : '' ?>>Sony</option>
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
<div class="col-md-3">
    <button type="button" id="resetFilters" class="btn btn-secondary w-100">Réinitialiser</button>
</div>


                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Section des smartphones -->
    <div class="content-section-wrapper">
        <div class="container content-section">
            <h1>Nos smartphones</h1>
            <div class="row">
                <?php if (!empty($smartphones)) : ?>
                    <?php foreach ($smartphones as $smartphone) : ?>
                        <div class="col-md-4 mb-4">
                            <div class="card h-100">
                                <img src="images/<?= htmlspecialchars($smartphone['images']) ?>" class="card-img-top" alt="<?= htmlspecialchars($smartphone['nom']) ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?= htmlspecialchars($smartphone['nom']) ?></h5>
                                    <p class="card-text"><?= htmlspecialchars($smartphone['description']) ?></p>
                                    <p class="card-text"><strong>Prix :</strong> <?= number_format($smartphone['prix'], 2, ',', ' ') ?> €</p>
                                    <a href="produit.php?id=<?= htmlspecialchars($smartphone['id_produits']) ?>" class="btn btn-primary">Voir le produit</a>
                                    <a href="ajouter_panier.php?id=<?= htmlspecialchars($smartphone['id_produits']) ?>" class="btn btn-success ms-2">Ajouter au panier</a>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else : ?>
                    <div class="col-12">
                        <p class="text-center"><?= $noProductsMessage ?? 'Aucun smartphone trouvé.' ?></p>
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
    <script>
    document.getElementById('resetFilters').addEventListener('click', function () {
        window.location.href = window.location.pathname;
    });
</script>

</body>
</html>
<?php include 'footer.php'; ?>