<?php
error_reporting(E_ALL);  // Affiche toutes les erreurs
ini_set('display_errors', 1);  // Affiche les erreurs à l'écran

// Connexion à la base de données
function getDBConnection() {
    $host = 'localhost'; // Remplace avec tes valeurs
    $dbname = 'techpulse2'; // Change avec le nom réel de ta base de données
    $username = 'root';
    $password = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}
?>
