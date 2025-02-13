<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Vérifier si l'utilisateur est administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] != 1) {
    header("Location: index.php"); // Rediriger si ce n'est pas un admin
    exit;
}

// Inclure la connexion à la base de données
include 'db.php';

// Gérer l'ajout de produit
if (isset($_POST['add_product'])) {
    $nom = $_POST['nom'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $id_marques = $_POST['id_marques'] ?? '';
    $id_type_produits = $_POST['id_type_produits'] ?? '';
    $nombre_ventes = $_POST['nombre_ventes'] ?? '';
    $description = $_POST['description'] ?? '';
    $images = $_FILES['images']['name'] ?? ''; // gestion de l'image
    $promos = $_POST['promos'] ?? '';

    // Déplacer l'image téléchargée vers un dossier "images"
    if ($images) {
        move_uploaded_file($_FILES['images']['tmp_name'], 'images/' . $images);
    }

    // Vérifier que les champs sont remplis
    if ($nom && $prix && $id_marques && $id_type_produits && $nombre_ventes && $description && $images) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("INSERT INTO produits (nom, prix, id_marques, id_type_produits, nombre_ventes, description, images, promos) VALUES (:nom, :prix, :id_marques, :id_type_produits, :nombre_ventes, :description, :images, :promos)");
        $stmt->execute([
            ':nom' => $nom,
            ':prix' => $prix,
            ':id_marques' => $id_marques,
            ':id_type_produits' => $id_type_produits,
            ':nombre_ventes' => $nombre_ventes,
            ':description' => $description,
            ':images' => $images,
            ':promos' => $promos
        ]);
    }
}

// Gérer la suppression de produit
if (isset($_GET['delete_product'])) {
    $id_produits = $_GET['delete_product'];
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id_produits = :id_produits");
    $stmt->execute([':id_produits' => $id_produits]);
}

?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Gestion Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Page d'Administration</h1>

    <!-- Section Produits -->
    <h2>Gérer les Produits</h2>
    <form method="POST" action="admin.php" enctype="multipart/form-data">
        <div class="mb-3">
            <label for="nom" class="form-label">Nom du Produit</label>
            <input type="text" name="nom" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="prix" class="form-label">Prix</label>
            <input type="number" name="prix" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="id_marques" class="form-label">Marque</label>
            <input type="text" name="id_marques" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="id_type_produits" class="form-label">Type de Produit</label>
            <input type="text" name="id_type_produits" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="nombre_ventes" class="form-label">Nombre de Ventes</label>
            <input type="number" name="nombre_ventes" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="description" class="form-label">Description</label>
            <textarea name="description" class="form-control" required></textarea>
        </div>
        <div class="mb-3">
            <label for="images" class="form-label">Image</label>
            <input type="file" name="images" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="promos" class="form-label">Promotion (%)</label>
            <input type="number" name="promos" class="form-control">
        </div>
        <button type="submit" name="add_product" class="btn btn-primary">Ajouter le produit</button>
    </form>

    <!-- Liste des Produits -->
    <h3>Liste des Produits</h3>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nom</th>
                <th>Prix</th>
                <th>Marque</th>
                <th>Type de Produit</th>
                <th>Ventes</th>
                <th>Description</th>
                <th>Image</th>
                <th>Promotion</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $pdo = getDBConnection();
            $stmt = $pdo->query("SELECT * FROM produits");
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>";
                echo "<td>" . $row['id_produits'] . "</td>";
                echo "<td>" . $row['nom'] . "</td>";
                echo "<td>" . $row['prix'] . "€</td>";
                echo "<td>" . $row['id_marques'] . "</td>";
                echo "<td>" . $row['id_type_produits'] . "</td>";
                echo "<td>" . $row['nombre_ventes'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td><img src='images/" . $row['images'] . "' alt='image' style='width: 100px;'></td>";
                echo "<td>" . ($row['promos'] ? $row['promos'] . "%" : 'Aucune') . "</td>";
                echo "<td><a href='admin.php?delete_product=" . $row['id_produits'] . "' class='btn btn-danger'>Supprimer</a></td>";
                echo "</tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
