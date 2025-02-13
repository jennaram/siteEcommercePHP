<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
$pdo = getDBConnection();

// Récupérer les informations du produit
$stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produits = :id");
$stmt->execute(['id' => $id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    header('Location: index.php');
    exit;
}

// Initialiser le panier s'il n'existe pas
if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Ajouter le produit au panier ou augmenter la quantité
if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]['quantite'] += 1; // Augmenter la quantité de 1
} else {
    $_SESSION['panier'][$id] = [
        'nom' => $produit['nom'],
        'prix' => $produit['prix'],
        'quantite' => 1, // Quantité initiale
        'image' => $produit['images']
    ];
}

header('Location: cart.php'); // Rediriger vers la page du panier
exit;
?>