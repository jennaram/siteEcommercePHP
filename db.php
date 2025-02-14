<?php
function getDBConnection() {
    $host = 'localhost'; // Adresse du serveur de base de données
    $dbname = 'techpulse2'; // Nom de la base de données
    $username = 'root'; // Nom d'utilisateur de la base de données
    $password = ''; // Mot de passe de la base de données

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    } catch (PDOException $e) {
        echo "Erreur de connexion : " . $e->getMessage();
        return null;
    }
}
?>