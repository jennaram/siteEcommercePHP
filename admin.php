<?php
session_start();

// Vérifiez que l'utilisateur est un administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 1) {
    header("Location: index.php"); // Redirige l'utilisateur s'il n'est pas admin
    exit();
}

include 'db.php'; // Inclure le fichier de connexion à la base de données

// Recherche des produits
$produits = [];
$searchProduit = '';
if (isset($_POST['search_produit'])) {
    $searchProduit = $_POST['search_produit'];
    $stmt = $pdo->prepare("SELECT * FROM produits WHERE nom LIKE :nom LIMIT 10");
    $stmt->execute([':nom' => '%' . $searchProduit . '%']);
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT * FROM produits LIMIT 10");
    $stmt->execute();
    $produits = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Recherche des utilisateurs
$users = [];
$searchUser = '';
if (isset($_POST['search_user'])) {
    $searchUser = $_POST['search_user'];
    $stmt = $pdo->prepare("SELECT * FROM users WHERE nom LIKE :nom OR prenom LIKE :prenom LIMIT 10");
    $stmt->execute([':nom' => '%' . $searchUser . '%', ':prenom' => '%' . $searchUser . '%']);
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
    $stmt = $pdo->prepare("SELECT * FROM users LIMIT 10");
    $stmt->execute();
    $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Ajouter un produit
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_product'])) {
    $nom = $_POST['nom'] ?? '';
    $prix = $_POST['prix'] ?? '';
    $description = $_POST['description'] ?? '';
    $image = $_FILES['image']['name'] ?? '';
    $tmp_image = $_FILES['image']['tmp_name'] ?? '';
    $id_marques = $_POST['id_marques'] ?? '';
    $id_type_produits = $_POST['id_type_produits'] ?? '';
    $promos = $_POST['promos'] ?? '';

    if ($tmp_image) {
        $image_path = 'uploads/' . $image;
        move_uploaded_file($tmp_image, $image_path);
    } else {
        $image_path = '';
    }

    // Insertion du produit
    $stmt = $pdo->prepare("
        INSERT INTO produits (nom, prix, description, images, id_marques, id_type_produits, promos)
        VALUES (:nom, :prix, :description, :images, :id_marques, :id_type_produits, :promos)
    ");
    $stmt->execute([
        ':nom' => $nom,
        ':prix' => $prix,
        ':description' => $description,
        ':images' => $image_path,
        ':id_marques' => $id_marques,
        ':id_type_produits' => $id_type_produits,
        ':promos' => $promos,
    ]);
    $message = "Produit ajouté avec succès!";
}

// Ajouter une promotion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_promo'])) {
    $id_produit = $_POST['id_produit'] ?? '';
    $nom_promo = $_POST['nom_promo'] ?? '';

    // Insertion de la promotion
    $stmt = $pdo->prepare("
        UPDATE produits SET promos = :nom_promo WHERE id_produits = :id_produit
    ");
    $stmt->execute([
        ':nom_promo' => $nom_promo,
        ':id_produit' => $id_produit,
    ]);
    $messagePromo = "Promotion ajoutée avec succès!";
}

?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Produits et Utilisateurs</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container my-5">
        <h1 class="text-center mb-4">Gestion des Produits et des Utilisateurs</h1>

        <!-- Barre de recherche pour les produits -->
        <form method="POST" action="admin.php" class="mb-4">
            <input type="text" name="search_produit" class="form-control" placeholder="Rechercher un produit par nom" value="<?= $searchProduit ?>">
        </form>

        <h3>Liste des Produits</h3>
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($produits as $produit) : ?>
                    <tr>
                        <td><?= $produit['id_produits'] ?></td>
                        <td><?= $produit['nom'] ?></td>
                        <td><?= $produit['prix'] ?> €</td>
                        <td>
                            <?php if ($produit['images']) : ?>
                                <img src="<?= $produit['images'] ?>" alt="Image" style="width: 100px; height: 100px;">
                            <?php else : ?>
                                <p>Aucune image</p>
                            <?php endif; ?>
                        </td>
                        <td>
                            <form method="POST" action="admin_modifier_produit.php">
                                <input type="hidden" name="id_produit" value="<?= $produit['id_produits'] ?>">
                                <button type="submit" class="btn btn-warning">Modifier</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Ajouter un produit -->
        <h3>Ajouter un produit</h3>
        <?php if (isset($message)) : ?>
            <div class="alert alert-success"><?= $message ?></div>
        <?php endif; ?>
        <form method="POST" action="admin.php" enctype="multipart/form-data" class="mb-4">
            <input type="hidden" name="add_product" value="1">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom du produit</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prix" class="form-label">Prix</label>
                <input type="number" step="0.01" name="prix" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea name="description" class="form-control" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image du produit</label>
                <input type="file" name="image" class="form-control" accept="image/*" required>
            </div>
            <div class="mb-3">
                <label for="id_marques" class="form-label">Marque</label>
                <input type="text" name="id_marques" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="id_type_produits" class="form-label">Type de produit</label>
                <input type="text" name="id_type_produits" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="promos" class="form-label">Promotion</label>
                <input type="text" name="promos" class="form-control" placeholder="Entrez la promotion">
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Produit</button>
        </form>

        <!-- Ajouter une promotion -->
        <h3>Ajouter une promotion</h3>
        <?php if (isset($messagePromo)) : ?>
            <div class="alert alert-success"><?= $messagePromo ?></div>
        <?php endif; ?>
        <form method="POST" action="admin.php" class="mb-4">
            <input type="hidden" name="add_promo" value="1">
            <div class="mb-3">
                <label for="id_produit" class="form-label">Sélectionner un produit</label>
                <select name="id_produit" class="form-control" required>
                    <?php foreach ($produits as $produit) : ?>
                        <option value="<?= $produit['id_produits'] ?>"><?= $produit['nom'] ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="mb-3">
                <label for="nom_promo" class="form-label">Nom de la promotion</label>
                <input type="text" name="nom_promo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Promotion</button>
        </form>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
