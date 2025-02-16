<?php
session_start();

// Activer la mise en tampon de sortie
ob_start();

include 'header.php';

// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['panier']) || empty($_SESSION['panier'])) {
    echo "<p>Votre panier est vide.</p>";
    include 'footer.php';
    exit;
}

$panier = $_SESSION['panier'];
$total = 0;

// Vérifier si l'utilisateur est connecté avant de passer commande
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['passer_commande'])) {
    if (!isset($_SESSION['id_users'])) {
        // Rediriger vers la page de connexion avec une redirection vers le panier
        header("Location: user.php?redirect=" . urlencode("cart.php"));
        ob_end_clean(); // Nettoyer le tampon de sortie
        exit;
    } else {
        // Rediriger vers la page de confirmation de commande
        header("Location: merci_commande.php");
        ob_end_clean(); // Nettoyer le tampon de sortie
        exit;
    }
}

// Vider le tampon de sortie et envoyer les en-têtes
ob_end_flush();
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
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #A6C8D1; color: #000;">
                        <h2 class="h5 mb-0">Votre Panier</h2>
                    </div>
                    <div class="card-body">
                        <table class="table table-hover">
                            <thead class="thead-light">
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
                                            <div class="d-flex align-items-center">
                                                <img src="images/<?= htmlspecialchars($item['image']) ?>"
                                                    alt="<?= htmlspecialchars($item['nom']) ?>" width="50"
                                                    class="mr-3">
                                                <span><?= htmlspecialchars($item['nom']) ?></span>
                                            </div>
                                        </td>
                                        <td>
                                            <form method="POST" action="modifier_quantite.php"
                                                class="d-flex align-items-center">
                                                <input type="number" name="quantite"
                                                    value="<?= htmlspecialchars($item['quantite']) ?>" min="1"
                                                    class="form-control form-control-sm w-50 mr-2">
                                                <input type="hidden" name="id" value="<?= htmlspecialchars($id) ?>">
                                                <button type="submit" class="btn btn-sm"
                                                    style="background-color: #A6C8D1; color: #000;">Modifier</button>
                                            </form>
                                        </td>
                                        <td><?= number_format($item['prix'], 2, ',', ' ') ?> €</td>
                                        <td><?= number_format($item['prix_final'] * $item['quantite'], 2, ',', ' ') ?>
                                            €</td>
                                        <td>
                                            <a href="supprimer_produit.php?id=<?= htmlspecialchars($id) ?>"
                                                class="btn btn-sm btn-danger">Supprimer</a>
                                        </td>
                                    </tr>
                                    <?php $total += $item['prix_final'] * $item['quantite']; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    <div class="card-footer bg-light">
                        <a href="vider_panier.php" class="btn btn-danger">Vider le panier</a>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm">
                    <div class="card-header" style="background-color: #A6C8D1; color: #000;">
                        <h2 class="h5 mb-0">Récapitulatif</h2>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Sous-total
                                <span class="font-weight-bold"><?= number_format($total, 2, ',', ' ') ?> €</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Livraison
                                <span class="text-success font-weight-bold">Gratuite</span>
                            </li>
                            <li class="list-group-item d-flex justify-content-between align-items-center">
                                Total
                                <span class="font-weight-bold"><?= number_format($total, 2, ',', ' ') ?> €</span>
                            </li>
                        </ul>
                    </div>
                    <div class="card-footer bg-light">
                        <form method="POST" action="cart.php">
                            <button type="submit" name="passer_commande" class="btn btn-block btn-lg"
                                style="background-color: #A6C8D1; color: #000; border-color: #A6C8D1;">Passer la
                                commande</button>
                        </form>
                        <div class="d-flex justify-content-center mt-3">
                            <img src="images/visa.png" alt="Visa" width="50" class="mx-2">
                            <img src="images/masterCard.png" alt="MasterCard" width="50" class="mx-2">
                            <img src="images/paypal.png" alt="PayPal" width="50" class="mx-2">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
