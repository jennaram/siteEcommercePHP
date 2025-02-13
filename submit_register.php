<?php
// Inclure le fichier de connexion à la base de données
include 'db.php';

// Démarrer la session pour gérer le panier
session_start();

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Si l'utilisateur est connecté, on récupère son ID
$id_utilisateur = isset($_SESSION['id_utilisateur']) ? $_SESSION['id_utilisateur'] : null;

// Gestion du panier pour les utilisateurs non connectés (via la session)
if (!$id_utilisateur) {
    // Si le panier n'existe pas encore, on le crée
    if (!isset($_SESSION['panier'])) {
        $_SESSION['panier'] = [];
    }

    // Ajouter un produit au panier
    if (isset($_POST['ajouter_au_panier'])) {
        $id_produit = $_POST['id_produit'];
        $quantite = $_POST['quantite'];

        // Si le produit existe déjà dans le panier, on met à jour la quantité
        if (isset($_SESSION['panier'][$id_produit])) {
            $_SESSION['panier'][$id_produit]['quantite'] += $quantite;
        } else {
            // Sinon, on ajoute le produit au panier
            $_SESSION['panier'][$id_produit] = [
                'id' => $id_produit,
                'quantite' => $quantite
            ];
        }
    }

    // Supprimer un produit du panier
    if (isset($_GET['supprimer'])) {
        $id_produit = $_GET['supprimer'];
        if (isset($_SESSION['panier'][$id_produit])) {
            unset($_SESSION['panier'][$id_produit]); // Supprimer le produit
        }
    }

    // Modifier la quantité d'un produit dans le panier
    if (isset($_POST['modifier_quantite']) && isset($_POST['quantite'])) {
        $id_produit = $_POST['modifier_quantite'];
        $quantite = $_POST['quantite'];

        if (isset($_SESSION['panier'][$id_produit])) {
            $_SESSION['panier'][$id_produit]['quantite'] = $quantite;
        }
    }
}

// Si l'utilisateur est connecté, on récupère son panier depuis la base de données
if ($id_utilisateur) {
    // Requête SQL pour récupérer les produits du panier de l'utilisateur
    $sql = "SELECT p.id_produits, p.nom, p.prix, dp.quantite, p.description, p.images
            FROM details_panier dp
            JOIN produits p ON dp.id_produits = p.id_produits
            WHERE dp.id_users = :id_utilisateur";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id_utilisateur' => $id_utilisateur]);

    // Récupérer les produits du panier
    $panier = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

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
    <!-- Inclure le header -->
    <?php include 'header.php'; ?>

    <!-- Contenu principal du panier -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <h1 class="h3 mb-4">Votre Panier</h1>

                <!-- Affichage des produits dans le panier -->
                <?php if (isset($_SESSION['panier']) && count($_SESSION['panier']) > 0): ?>
                    <?php foreach ($_SESSION['panier'] as $id_produit => $produit): ?>
                        <?php
                        // Récupérer les détails du produit depuis la base de données
                        $sql = "SELECT * FROM produits WHERE id_produits = :id_produit";
                        $stmt = $pdo->prepare($sql);
                        $stmt->execute([':id_produit' => $id_produit]);
                        $details_produit = $stmt->fetch(PDO::FETCH_ASSOC);
                        ?>
                        <div class="card mb-4">
                            <div class="card-body">
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <img src="images/<?= htmlspecialchars($details_produit['images']) ?>" alt="<?= htmlspecialchars($details_produit['nom']) ?>" class="img-fluid">
                                    </div>
                                    <div class="col-md-9">
                                        <h5 class="card-title"><?= htmlspecialchars($details_produit['nom']) ?></h5>
                                        <p class="card-text"><?= htmlspecialchars($details_produit['description']) ?></p>
                                        <p class="h4 mb-0"><?= number_format($details_produit['prix'], 2, ',', ' ') ?> €</p>
                                        
                                        <!-- Formulaire pour modifier la quantité -->
                                        <form method="POST" action="cart.php" class="d-flex align-items-center">
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
                                if (isset($_SESSION['panier'])) {
                                    foreach ($_SESSION['panier'] as $id_produit => $produit) {
                                        $sql = "SELECT prix FROM produits WHERE id_produits = :id_produit";
                                        $stmt = $pdo->prepare($sql);
                                        $stmt->execute([':id_produit' => $id_produit]);
                                        $details_produit = $stmt->fetch(PDO::FETCH_ASSOC);
                                        $total += $details_produit['prix'] * $produit['quantite'];
                                    }
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
                            <a href="connexion.php" class="btn btn-success w-100 mb-3">Se connecter ou s'inscrire</a>
                        <?php else: ?>
                            <!-- Lien vers user.php pour passer à la commande -->
                            <a href="user.php" class="btn btn-success w-100 mb-3">Passer à la commande</a>
                        <?php endif; ?>
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

    <!-- Inclure le footer -->
    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>