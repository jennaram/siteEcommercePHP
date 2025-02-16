<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);

session_start();
include 'db.php';

if (!isset($_SESSION['id_users'])) {
    header('Location: user.php?redirect=' . urlencode($_SERVER['REQUEST_URI']));
    exit;
}

if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id_produit = (int)$_GET['id'];
$id_user = $_SESSION['id_users'];

try {
    $pdo = getDBConnection();

    // Vérifier si le produit est déjà dans les favoris
    $sql = "SELECT * FROM favoris WHERE id_users = :id_users AND id_produits = :id_produits";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['id_users' => $id_user, 'id_produits' => $id_produit]);

    if ($stmt->fetch()) {
        $_SESSION['message'] = "Ce produit est déjà dans vos favoris.";
    } else {
        // Ajouter le produit aux favoris
        $sql = "INSERT INTO favoris (id_users, id_produits) VALUES (:id_users, :id_produits)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id_users' => $id_user, 'id_produits' => $id_produit]);
        $_SESSION['message'] = "Produit ajouté aux favoris.";
    }

    $redirect_url = !empty($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : 'index.php';
    header('Location: ' . $redirect_url);
    exit;
} catch (PDOException $e) {
    die("Erreur de base de données : " . $e->getMessage());
}
?>