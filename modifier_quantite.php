<?php
session_start();

if (!isset($_POST['id']) || !isset($_POST['quantite'])) {
    header('Location: cart.php');
    exit;
}

$id = (int)$_POST['id'];
$quantite = (int)$_POST['quantite'];

if ($quantite < 1) {
    header('Location: cart.php');
    exit;
}

if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]['quantite'] = $quantite;
}

header('Location: cart.php');
exit;
?>