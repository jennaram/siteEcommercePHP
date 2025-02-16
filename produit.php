<?php
session_start();
include 'db.php';

// Vérifier si l'ID est présent dans l'URL
if (!isset($_GET['id'])) {
    header('Location: index.php');
    exit;
}

$id = (int)$_GET['id'];
// Vérifier si on vient de la page promo
$showPromo = isset($_GET['promo']) && $_GET['promo'] == 1;

// Récupérer la connexion à la base de données
$pdo = getDBConnection();

// Requête SQL pour récupérer les informations du produit
$sql = "SELECT p.*, m.nom_marque
        FROM produits p
        JOIN marques m ON p.id_marques = m.id_marque
        WHERE p.id_produits = :id";

$stmt = $pdo->prepare($sql);
$stmt->execute(['id' => $id]);
$produit = $stmt->fetch(PDO::FETCH_ASSOC);

// Si le produit n'existe pas, rediriger vers la page d'accueil
if (!$produit) {
    header('Location: index.php');
    exit;
}

// Calculer le prix avec la promotion UNIQUEMENT si on vient de la page promo
$prixFinal = ($showPromo && $produit['promos'] > 0)
    ? $produit['prix'] * (1 - $produit['promos']/100)
    : $produit['prix'];

// Récupérer les commentaires associés au produit
$stmt = $pdo->prepare("
    SELECT c.*, u.nom, u.prenom
    FROM commentaires c
    JOIN users u ON c.id_users = u.id_users
    WHERE c.id_produits = :id_produit
    ORDER BY c.date_creation DESC
");
$stmt->execute([':id_produit' => $id]);
$commentaires = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Vérifier si l'utilisateur est connecté
$utilisateur_connecte = isset($_SESSION['id_users']);

// Si l'utilisateur essaie de soumettre un commentaire sans être connecté
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !$utilisateur_connecte) {
    // Rediriger vers la page de connexion avec un paramètre pour revenir à cette page
    header("Location: user.php?redirect=produit.php?id=" . $id);
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($produit['nom']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-6">
                <img src="images/<?= htmlspecialchars($produit['images']) ?>"
                     alt="<?= htmlspecialchars($produit['nom']) ?>"
                     class="img-fluid"
                     style="max-width: 300px; height: auto;">
            </div>
            <div class="col-md-6">
                <div class="product-details">
                    <h1><?= htmlspecialchars($produit['nom']) ?></h1>
                    <!-- Icône Favoris -->
                    <div class="d-flex align-items-center mb-3">
                        <a href="ajouter_favoris.php?id=<?= htmlspecialchars($produit['id_produits']) ?>" class="btn btn-link p-0">
                            <i class="bi bi-heart fs-3 text-danger"></i>
                        </a>
                    </div>
                    <?php if ($showPromo && $produit['promos'] > 0): ?>
                        <div class="promo-badge">
                            <span class="badge bg-danger">-<?= htmlspecialchars($produit['promos']) ?>%</span>
                        </div>
                    <?php endif; ?>

                    <p><?= htmlspecialchars($produit['description']) ?></p>
                    <p><strong>Marque :</strong> <?= htmlspecialchars($produit['nom_marque']) ?></p>

                    <div class="price-info">
                        <?php if ($showPromo && $produit['promos'] > 0): ?>
                            <span class="original-price text-decoration-line-through text-muted">
                                <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                            </span>
                            <span class="promo-price text-danger fw-bold">
                                <?= number_format($prixFinal, 2, ',', ' ') ?> €
                            </span>
                            <i class="bi bi-gift promo-icon"></i>
                        <?php else: ?>
                            <span class="regular-price">
                                <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                            </span>
                        <?php endif; ?>
                    </div>

                    <a href="ajouter_panier.php?id=<?= htmlspecialchars($produit['id_produits']) ?>" class="btn btn-success ms-2">Ajouter au panier</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Section des commentaires -->
    <div class="mt-5">
        <h3>Commentaires des utilisateurs</h3>
        <?php if (empty($commentaires)) : ?>
            <p>Aucun commentaire pour ce produit.</p>
        <?php else : ?>
            <?php foreach ($commentaires as $commentaire) : ?>
                <div class="card mb-3">
                    <div class="card-body">
                        <h5 class="card-title">
                            <?= htmlspecialchars($commentaire['prenom'] . ' ' . $commentaire['nom']) ?>
                            <small class="text-muted">
                                (Noté : <?= htmlspecialchars($commentaire['notation']) ?>/5)
                            </small>
                        </h5>
                        <p class="card-text"><?= htmlspecialchars($commentaire['messages']) ?></p>
                        <p class="text-muted">
                            <small>
                                Posté le <?= date('d/m/Y à H:i', strtotime($commentaire['date_creation'])) ?>
                            </small>
                        </p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Formulaire de commentaire -->
    <?php if ($utilisateur_connecte) : ?>
        <div class="container mt-5 mb-5">
            <h3>Laisser un commentaire</h3>
            <form method="POST" action="ajouter_commentaire.php">
                <input type="hidden" name="id_produit" value="<?= $id ?>">
                <div class="mb-3">
                    <label for="notation" class="form-label">Note (sur 5)</label>
                    <input type="number" name="notation" class="form-control" min="1" max="5" required>
                </div>
                <div class="mb-3">
                    <label for="message" class="form-label">Votre commentaire</label>
                    <textarea name="message" class="form-control" rows="4" required></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Envoyer</button>
            </form>
        </div>
    <?php else : ?>
        <div class="container mt-5">
            <div class="alert alert-info">
                Vous devez <a href="user.php?redirect=produit.php?id=<?= $id ?>">vous connecter</a> pour laisser un commentaire.
            </div>
        </div>
    <?php endif; ?>

    <?php include 'footer.php'; ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
