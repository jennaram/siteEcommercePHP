<?php
// Définir les constantes de connexion à la base de données
define('DB_HOST', 'localhost');   // Hôte de la base de données (souvent localhost)
define('DB_USER', 'root');        // Nom d'utilisateur de la base de données
define('DB_PASSWORD', '');        // Mot de passe de la base de données
define('DB_NAME', 'techpulse2'); // Nom de la base de données

// Créer une fonction pour établir la connexion à la base de données
function getDBConnection() {
    try {
        // Créer une instance de PDO (PHP Data Objects) pour la connexion à la base de données
        $pdo = new PDO('mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8', DB_USER, DB_PASSWORD);

        // Définir le mode d'erreur de PDO pour lancer des exceptions en cas d'erreur
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        // Retourner l'objet PDO
        return $pdo;
    } catch (PDOException $e) {
        // Si une exception est lancée (erreur de connexion), afficher un message d'erreur
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>
