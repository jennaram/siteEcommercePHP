<?php
session_start();

// Vérifiez que l'utilisateur est un administrateur
if (!isset($_SESSION['admin']) || $_SESSION['admin'] !== 1) {
    header("Location: index.php"); // Redirige l'utilisateur s'il n'est pas admin
    exit();
}

include 'db.php'; // Inclure le fichier de connexion à la base de données

// Initialiser la connexion à la base de données
$pdo = getDBConnection();

// Gestion des produits
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
        // Utiliser le dossier 'images/'
        $image_path = 'images/' . $image;
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

// Supprimer un produit
if (isset($_GET['delete_product'])) {
    $id_produit = $_GET['delete_product'];
    $stmt = $pdo->prepare("DELETE FROM produits WHERE id_produits = :id_produit");
    $stmt->execute([':id_produit' => $id_produit]);
    header("Location: admin.php"); // Recharger la page après suppression
    exit();
}

// Gestion des utilisateurs
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

// Ajouter un utilisateur ou admin
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_user'])) {
    $nom = $_POST['nom'] ?? '';
    $prenom = $_POST['prenom'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hasher le mot de passe
    $is_admin = isset($_POST['is_admin']) ? 1 : 0;

    // Vérifier si l'email existe déjà
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
    $stmt->execute([':email' => $email]);
    if ($stmt->fetchColumn() > 0) {
        $messageUser = "Cet email existe déjà!";
    } else {
        // Insertion de l'utilisateur
        $stmt = $pdo->prepare("
            INSERT INTO users (nom, prenom, email, password, admin)
            VALUES (:nom, :prenom, :email, :password, :admin)
        ");
        $stmt->execute([
            ':nom' => $nom,
            ':prenom' => $prenom,
            ':email' => $email,
            ':password' => $password,
            ':admin' => $is_admin
        ]);
        $messageUser = "Utilisateur ajouté avec succès!";
    }
}

// Supprimer un utilisateur
if (isset($_GET['delete_user'])) {
    $id_user = $_GET['delete_user'];
    $stmt = $pdo->prepare("DELETE FROM users WHERE id_users = :id_user");
    $stmt->execute([':id_user' => $id_user]);
    header("Location: admin.php"); // Recharger la page après suppression
    exit();
}

// Ajouter une promotion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['add_promo'])) {
    $id_produit = $_POST['id_produit'] ?? '';
    $nom_promo = $_POST['nom_promo'] ?? '';

    // Mise à jour de la promotion
    $stmt = $pdo->prepare("UPDATE produits SET promos = :nom_promo WHERE id_produits = :id_produit");
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
    <!-- Barre de navigation avec bouton de déconnexion -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Admin Panel</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="btn btn-danger" href="index.php">Quitter l'admin</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <h1 class="text-center mb-4">Gestion des Produits et des Utilisateurs</h1>

        <!-- Section Gestion des Produits -->
        <h2>Gestion des Produits</h2>

        <!-- Barre de recherche pour les produits -->
        <form method="POST" action="admin.php" class="mb-4">
            <input type="text" name="search_produit" class="form-control" placeholder="Rechercher un produit par nom" value="<?= $searchProduit ?>">
        </form>

        <!-- Liste des Produits -->
        <h3>Liste des Produits</h3>
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Prix</th>
                    <th>Image</th>
                    <th>Promotion</th>
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
                            <?php if (!empty($produit['images'])) : ?>
                                <img src="images/<?= $produit['images'] ?>" alt="Image du produit" style="width: 100px; height: 100px;">
                            <?php else : ?>
                                <p>Aucune image disponible</p>
                            <?php endif; ?>
                        </td>
                        <td><?= $produit['promos'] ?? 'Aucune' ?></td>
                        <td>
                            <a href="admin_modifier_produit.php?id=<?= $produit['id_produits'] ?>" class="btn btn-warning">Modifier</a>
                            <a href="admin.php?delete_product=<?= $produit['id_produits'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
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
                <label for="id_produit" class="form-label">ID Produit</label>
                <input type="number" name="id_produit" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nom_promo" class="form-label">Nom de la promotion</label>
                <input type="text" name="nom_promo" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-success">Ajouter Promotion</button>
        </form>

        <!-- Section Gestion des Utilisateurs -->
        <h2>Gestion des Utilisateurs</h2>

        <!-- Barre de recherche pour les utilisateurs -->
        <form method="POST" action="admin.php" class="mb-4">
            <input type="text" name="search_user" class="form-control" placeholder="Rechercher un utilisateur par nom ou prénom" value="<?= $searchUser ?>">
        </form>

        <!-- Liste des Utilisateurs -->
        <h3>Liste des Utilisateurs</h3>
        <table class="table table-bordered mb-4">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Email</th>
                    <th>Type</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) : ?>
                    <tr>
                        <td><?= $user['id_users'] ?></td>
                        <td><?= $user['nom'] ?> <?= $user['prenom'] ?></td>
                        <td><?= $user['email'] ?></td>
                        <td><?= $user['admin'] == 1 ? 'Administrateur' : 'Utilisateur' ?></td>
                        <td>
                            <a href="admin_modifier_user.php?id=<?= $user['id_users'] ?>" class="btn btn-warning">Modifier</a>
                            <a href="admin.php?delete_user=<?= $user['id_users'] ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')">Supprimer</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

        <!-- Ajouter un utilisateur -->
        <h3>
        <!-- Ajouter un utilisateur -->
        <h3>Ajouter un utilisateur</h3>
        <?php if (isset($messageUser)) : ?>
            <div class="alert alert-success"><?= $messageUser ?></div>
        <?php endif; ?>
        <form method="POST" action="admin.php" class="mb-4">
            <input type="hidden" name="add_user" value="1">
            <div class="mb-3">
                <label for="nom" class="form-label">Nom</label>
                <input type="text" name="nom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="prenom" class="form-label">Prénom</label>
                <input type="text" name="prenom" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Mot de passe</label>
                <input type="password" name="password" class="form-control" required>
            </div>
            <div class="mb-3 form-check">
                <input type="checkbox" name="is_admin" class="form-check-input" id="is_admin">
                <label class="form-check-label" for="is_admin">Compte administrateur</label>
            </div>
            <button type="submit" class="btn btn-primary">Ajouter Utilisateur</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>