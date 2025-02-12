<?php 
session_start();
include 'header.php'; 
include 'db.php';

// Vérifier si l'utilisateur est connecté
if (isset($_SESSION['id_utilisateur'])) {
    $id_utilisateur = $_SESSION['id_utilisateur'];
} else {
    $id_utilisateur = null;
}

// Vérifier si le panier est présent dans la session
$panierExiste = isset($_SESSION['panier']) && !empty($_SESSION['panier']);

if (isset($_GET['supprimer'])) {
    $id_produit = $_GET['supprimer'];

    // Supprimer du panier en session
    if ($id_utilisateur) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("DELETE FROM details_panier WHERE id_users = :id_utilisateur AND id_produits = :id_produit");
        $stmt->execute([
            ':id_utilisateur' => $id_utilisateur,
            ':id_produit' => $id_produit
        ]);
    } else {
        unset($_SESSION['panier'][$id_produit]);
        $_SESSION['panier'] = array_values($_SESSION['panier']);  // Réindexer le panier
    }

    // Redirection pour éviter de recharger la page avec les paramètres GET
    header('Location: cart.php');
    exit;
}

// Affichage du panier
?>

<div class="container mt-5">
    <h1 class="text-center">Votre panier</h1>
    <?php if (!$panierExiste): ?>
        <p class="text-center">Votre panier est vide.</p>
    <?php else: ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Produit</th>
                    <th>Quantité</th>
                    <th>Prix unitaire</th>
                    <th>Total</th>
                    <th></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $total = 0;
                foreach ($_SESSION['panier'] as $id_produit => $produit):
                    $totalProduit = $produit['quantite'] * $produit['prix'];
                    $total += $totalProduit;
                ?>
                <tr>
                    <td><?= $produit['nom'] ?></td>
                    <td><?= $produit['quantite'] ?></td>
                    <td><?= number_format($produit['prix'], 2, ',', ' ') ?> €</td>
                    <td><?= number_format($totalProduit, 2, ',', ' ') ?> €</td>
                    <td>
                        <a href="cart.php?supprimer=<?= $id_produit ?>" class="btn btn-outline-danger">Supprimer</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <h3>Total: <?= number_format($total, 2, ',', ' ') ?> €</h3>
            <a href="checkout.php" class="btn btn-primary">Valider la commande</a>
        </div>
    <?php endif; ?>
</div>
