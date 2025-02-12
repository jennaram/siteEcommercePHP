<?php
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
?>

<!-- Dans la partie HTML où vous affichez les informations du produit -->
<div class="product-details">
    <h1><?= htmlspecialchars($produit['nom']) ?></h1>
    
    <!-- Afficher le badge promotion uniquement si on vient de la page promo -->
    <?php if ($showPromo && $produit['promos'] > 0): ?>
    <div class="promo-badge">
        <span class="badge bg-danger">-<?= htmlspecialchars($produit['promos']) ?>%</span>
    </div>
    <?php endif; ?>

    <img src="images/<?= htmlspecialchars($produit['images']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>">
    
    <div class="product-info">
        <p><?= htmlspecialchars($produit['description']) ?></p>
        <p><strong>Marque :</strong> <?= htmlspecialchars($produit['nom_marque']) ?></p>
        
        <!-- Affichage du prix avec promotion uniquement si on vient de la page promo -->
        <div class="price-info">
            <?php if ($showPromo && $produit['promos'] > 0): ?>
                <p>
                    <span class="original-price text-decoration-line-through text-muted">
                        <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                    </span>
                    <span class="promo-price text-danger fw-bold">
                        <?= number_format($prixFinal, 2, ',', ' ') ?> €
                    </span>
                </p>
            <?php else: ?>
                <p class="regular-price">
                    <?= number_format($produit['prix'], 2, ',', ' ') ?> €
                </p>
            <?php endif; ?>
        </div>
        
        <!-- Ajoutez ici vos boutons d'action (ajouter au panier, etc.) -->
    </div>
</div>