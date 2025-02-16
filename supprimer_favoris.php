<?php
session_start();
include 'db.php';

if (!isset($_SESSION['id_users'])) {
    header('Location: user.php');
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: favoris.php');
    exit;
}

$id_favoris = (int)$_GET['id'];
$id_user = $_SESSION['id_users'];

// Supprimer le produit des favoris
$sql = "DELETE FROM favoris WHERE id_favoris = :id_favoris AND id_users = :id_users";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_favoris' => $id_favoris, 'id_users' => $id_user]);

$_SESSION['message'] = "Produit supprimé des favoris.";
header('Location: favoris.php');
exit;
