<?php
session_start();

unset($_SESSION['panier']);
header('Location: cart.php');
exit;
?>