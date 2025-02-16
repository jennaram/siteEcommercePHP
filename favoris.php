<?php
session_start();
include 'db.php';
include 'header.php';

if (!isset($_SESSION['id_users'])) {
    header('Location: user.php');
    exit;
}

$id_user = $_SESSION['id_users'];

// Récupérer les produits favoris
$sql = "SELECT p.*, f.id_favoris
        FROM produits p
        JOIN favoris f ON p.id_produits = f.id_produits
        WHERE f.id_users = :id_users";
$stmt = $pdo->prepare($sql);
$stmt->execute(['id_users' => $id_user]);
$favoris = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Favoris</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-5">
        <h1>Mes Favoris</h1>
        <?php if (empty($favoris)): ?>
            <p>Vous n'avez aucun produit dans vos favoris.</p>
        <?php else: ?>
            <div class="row">
                <?php foreach ($favoris as $produit): ?>
                    <div class="col-md-4 mb-4">
                        <div class="card h-100">
                            <img src="images/<?= htmlspecialchars($produit['images']) ?>"
                                 alt="<?= htmlspecialchars($produit['nom']) ?>"
                                 class="img-fluid product-image"
                                 style="max-width: 300px; height: auto;">
                            <div class="card-body">
                                <h5 class="card-title"><?= htmlspecialchars($produit['nom']) ?></h5>
                                <p class="card-text"><?= htmlspecialchars($produit['description']) ?></p>
                                <p class="card-text"><strong>Prix :</strong> <?= number_format($produit['prix'], 2, ',', ' ') ?> €</p>
                                <a href="produit.php?id=<?= htmlspecialchars($produit['id_produits']) ?>"
                                   class="btn btn-primary btn-sm fs-6">
                                    Voir le produit
                                </a>
                                <a href="supprimer_favoris.php?id=<?= htmlspecialchars($produit['id_favoris']) ?>"
                                   class="btn btn-danger btn-sm fs-6">
                                    Supprimer
                                </a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
