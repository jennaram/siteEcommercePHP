<?php
$host = 'localhost'; // Serveur MySQL
$dbname = 'techpulse2'; // Nom de la base de données
$username = 'root'; // Utilisateur MySQL (par défaut sous XAMPP)
$password = ''; // Mot de passe (vide par défaut sous XAMPP)

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Erreur de connexion : " . $e->getMessage());
}
?>
