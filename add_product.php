<?php
session_start();
if (!isset($_SESSION['id_users']) || $_SESSION['admin'] != 1) {
    header("Location: index.php");
    exit;
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $description = $_POST['description'];
    $id_marques = $_POST['id_marques'];
    $id_type_produits = $_POST['id_type_produits'];

    $pdo = getDBConnection();
    $stmt = $pdo->prepare("
        INSERT INTO produits (nom, prix, id_marques, id_type_produits, description)
        VALUES (:nom, :prix, :id_marques, :id_type_produits, :description)
    ");
    $stmt->execute([
        ':nom' => $nom,
        ':prix' => $prix,
        ':id_marques' => $id_marques,
        ':id_type_produits' => $id_type_produits,
        ':description' => $description
    ]);

    header("Location: admin.php");
    exit;
}
?>