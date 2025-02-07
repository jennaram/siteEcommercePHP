<?php
// Connexion à la base de données
require_once 'config/db.php'; // Assurez-vous d'avoir un fichier de configuration pour la BD

// Récupération de la requête
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

if (!empty($searchQuery)) {
    try {
        // Préparation de la requête SQL pour chercher dans différentes tables
        $sql = "SELECT 
                    'product' as type,
                    id,
                    name as title,
                    description,
                    price
                FROM products 
                WHERE 
                    name LIKE :search 
                    OR description LIKE :search
                UNION
                SELECT 
                    'category' as type,
                    id,
                    name as title,
                    description,
                    NULL as price
                FROM categories 
                WHERE 
                    name LIKE :search
                    OR description LIKE :search
                LIMIT 20"; // Limite des résultats

        $stmt = $pdo->prepare($sql);
        $searchTerm = "%{$searchQuery}%";
        $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch(PDOException $e) {
        // Gestion des erreurs
        error_log("Erreur de recherche : " . $e->getMessage());
        $error = "Une erreur est survenue lors de la recherche.";
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultats de recherche - <?php echo htmlspecialchars($searchQuery); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <?php include 'includes/header.php'; // Inclure votre header ?>

    <div class="container my-4">
        <h1>Résultats de recherche pour "<?php echo htmlspecialchars($searchQuery); ?>"</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php elseif (empty($results)): ?>
            <div class="alert alert-info">Aucun résultat trouvé pour votre recherche.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($results as $result): ?>
                    <div class="col">
                        <div class="card h-100">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($result['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($result['description']); ?></p>
                                <?php if ($result['type'] === 'product' && isset($result['price'])): ?>
                                    <p class="card-text">
                                        <strong>Prix : </strong><?php echo number_format($result['price'], 2, ',', ' '); ?> €
                                    </p>
                                    <a href="product.php?id=<?php echo $result['id']; ?>" class="btn btn-primary">Voir le produit</a>
                                <?php elseif ($result['type'] === 'category'): ?>
                                    <a href="category.php?id=<?php echo $result['id']; ?>" class="btn btn-secondary">Voir la catégorie</a>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'includes/footer.php'; // Inclure votre footer ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>