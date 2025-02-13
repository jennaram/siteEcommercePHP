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

        if ($quantite <= 0) {
            // Si la quantité est 0 ou moins, supprimer le produit
            foreach ($_SESSION['panier'] as $key => $item) {
                if ($item['id'] == $productId) {
                    unset($_SESSION['panier'][$key]);
                    $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer le tableau
                    break;
                }
            }
        } else {
            // Mettre à jour la quantité
            foreach ($_SESSION['panier'] as &$item) {
                if ($item['id'] == $productId) {
                    $item['quantite'] = $quantite;
                    break;
                }
            }
        }
    }

    // Rediriger pour éviter la soumission multiple
    header('Location: cart.php');
    exit();
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
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center mb-4">Votre Panier</h1>

        <?php if (isset($_SESSION['panier']) && !empty($_SESSION['panier'])) : ?>
            <form action="cart.php" method="post">
                <table class="table table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Produit</th>
                            <th>Prix unitaire</th>
                            <th>Quantité</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $totalPanier = 0;
                        foreach ($_SESSION['panier'] as $item) :
                            $totalProduit = $item['prix'] * $item['quantite'];
                            $totalPanier += $totalProduit;
                        ?>
                            <tr>
                                <td><?= htmlspecialchars($item['nom']) ?></td>
                                <td><?= htmlspecialchars($item['prix']) ?> €</td>
                                <td>
                                    <input type="number" name="quantite[<?= $item['id'] ?>]" value="<?= $item['quantite'] ?>" min="1" class="form-control" style="width: 80px;">
                                </td>
                                <td><?= $totalProduit ?> €</td>
                                <td>
                                    <a href="cart.php?action=supprimer&idProduit=<?= $item['id'] ?>" class="btn btn-danger btn-sm">Supprimer</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <div class="text-end">
                    <p class="total h4">Total du panier : <?= $totalPanier ?> €</p>
                    <button type="submit" name="update_quantite" class="btn btn-primary">Mettre à jour le panier</button>
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