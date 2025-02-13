<?php
// Fonction pour se connecter à la base de données
function getDBConnection() {
    $host = 'localhost';
    $dbname = 'techpulse2';  // Remplacez par votre base de données
    $username = 'root';  // Remplacez par votre nom d'utilisateur DB
    $password = '';  // Remplacez par votre mot de passe DB

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        die("Erreur de connexion à la base de données : " . $e->getMessage());
    }
}
?>