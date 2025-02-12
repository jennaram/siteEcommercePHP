<?php
session_start(); // Démarre la session

// Inclure la base de données
include 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Vérifier si l'ID du produit est passé dans l'URL
if (isset($_GET['id'])) {
    $productId = $_GET['id'];

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
