<?php
// Activer l'affichage des erreurs
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Récupérer la connexion à la base de données
$pdo = getDBConnection();
if (!$pdo) {
    die("Impossible de se connecter à la base de données.");
}

// Récupération de la requête de recherche
$searchQuery = isset($_GET['query']) ? trim($_GET['query']) : '';

// Initialisation des variables
$results = [];
$error = null;

if (!empty($searchQuery)) {
    try {
        // Préparation de la requête SQL avec FULLTEXT
        $searchTerm = $searchQuery; // Utilisation directe de la valeur
        $sql = "SELECT 
                    id_produits AS id,
                    nom AS title,
                    description,
                    prix AS price,
                    images
                FROM produits 
                WHERE nom LIKE :search OR description LIKE :search
                    
                LIMIT 20"; // Limite des résultats

        $stmt = $pdo->prepare($sql);
        $stmt->bindValue(':search', "%$searchTerm%", PDO::PARAM_STR);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
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
    <?php include 'header.php'; // Inclure votre header ?>

    <div class="container my-4">
        <h1>Résultats de recherche pour "<?php echo htmlspecialchars($searchQuery); ?>"</h1>

        <?php if (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php elseif (empty($searchQuery)): ?>
            <div class="alert alert-info">Veuillez entrer un terme de recherche.</div>
        <?php elseif (empty($results)): ?>
            <div class="alert alert-info">Aucun résultat trouvé pour votre recherche.</div>
        <?php else: ?>
            <div class="row row-cols-1 row-cols-md-3 g-4">
                <?php foreach ($results as $result): ?>
                    <div class="col">
                        <div class="card h-100">
                            <img src="<?php echo htmlspecialchars($result['images']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($result['title']); ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($result['title']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($result['description']); ?></p>
                                <p class="card-text">
                                    <strong>Prix : </strong><?php echo number_format($result['price'], 2, ',', ' '); ?> €
                                </p>
                                <a href="product.php?id=<?php echo $result['id']; ?>" class="btn btn-primary">Voir le produit</a>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <?php include 'footer.php'; // Inclure votre footer ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>