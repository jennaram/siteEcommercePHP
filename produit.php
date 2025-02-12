<?php
include 'db.php';

// Vérifier si l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
// Vérifier si on vient de la page promo
$showPromo = isset($_GET['promo']) && $_GET['promo'] == 1;

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Requête SQL pour récupérer les informations du produit
$sql = "SELECT p.*, m.nom_marque
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        WHERE p.id_produits = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas, rediriger vers la page d'accueil
if (!$produit) {
    header('Location: index.php');
    exit;
}

// Calculer le prix avec la promotion UNIQUEMENT si on vient de la page promo
$prixFinal = ($showPromo && $produit['promos'] > 0)
    ? $produit['prix'] * (1 - $produit['promos']/100)
    : $produit['prix'];
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        .product-details {
            padding: 20px;
        }
        .product-details img {
            max-width: 50%;
            height: auto;
            display: block;
            margin: 0 auto;
            margin-bottom: 20px;
        }
        .promo-badge {
            margin-bottom: 10px;
        }
        .original-price {
            margin-right: 10px;
        }
        .promo-price {

        }
        .price-info {
            display: flex;
            align-items: center;
        }
        .promo-icon {
            margin-left: 5px;
            color: red;
        }
    </style>
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="images/<?= htmlspecialchars($produit['images']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <h1><?= htmlspecialchars($produit['nom']) ?></h1>

                    <?php if ($showPromo && $produit['promos'] > 0): ?>
                        <div class="promo-badge">
                            <span class="badge bg-danger">-<?= htmlspecialchars($produit['promos']) ?>%</span>
                        </div>
                    <?php endif; ?>

                    <p><?= htmlspecialchars($produit['description']) ?></p>
                    <p><strong>Marque :</strong> <?= htmlspecialchars($produit['nom_marque']) ?></p>

                    <div class="price-info">
                        <?php if ($showPromo && $produit['promos'] > 0): ?>
                            <span class="original-price text-decoration-line-through text-muted">
                                <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                            </span>
                            <span class="promo-price text-danger fw-bold">
                                <?= number_format($prixFinal, 2, ',', ' ') ?> €
                            </span>
                            <i class="bi bi-gift promo-icon"></i>
                        <?php else: ?>
                            <span class="regular-price">
                                <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                            </span>
                        <?php endif; ?>
                    </div>

                    <button class="btn btn-primary mt-3">Ajouter au panier</button>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>