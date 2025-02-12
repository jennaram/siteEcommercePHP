<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Supposons que l'ID de l'utilisateur soit stocké dans la session
// Remplace cette valeur par l'ID réel de l'utilisateur
$id_utilisateur = 1; // Utilisateur de test (à remplacer par l'ID de l'utilisateur connecté)

// Requête SQL pour récupérer les produits du panier
$sql = "SELECT p.id_produits, p.nom, p.prix, dp.quantite, p.description, p.images
        FROM details_panier dp
        JOIN produits p ON dp.id_produits = p.id_produits
        WHERE dp.id_users = :id_utilisateur";
$stmt = $pdo->prepare($sql);
$stmt->execute([':id_utilisateur' => $id_utilisateur]);

// Récupérer les résultats
$panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php include 'header.php'; ?> <!-- Inclure l'entête -->

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier - Site Marchand</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
</head>
<body>

    <!-- Contenu principal du panier -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="h3 mb-4">Votre Panier</h1>

                <!-- Affichage des produits dans le panier -->
                <?php if (count($panier) > 0): ?>
                    <?php foreach ($panier as $produit): ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img src="images/<?= htmlspecialchars($produit['images']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" class="img-fluid">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($produit['description']) ?></p>
                                        <p class="h4 mb-0"><?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                                        <small class="text-muted">Quantité: <?= $produit['quantite'] ?></small>
                                        <div class="d-flex justify-content-between mt-3">
                                            <a href="#" class="btn btn-outline-secondary">Modifier</a>
                                            <a href="#" class="btn btn-outline-danger">Supprimer</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>Votre panier est vide.</p>
                <?php endif; ?>
            </div>

            <!-- Résumé de la commande -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">TOTAL</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Sous-total</span>
                            <span>
                                <?php 
                                $total = 0;
                                foreach ($panier as $produit) {
                                    $total += $produit['prix'] * $produit['quantite'];
                                }
                                echo number_format($total, 2, ',', ' ') . " €"; 
                                ?>
                            </span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Livraison</span>
                            <span>Gratuit</span>
                        </div>
                        <button class="btn btn-success w-100 mb-3">Passer à la commande</button>
                        <div class="text-center payment-icons">
                            <img src="images/visa.png" alt="Visa" style="height: 30px; margin: 0 5px;">
                            <img src="images/mastercard.png" alt="Mastercard" style="height: 30px; margin: 0 5px;">
                            <img src="images/paypal.png" alt="PayPal" style="height: 30px; margin: 0 5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?> <!-- Inclure le pied de page -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
