<?php
session_start(); // Démarre la session

// Inclure la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

if (!$pdo) {
    die("Erreur de connexion à la base de données.");
}

// Si l'action est "supprimer", procéder à la suppression
if (isset($_GET['action']) && $_GET['action'] == 'supprimer' && isset($_GET['idProduit'])) {
    $productIdToDelete = intval($_GET['idProduit']); // Nettoyer l'entrée

    // Vérifier si le panier existe dans la session
    if (isset($_SESSION['panier'])) {
        // Parcourir le panier pour trouver le produit à supprimer
        foreach ($_SESSION['panier'] as $key => $item) {
            if ($item['id'] == $productIdToDelete) {
                // Supprimer l'élément du panier
                unset($_SESSION['panier'][$key]);
                $_SESSION['panier'] = array_values($_SESSION['panier']); // Réindexer l'array
                break;
            }
        }
    }

    // Rediriger vers la page du panier
    header('Location: cart.php');
    exit();
}

// Vérifier si l'ID du produit est passé dans l'URL pour l'ajouter au panier
if (isset($_GET['id'])) {
    $productId = intval($_GET['id']); // Nettoyer l'entrée

    // Récupérer les informations du produit à partir de la base de données
    $sql = "SELECT * FROM produits WHERE id_produits = :id";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([':id' => $productId]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    // Si le produit existe, l'ajouter au panier
    if ($product) {
        // Initialiser le panier si ce n'est pas déjà fait
        if (!isset($_SESSION['panier'])) {
            $_SESSION['panier'] = [];
        }

        // Vérifier si le produit est déjà dans le panier
        $found = false;
        foreach ($_SESSION['panier'] as &$item) {
            if ($item['id'] == $product['id_produits']) {
                // Si le produit est déjà dans le panier, on augmente la quantité
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

        // Rediriger vers la page du panier
        header('Location: cart.php');
        exit();
    } else {
        // Si le produit n'existe pas
        echo "Produit non trouvé.";
    }
} else {
    // Si l'ID du produit n'est pas passé dans l'URL
    echo "Aucun produit sélectionné.";
}
?>