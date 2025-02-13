<?php
session_start();

$id = $_POST['id'];
$quantite = $_POST['quantite'];

if (isset($_SESSION['panier'][$id])) {
    $_SESSION['panier'][$id]['quantite'] = $quantite;
}

header('Location: cart.php');
exit;