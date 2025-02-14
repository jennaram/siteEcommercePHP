<?php
// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (!isset($_SESSION['id_users'])) {
    // Rediriger vers la page de connexion si l'utilisateur n'est pas connecté
    header("Location: login.php");
    exit;
}

// Récupérer l'ID de l'utilisateur depuis la session
$id_users = $_SESSION['id_users'];

// Supposons que vous avez un tableau de produits dans le panier
$panier = [
    ['id_produit' => 1, 'quantite' => 2, 'prix_unitaire' => 10.00],
    ['id_produit' => 2, 'quantite' => 1, 'prix_unitaire' => 15.00],
    // Ajoutez d'autres produits ici
];

// Insérer chaque produit du panier dans la table details_panier
$pdo = getDBConnection();
foreach ($panier as $produit) {
    $stmt = $pdo->prepare("
        INSERT INTO details_panier (id_users, id_produit, quantite, prix_unitaire)
        VALUES (:id_users, :id_produit, :quantite, :prix_unitaire)
    ");
    $stmt->execute([
        ':id_users' => $id_users,
        ':id_produit' => $produit['id_produit'],
        ':quantite' => $produit['quantite'],
        ':prix_unitaire' => $produit['prix_unitaire']
    ]);

    if ($stmt->rowCount() > 0) {
        echo "Produit inséré avec succès dans details_panier.<br>";
    } else {
        echo "Erreur lors de l'insertion du produit dans details_panier.<br>";
    }
}

// Rediriger l'utilisateur vers une page de confirmation ou autre
header("Location: confirmation.php");
exit;
?>