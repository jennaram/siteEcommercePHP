<?php
session_start();
if (!isset($_SESSION['id_users']) || $_SESSION['admin'] != 1) {
    header("Location: index.php");
    exit;
}

include 'header.php';
include 'db.php';
?>

<div class="container my-5">
    <h1 class="text-center mb-4">Page Admin</h1>

    <form method="POST" action="add_product.php">
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
            <label for="id_marques" class="form-label">Marque</label>
            <select name="id_marques" class="form-control" required>
                <?php
                $pdo = getDBConnection();
                $stmt = $pdo->query("SELECT * FROM marques");
                while ($marque = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$marque['id_marque']}'>{$marque['nom_marque']}</option>";
                }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="id_type_produits" class="form-label">Type de produit</label>
            <select name="id_type_produits" class="form-control" required>
                <?php
                $stmt = $pdo->query("SELECT * FROM type_produits");
                while ($type = $stmt->fetch(PDO::FETCH_ASSOC)) {
                    echo "<option value='{$type['id_type_produits']}'>{$type['nom']}</option>";
                }
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Ajouter le produit</button>
    </form>
</div>

<?php include 'footer.php'; ?>