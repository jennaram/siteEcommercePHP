<?php
session_start();

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_users'])) {
    $_SESSION['error'] = "Vous devez être connecté pour poster un commentaire.";
    header("Location: produit.php?id=" . ($_POST['id_produit'] ?? ''));
    exit;
}

// Inclure le fichier de connexion à la base de données
include 'db.php';

// Récupérer les données du formulaire
$id_produit = $_POST['id_produit'] ?? null;
$notation = $_POST['notation'] ?? null;
$message = $_POST['message'] ?? null;

// Validation des données
if (!$id_produit || !$notation || !$message) {
    $_SESSION['error'] = "Tous les champs sont obligatoires.";
    header("Location: produit.php?id=" . $id_produit);
    exit;
}

if ($notation < 1 || $notation > 5) {
    $_SESSION['error'] = "La note doit être comprise entre 1 et 5.";
    header("Location: produit.php?id=" . $id_produit);
    exit;
}

// Nettoyer le message pour éviter les injections
$message = htmlspecialchars($message, ENT_QUOTES, 'UTF-8');

// Insérer le commentaire dans la base de données
try {
    $stmt = $pdo->prepare("
        INSERT INTO commentaires (id_users, id_produits, notation, messages)
        VALUES (:id_users, :id_produits, :notation, :messages)
    ");
    $stmt->execute([
        ':id_users' => $_SESSION['id_users'],
        ':id_produits' => $id_produit,
        ':notation' => $notation,
        ':messages' => $message
    ]);

    // Message de succès
    $_SESSION['success'] = "Votre commentaire a bien été ajouté.";
} catch (PDOException $e) {
    // Gestion des erreurs de base de données
    $_SESSION['error'] = "Une erreur s'est produite lors de l'ajout du commentaire.";
}

// Rediriger vers la page du produit
header("Location: produit.php?id=" . $id_produit);
exit;
?>