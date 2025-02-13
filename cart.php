<?php
session_start();
include 'header.php';

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "<p>Votre panier est vide.</p>";
    include 'footer.php';
    exit;
}

$panier = $_SESSION['panier'];
$total = 0;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8">
                <h2>Votre Panier</h2>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Produit</th>
                            <th>Quantité</th>
                            <th>Prix unitaire</th>
                            <th>Total</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($panier as $id => $item): ?>
                            <tr>
                                <td>
                                    <img src="images/<?= htmlspecialchars($item['image']) ?>" alt="<?= htmlspecialchars($item['nom']) ?>" width="50">
                                    <?= htmlspecialchars($item['nom']) ?>
                                </td>
                                <td>
                                <form method="POST" action="modifier_quantite.php">
    <input type="number" name="quantite" value="<?= htmlspecialchars($item['quantite']) ?>" min="1">
    <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
    <button type="submit" class="btn btn-sm btn-primary">Modifier</button>
</form>
                                </td>
                                <td><?= number_format($item['prix'], 2, ',', ' ') ?> €</td>
                                <td><?= number_format($item['prix'] * $item['quantite'], 2, ',', ' ') ?> €</td>
                                <td>
                                    <a href="supprimer_produit.php?id=<?= htmlspecialchars($id) ?>" class="btn btn-sm btn-danger">Supprimer</a>
                                </td>
                            </tr>
                            <?php $total += $item['prix'] * $item['quantite']; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <a href="vider_panier.php" class="btn btn-danger">Vider le panier</a>
            </div>
            <div class="col-md-4">
                <h2>Récapitulatif</h2>
                <p>Sous-total: <?= number_format($total, 2, ',', ' ') ?> €</p>
                <p>Livraison: Gratuite</p>
                <p>Total: <?= number_format($total, 2, ',', ' ') ?> €</p>
                <a href="commander.php" class="btn btn-success">Passer la commande</a>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>