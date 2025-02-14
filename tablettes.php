<?php include 'header.php'; ?>
<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Définir l'ID du type de produit "tablette"
$id_type_tablette = 3; // Remplacez par l'ID correct

// Récupération des filtres depuis l'URL
$brand = $_GET['brand'] ?? '';
$sort = $_GET['sort'] ?? '';

// Début de la requête SQL
$sql = "SELECT p.id_produits, p.nom, p.prix, p.description, p.images, m.nom_marque 
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        WHERE p.id_type_produits = :id_type_tablette";

// Ajout du filtre par marque
$params = [':id_type_tablette' => $id_type_tablette];

if (!empty($brand)) {
    $sql .= " AND m.nom_marque = :brand";
    $params[':brand'] = $brand;
}

// Ajout du tri
if ($sort === 'price_asc') {
    $sql .= " ORDER BY p.prix ASC";
} elseif ($sort === 'price_desc') {
    $sql .= " ORDER BY p.prix DESC";
}

// Exécution de la requête
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$tablettes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nos Tablettes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
    
</head>
<body class="page-tablettes">
    <!-- Bandeau promotionnel -->
    <div class="promo-banner py-4">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-start">
                    <h1 class="fw-bold">Nos dernières tablettes !</h1>
                    <p class="lead">Profitez de nos offres exclusives sur une large sélection de produits.</p>
                    <a href="promo.php" class="btn btn-lg" style="background-color: #FDD835; color: black;">
                        Découvrir nos offres
                    </a>
                </div>
                <div class="col-md-6 text-end">
                    <img src="images/promo-tablette.png" alt="promotions tablettes" class="img-fluid rounded" style="max-width: 40%;">
                </div>
            </div>
        </div>
    </div>

    <!-- Filtres de recherche -->
    <div class="container mt-4">
        <form method="GET" action="tablettes.php">
            <div class="row">
                <div class="col-md-3">
                    <select name="brand" class="form-select">
                        <option value="">Toutes les marques</option>
                        <?php
                        // Récupérer les marques de tablettes disponibles
                        $marquesStmt = $pdo->query("SELECT DISTINCT m.nom_marque FROM marques m 
                                                    JOIN produits p ON p.id_marques = m.id_marque 
                                                    WHERE p.id_type_produits = $id_type_tablette");
                        $marques = $marquesStmt->fetchAll(PDO::FETCH_COLUMN);

                        foreach ($marques as $marque) {
                            $selected = ($brand === $marque) ? 'selected' : '';
                            echo "<option value=\"$marque\" $selected>$marque</option>";
                        }
                        ?>
                    </select>
                </div>
                <div class="col-md-3">
                    <select name="sort" class="form-select">
                        <option value="price_asc" <?= ($sort === 'price_asc') ? 'selected' : '' ?>>Prix croissant</option>
                        <option value="price_desc" <?= ($sort === 'price_desc') ? 'selected' : '' ?>>Prix décroissant</option>
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

    <!-- Section des tablettes -->

    <div class="content-section-wrapper">
    <div class="container content-section">
        <h1>Nos tablettes</h1>
        <div class="row">
            <?php if (!empty($tablettes)) : ?>
                <?php foreach ($tablettes as $tablette) : ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                        <img src="images/<?= htmlspecialchars($tablette['images']) ?>" 
     alt="<?= htmlspecialchars($product['nom']) ?>" 
     class="img-fluid product-image" 
     style="max-width: 300px; height: auto;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($tablette['nom']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($tablette['description']) ?></p>
                                <p class="card-text"><strong>Prix :</strong> <?= number_format($tablette['prix'], 2, ',', ' ') ?> €</p>
                                <!-- Bouton Voir le produit -->
                                <a href="produit.php?id=<?= htmlspecialchars($tablette['id_produits']) ?>" class="btn btn-primary">Voir le produit</a>
                                <!-- Nouveau bouton "Ajouter au panier" -->
                                <a href="ajouter_panier.php?id=<?= htmlspecialchars($tablette['id_produits']) ?>" class="btn btn-success ms-2">Ajouter au panier</a>
                            </div>
                        </div> <!-- Fermeture de la div card -->
                    </div> <!-- Fermeture de la div col-md-4 -->
                <?php endforeach; ?>
            <?php else : ?>
                <div class="col-12">
                    <p class="text-center"><?= $noProductsMessage ?? 'Aucune tablette trouvée.' ?></p>
                </div>
            <?php endif; ?>
        </div> <!-- Fermeture de la div row -->
    </div> <!-- Fermeture de la div container content-section -->
</div> <!-- Fermeture de la div content-section-wrapper -->

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
