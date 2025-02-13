<?php
session_start();

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    header('Location: cart.php');
    exit;
}

// Ici, vous pouvez ajouter la logique pour enregistrer la commande dans la base de données

unset($_SESSION['panier']);
header('Location: merci_commande.php');
exit;
?>