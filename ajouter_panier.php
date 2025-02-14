<?php
session_start();
include 'db.php';

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id']; // L'ID du produit

$pdo = getDBConnection();

$stmt = $pdo->prepare("SELECT * FROM produits WHERE id_produits = :id");
$stmt->execute(['id' => $id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$produit) {
    header('Location: index.php');
    exit;
}

$prixFinal = $produit['prix'];
$reductionPercentage = 0;

if ($produit['promos'] > 0) {
    $prixFinal = $produit['prix'] * (1 - $produit['promos'] / 100);
    $reductionPercentage = $produit['promos'];
}

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

// Utiliser l'ID du produit comme clé, même si on vient de promo.php
if (isset($_SESSION['panier'][$id])) { // <-- Utilisation de $id
    $_SESSION['panier'][$id]['quantite'] += 1;
} else {
    $_SESSION['panier'][$id] = [ // <-- Utilisation de $id
        'nom' => $produit['nom'],
        'prix' => $produit['prix'],
        'prix_final' => $prixFinal,
        'reduction_percentage' => $reductionPercentage,
        'quantite' => 1,
        'image' => $produit['images']
    ];
}

header('Location: cart.php');
exit;
?>