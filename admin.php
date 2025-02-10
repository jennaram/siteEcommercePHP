<?php
include 'db.php'; // Connexion à la base de données

// Ajouter un produit
if (isset($_POST['add_product'])) {
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_FILES['image']['name'];

    // Vérifier si l'image a bien été uploadée
    if (move_uploaded_file($_FILES['image']['tmp_name'], 'uploads/' . $image)) {
        // Insérer le produit dans la base de données
        $stmt = $pdo->prepare("INSERT INTO products (name, description, price, image) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $description, $price, $image]);
    } else {
        echo "Erreur lors de l'upload de l'image.";
    }
}

// Supprimer un produit
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];

    // Récupérer l'image du produit avant de le supprimer
    $stmt = $pdo->prepare("SELECT image FROM products WHERE id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch();
    $imagePath = 'uploads/' . $product['image'];

    // Supprimer le produit de la base de données
    $stmt = $pdo->prepare("DELETE FROM products WHERE id = ?");
    $stmt->execute([$id]);

    // Supprimer l'image du serveur si elle existe
    if (file_exists($imagePath)) {
        unlink($imagePath);
    }
}

// Récupérer tous les produits
$stmt = $pdo->query("SELECT * FROM products");
$products = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page Admin - Gestion des Produits</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="text-center mb-4">Gestion des Produits</h2>

    <!-- Formulaire pour ajouter un produit -->
    <div class="mb-4">
        <h4>Ajouter un Nouveau Produit</h4>
        <form action="admin.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="name" class="form-label">Nom du Produit</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" required></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Prix (€)</label>
                <input type="number" class="form-control" id="price" name="price" step="0.01" required>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Image</label>
                <input type="file" class="form-control" id="image" name="image" required>
            </div>
            <button type="submit" name="add_product" class="btn btn-primary">Ajouter le produit</button>
        </form>
    </div>

    <!-- Liste des produits -->
    <h4>Liste des Produits</h4>
    <table class="table table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Nom</th>
                <th>Description</th>
                <th>Prix</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($products as $product): ?>
                <tr>
                    <td><img src="uploads/<?php echo htmlspecialchars($product['image']); ?>" alt="Image" width="100"></td>
                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                    <td><?php echo htmlspecialchars($product['description']); ?></td>
                    <td><?php echo number_format($product['price'], 2, ',', ''); ?> €</td>
                    <td>
                        <a href="admin.php?delete=<?php echo $product['id']; ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?');">Supprimer</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>