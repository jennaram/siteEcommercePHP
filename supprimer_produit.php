<?php
session_start();

$id = $_GET['id'];

if (isset($_SESSION['panier'][$id])) {
    unset($_SESSION['panier'][$id]);
}

header('Location: cart.php');
exit;