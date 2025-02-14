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
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        error_log("Erreur de connexion à la base de données : " . $e->getMessage());
        header("Location: error.php"); // Redirige vers une page d'erreur
        exit();
    }
}
?>