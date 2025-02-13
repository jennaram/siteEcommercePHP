<?php
// Connexion à la base de données
$host = 'localhost';  // Nom d'hôte
$dbname = 'techpulse2';  // Nom de la base de données
$username = 'root';  // Nom d'utilisateur
$password = '';  // Mot de passe

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);  // Gérer les erreurs de connexion
} catch (PDOException $e) {
    die("Erreur de connexion à la base de données : " . $e->getMessage());
}
?>
