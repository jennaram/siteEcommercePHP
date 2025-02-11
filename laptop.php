<?php include 'header.php'; ?>

<?php
// Inclure le fichier de connexion à la base de données
require_once 'db.php';

// Établir la connexion à la base de données
$db = getDBConnection(); // On récupère la connexion avec getDBConnection()

// Requête SQL pour récupérer les produits dont id_type_produits = 1 (ordinateur portables)
$sql = "SELECT * FROM produits WHERE id_type_produits = 1";
$stmt = $db->prepare($sql); // Utilisation de la connexion $db et préparation de la requête
$stmt->execute(); // Exécution de la requête
$result = $stmt->get_result(); // Récupérer les résultats

// Vérification si des produits ont été trouvés
if ($result->num_rows > 0) {
    echo "<div class='container my-4'>";
    echo "<div class='row'>";
    
    // Boucle pour afficher chaque produit
    while ($row = $result->fetch_assoc()) {
        echo "<div class='col-md-4'>";
        echo "<div class='card' style='width: 18rem;'>";
        echo "<img src='path_to_image.jpg' class='card-img-top' alt='Image du produit'>"; // Remplace "path_to_image.jpg" par le chemin de l'image de ton produit
        echo "<div class='card-body'>";
        echo "<h5 class='card-title'>" . htmlspecialchars($row["nom_produit"]) . "</h5>";
        echo "<p class='card-text'>" . htmlspecialchars($row["description"]) . "</p>";
        echo "<p><strong>Prix:</strong> " . htmlspecialchars($row["prix"]) . " €</p>";
        echo "<a href='#' class='btn btn-primary'>Voir plus</a>"; // Lien vers la page produit (à adapter)
        echo "</div>";
        echo "</div>";
        echo "</div>";
    }
    
    echo "</div>"; // Fermeture de la row
    echo "</div>"; // Fermeture de la container
} else {
    // Si aucun produit n'est trouvé
    echo "<p>Aucun produit trouvé.</p>";
}

// Fermer la connexion
$db->close();
?>
