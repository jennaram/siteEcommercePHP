<?php
session_start();
require_once 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $pdo = getDBConnection();
    
    $nom = htmlspecialchars($_POST['nom']);
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $message = htmlspecialchars($_POST['message']);
    
    if (!empty($nom) && !empty($email) && !empty($message)) {
        try {
            $stmt = $pdo->prepare("INSERT INTO contacts (nom, email, message) VALUES (:nom, :email, :message)");
            $success = $stmt->execute([
                'nom' => $nom,
                'email' => $email,
                'message' => $message
            ]);
            
            if ($success) {
                echo "success";
            } else {
                echo "Erreur lors de l'enregistrement";
            }
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
        }
    } else {
        echo "Veuillez remplir tous les champs.";
    }
    exit();
}
?>