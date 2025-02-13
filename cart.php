<?php
session_start(); // Démarre la session

// Inclure la connexion à la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

// Gestion des actions (ajout, suppression, mise à jour de la quantité)
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Supprimer un produit du panier
    if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['idProduit'])) {
        $productIdToDelete = intval($_GET['idProduit']); // Nettoyer l'entrée

        if (isset($_SESSION['panier'])) {
            foreach ($_SESSION['panier'] as $key => $item) {
                if ($item['id'] == $productIdToDelete) {
                    unset($_SESSION['panier'][$key]);
                    $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer le tableau
                    break;
                }
            }
        }

        // Rediriger pour éviter la soumission multiple
        header('Location: cart.php');
        exit();
    }

    // Ajouter un produit au panier
    if (isset($_GET['id'])) {
        $productId = intval($_GET['id']); // Nettoyer l'entrée

        // Récupérer les informations du produit depuis la base de données
        $sql = "SELECT * FROM produits WHERE id_produits = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id' => $productId]);
        $product = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($product) {
            // Initialiser le panier si nécessaire
            if (!isset($_SESSION['panier'])) {
                $_SESSION['panier'] = [];
            }

            // Vérifier si le produit est déjà dans le panier
            $found = false;
            foreach ($_SESSION['panier'] as &$item) {
                if ($item['id'] == $product['id_produits']) {
                    $item['quantite']++;
                    $found = true;
                    break;
                }
            }

            // Si le produit n'est pas dans le panier, l'ajouter
            if (!$found) {
                $newItem = [
                    'id' => $product['id_produits'],
                    'nom' => $product['nom'],
                    'prix' => $product['prix'],
                    'quantite' => 1,
                ];
                $_SESSION['panier'][] = $newItem;
            }

            // Rediriger pour éviter la soumission multiple
            header('Location: cart.php');
            exit();
        } else {
            echo "Produit non trouvé.";
        }
    }
}

// Gestion de la mise à jour de la quantité (via formulaire POST)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_quantite'])) {
    foreach ($_POST['quantite'] as $productId => $quantite) {
        $productId = intval($productId);
        $quantite = intval($quantite);

    // Récupérer les produits du panier
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Suppression d'un produit pour un utilisateur connecté
    if (isset($_GET['supprimer'])) {
        $id_produit = $_GET['supprimer'];

        // Requête pour supprimer le produit du panier en base de données
        $sql = "DELETE FROM details_panier WHERE id_users = :id_utilisateur AND id_produits = :id_produit";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':id_utilisateur' => $id_utilisateur,
            ':id_produit' => $id_produit
        ]);

        // Mettre à jour le panier en session
        $sql = "SELECT p.id_produits, p.nom, p.prix, dp.quantite, p.description, p.images
                FROM details_panier dp
                JOIN produits p ON dp.id_produits = p.id_produits
                WHERE dp.id_users = :id_utilisateur";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([':id_utilisateur' => $id_utilisateur]);
        $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Votre Panier</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Votre Panier</h1>

    <!-- Contenu principal du panier -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="h3 mb-4">Votre Panier</h1>

                <!-- Affichage des produits dans le panier -->
                <?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0): ?>
                    <?php foreach ($_SESSION['panier'] as $id_produit => $produit): ?>
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
                                        
                                        <form method="POST" action="cart.php" class="d-flex align-items-center">
                                            <!-- Champ quantité -->
                                            <input type="number" name="quantite" value="<?= $produit['quantite'] ?>" min="1" class="form-control w-25 me-2">
                                            <button type="submit" class="btn btn-primary" name="modifier_quantite" value="<?= $id_produit ?>">Modifier</button>
                                        </form>

                                        <small class="text-muted">Quantité: <?= $produit['quantite'] ?></small>
                                        
                                        <!-- Bouton Supprimer -->
                                        <div class="d-flex justify-content-between mt-3">
                                            <a href="cart.php?supprimer=<?= $id_produit ?>" class="btn btn-outline-danger">Supprimer</a>
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
                                foreach ($_SESSION['panier'] as $id_produit => $produit) {
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
                        <?php if (!$id_utilisateur): ?>
                            <!-- Lien vers la page de connexion / inscription -->
                            <a href="user.php?rediriger=panier" class="btn btn-success w-100 mb-3">Se connecter ou s'inscrire</a>
                        <?php else: ?>
                            <button class="btn btn-success w-100 mb-3">Passer à la commande</button>
                        <?php endif; ?>
                        <div class="text-center payment-icons">
                            <img src="images/visa.png" alt="Visa" style="height: 30px; margin: 0 5px;">
                            <img src="images/mastercard.png" alt="Mastercard" style="height: 30px; margin: 0 5px;">
                            <img src="images/paypal.png" alt="PayPal" style="height: 30px; margin: 0 5px;">
                        </div>
                    </div>
                </div>
            </form>
        <?php else : ?>
            <p class="text-center">Votre panier est vide.</p>
        <?php endif; ?>

        <div class="text-center mt-4">
            <a href="index.php" class="btn btn-success">Continuer vos achats</a>
        </div>
    </div>

    <!-- Bootstrap JS (optionnel, si vous avez besoin de fonctionnalités JS) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>