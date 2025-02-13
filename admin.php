<?php
// Démarrer la session
session_start();

// Vérifier si l'utilisateur est connecté et est un administrateur
if (!isset($_SESSION['id_users']) || $_SESSION['admin'] != 1) {
    header("Location: user.php"); // Redirection vers la page de connexion si non admin
    exit;
}

// Inclure la connexion à la base de données
include 'db.php';

// Initialiser les variables de recherche
$productSearch = '';
$userSearch = '';

// Vérifier si une recherche de produit a été soumise
if (isset($_POST['product_search'])) {
    $productSearch = $_POST['product_search'];
}

// Vérifier si une recherche d'utilisateur a été soumise
if (isset($_POST['user_search'])) {
    $userSearch = $_POST['user_search'];
}

// Récupérer les produits filtrés par nom
$pdo = getDBConnection();
$produitsStmt = $pdo->prepare("SELECT * FROM produits WHERE nom LIKE :search");
$produitsStmt->execute([':search' => '%'.$productSearch.'%']);
$produits = $produitsStmt->fetchAll(PDO::FETCH_ASSOC);

// Récupérer les utilisateurs filtrés par nom
$usersStmt = $pdo->prepare("SELECT * FROM users WHERE nom LIKE :search");
$usersStmt->execute([':search' => '%'.$userSearch.'%']);
$users = $usersStmt->fetchAll(PDO::FETCH_ASSOC);

// Gestion des modifications de produits
if (isset($_GET['edit_product'])) {
    $editProductId = $_GET['edit_product'];
    $editProductStmt = $pdo->prepare("SELECT * FROM produits WHERE id_produits = :id_produits");
    $editProductStmt->execute([':id_produits' => $editProductId]);
    $productToEdit = $editProductStmt->fetch(PDO::FETCH_ASSOC);
}

// Mise à jour des produits
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_product'])) {
    // Récupérer les informations du produit modifié
    $productId = $_POST['id_produits'];
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $nombre_ventes = $_POST['nombre_ventes'];
    $description = $_POST['description'];
    $image = $_POST['images']; // Image si besoin d'un changement

    // Mise à jour du produit dans la base de données
    $updateStmt = $pdo->prepare("UPDATE produits SET nom = :nom, prix = :prix, nombre_ventes = :nombre_ventes, description = :description, images = :images WHERE id_produits = :id_produits");
    $updateStmt->execute([
        ':nom' => $nom,
        ':prix' => $prix,
        ':nombre_ventes' => $nombre_ventes,
        ':description' => $description,
        ':images' => $image,
        ':id_produits' => $productId
    ]);

    // Redirection pour éviter la soumission multiple de formulaire
    header("Location: admin.php");
    exit;
}

// Ajouter un produit
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['add_product'])) {
    $nom = $_POST['nom'];
    $prix = $_POST['prix'];
    $nombre_ventes = $_POST['nombre_ventes'];
    $description = $_POST['description'];
    $image = $_POST['images']; // Si vous voulez utiliser une image, il faudra l'ajouter ici.

    // Insertion du produit dans la base de données
    $insertStmt = $pdo->prepare("INSERT INTO produits (nom, prix, nombre_ventes, description, images) VALUES (:nom, :prix, :nombre_ventes, :description, :images)");
    $insertStmt->execute([
        ':nom' => $nom,
        ':prix' => $prix,
        ':nombre_ventes' => $nombre_ventes,
        ':description' => $description,
        ':images' => $image,
    ]);

    // Redirection après ajout du produit
    header("Location: admin.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Admin - Produits et Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Gestion des Produits et des Utilisateurs</h1>

        <!-- Formulaire pour ajouter un produit -->
        <h2>Ajouter un Produit</h2>
        <form method="POST" action="admin.php">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du Produit</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" name="prix" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nombre_ventes" class="form-label">Nombre de Ventes</label>
                <input type="number" name="nombre_ventes" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required></textarea>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Image (URL)</label>
                <input type="text" name="images" class="form-control" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-success">Ajouter le produit</button>
        </form>

        <hr>

        <!-- Recherche des produits -->
        <h2>Recherche des Produits</h2>
        <form method="POST" action="admin.php">
            <div class="mb-3">
                <label for="product_search" class="form-label">Rechercher par nom</label>
                <input type="text" name="product_search" class="form-control" value="<?= htmlspecialchars($productSearch) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <hr>

        <!-- Liste des Produits -->
        <h2>Liste des Produits</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Nombre de Ventes</th>
                    <th>Description</th>
                    <th>Image</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit): ?>
                <tr>
                    <td><?= htmlspecialchars($produit['nom']) ?></td>
                    <td><?= htmlspecialchars($produit['prix']) ?> €</td>
                    <td><?= htmlspecialchars($produit['nombre_ventes']) ?></td>
                    <td><?= htmlspecialchars($produit['description']) ?></td>
                    <td>
                        <img src="images/<?= htmlspecialchars($produit['images']) ?>" alt="<?= htmlspecialchars($produit['nom']) ?>" width="100">
                    </td>
                    <td>
                        <a href="admin.php?edit_product=<?= $produit['id_produits'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Formulaire de modification -->
        <?php if (isset($productToEdit)): ?>
        <h2>Modifier le Produit</h2>
        <form method="POST" action="admin.php">
            <input type="hidden" name="id_produits" value="<?= $productToEdit['id_produits'] ?>">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du Produit</label>
                <input type="text" name="nom" class="form-control" value="<?= htmlspecialchars($productToEdit['nom']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="text" name="prix" class="form-control" value="<?= htmlspecialchars($productToEdit['prix']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="nombre_ventes" class="form-label">Nombre de Ventes</label>
                <input type="number" name="nombre_ventes" class="form-control" value="<?= htmlspecialchars($productToEdit['nombre_ventes']) ?>" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($productToEdit['description']) ?></textarea>
            </div>
            <div class="mb-3">
                <label for="images" class="form-label">Image (URL)</label>
                <input type="text" name="images" class="form-control" value="<?= htmlspecialchars($productToEdit['images']) ?>" required>
            </div>
            <button type="submit" name="update_product" class="btn btn-primary">Mettre à jour le produit</button>
        </form>
        <?php endif; ?>

        <hr>

        <!-- Recherche des utilisateurs -->
        <h2>Recherche des Utilisateurs</h2>
        <form method="POST" action="admin.php">
            <div class="mb-3">
                <label for="user_search" class="form-label">Rechercher par nom</label>
                <input type="text" name="user_search" class="form-control" value="<?= htmlspecialchars($userSearch) ?>">
            </div>
            <button type="submit" class="btn btn-primary">Rechercher</button>
        </form>

        <hr>

        <!-- Liste des Utilisateurs -->
        <h2>Liste des Utilisateurs</h2>
        <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Rôle</th>
                    <th>Modifier</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= htmlspecialchars($user['id_users']) ?></td>
                    <td><?= htmlspecialchars($user['nom']) ?></td>
                    <td><?= htmlspecialchars($user['email']) ?></td>
                    <td><?= $user['admin'] == 1 ? 'Admin' : 'Utilisateur' ?></td>
                    <td>
                        <a href="admin.php?edit_user=<?= $user['id_users'] ?>" class="btn btn-warning btn-sm">Modifier</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
