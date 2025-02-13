<?php
session_start();

$id = $_POST['id'];
$quantite = $_POST['quantite'];

if (!isset($_SESSION['panier'])) {
    $_SESSION['panier'] = [];
}

if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]['quantite'] += $quantite;
} else {
    $_SESSION['panier'][$id] = [
        'nom' => $_POST['nom'],
        'prix' => $_POST['prix'],
        'quantite' => $quantite,
        'image' => $_POST['image']
    ];
}

header('Location: cart.php');
exit;