<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = $_POST['new_username'];
    $mot_de_passe = password_hash($_POST['new_password'], PASSWORD_DEFAULT);
    $email = $_POST['email'];
    $admin = isset($_POST['admin']) ? 1 : 0; // Option pour les super-admins

    $stmt = $pdo->prepare("INSERT INTO users (identifiant, mot_de_passe, email, admin) VALUES (?, ?, ?, ?)");
    if ($stmt->execute([$identifiant, $mot_de_passe, $email, $admin])) {
        echo "Compte créé avec succès.";
        header("Location: user.php");
    } else {
        echo "Erreur lors de l'inscription.";
    }
}
?>
