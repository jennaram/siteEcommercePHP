<?php
// submit_register.php

// 1. Connexion à la base de données (à adapter avec vos informations)
$servername = "localhost"; // Nom du serveur (généralement localhost)
$username = "nom_utilisateur"; // Votre nom d'utilisateur de la base de données
$password = "mot_de_passe"; // Votre mot de passe de la base de données
$dbname = "nom_de_la_base"; // Le nom de votre base de données

try {
    $conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    echo "Erreur de connexion à la base de données: " . $e->getMessage();
    exit; // Arrêter l'exécution du script en cas d'erreur de connexion
}

// 2. Récupération des données du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $postal_code = $_POST['postal_code'];
    $city = $_POST['city'];
    $new_username = $_POST['new_username'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $terms = isset($_POST['terms']) ? 1 : 0; // 1 si coché, 0 sinon

    // 3. Validation des données (à améliorer et personnaliser)
    $errors = [];

    if (empty($firstname) || empty($lastname) || empty($email) || empty($new_username) || empty($new_password) || empty($confirm_password) || empty($address) || empty($postal_code) || empty($city) || empty($phone)) {
        $errors[] = "Tous les champs sont requis.";
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "L'adresse email n'est pas valide.";
    }

    if ($new_password !== $confirm_password) {
        $errors[] = "Les mots de passe ne correspondent pas.";
    }

    // Ajoutez ici d'autres validations nécessaires (par exemple, complexité du mot de passe, format du code postal, etc.)

    if (!empty($errors)) {
        // Afficher les erreurs (vous pouvez les retourner en JSON pour les gérer côté client)
        foreach ($errors as $error) {
            echo $error . "<br>"; // Ou les stocker dans une session et les afficher sur la page de formulaire
        }
        exit; // Arrêter l'exécution du script en cas d'erreurs
    }

    // 4. Hashage du mot de passe (IMPORTANT pour la sécurité)
    $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

    // 5. Insertion des données dans la base de données
    try {
        $stmt = $conn->prepare("INSERT INTO utilisateurs (firstname, lastname, email, phone, address, postal_code, city, username, password, terms) 
                              VALUES (:firstname, :lastname, :email, :phone, :address, :postal_code, :city, :username, :password, :terms)");
        $stmt->execute([
            ':firstname' => $firstname,
            ':lastname' => $lastname,
            ':email' => $email,
            ':phone' => $phone,
            ':address' => $address,
            ':postal_code' => $postal_code,
            ':city' => $city,
            ':username' => $new_username,
            ':password' => $hashed_password,
            ':terms' => $terms
        ]);

        echo "Inscription réussie. Vous pouvez maintenant vous connecter.";

    } catch(PDOException $e) {
        echo "Erreur lors de l'inscription: " . $e->getMessage();
    }

} else {
    echo "Méthode non autorisée."; // Si la requête n'est pas de type POST
}

// 6. Fermeture de la connexion
$conn = null;

?>