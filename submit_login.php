<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $identifiant = $_POST['username'];
    $mot_de_passe = $_POST['password'];

    $stmt = $pdo->prepare("SELECT id_users, identifiant, mot_de_passe, admin FROM users WHERE identifiant = ?");
    $stmt->execute([$identifiant]);
    $user = $stmt->fetch();

    if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
        // Stocker les informations de l'utilisateur en session
        $_SESSION['user_id'] = $user['id_users'];
        $_SESSION['identifiant'] = $user['identifiant'];
        $_SESSION['admin'] = $user['admin'];

        // Redirection selon le rôle
        if ($user['admin']) {
            header("Location: admin.php");
        } else {
            header("Location: user_dashboard.php"); // Page utilisateur
        }
        exit();
    } else {
        echo "Identifiant ou mot de passe incorrect.";
    }
}
?>
