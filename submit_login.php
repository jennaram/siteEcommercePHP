<?php
session_start(); // Démarrer la session

// Vérifier si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupérer les données du formulaire
    $username = htmlspecialchars($_POST['username']);
    $password = htmlspecialchars($_POST['password']);

    // Valider les données (exemple simple)
    if (!empty($username) && !empty($password)) {
        // Connexion à la base de données (exemple avec MySQLi)
        $conn = new mysqli("localhost", "root", "", "nom_de_votre_base_de_donnees");

        // Vérifier la connexion
        if ($conn->connect_error) {
            die("Erreur de connexion à la base de données : " . $conn->connect_error);
        }

        // Récupérer l'utilisateur depuis la base de données
        $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        // Vérifier si l'utilisateur existe
        if ($stmt->num_rows > 0) {
            $stmt->bind_result($id, $hashed_password);
            $stmt->fetch();

            // Vérifier le mot de passe
            if (password_verify($password, $hashed_password)) {
                // Connexion réussie
                $_SESSION['user_id'] = $id; // Enregistrer l'ID de l'utilisateur en session
                header("Location: dashboard.php"); // Rediriger vers le tableau de bord
                exit();
            } else {
                echo "<p class='alert alert-danger'>Mot de passe incorrect.</p>";
            }
        } else {
            echo "<p class='alert alert-danger'>Identifiant incorrect.</p>";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "<p class='alert alert-warning'>Veuillez remplir tous les champs.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Résultat de la connexion</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styles pour le mode sombre */
        [data-bs-theme="dark"] {
            background-color: #212529;
            color: white;
        }

        [data-bs-theme="dark"] .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        [data-bs-theme="dark"] .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <div class="text-center">
        <?php if (isset($error_message)) : ?>
            <!-- Afficher un message d'erreur -->
            <div class="alert alert-danger" role="alert">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>

        <!-- Bouton "Retour à l'accueil" -->
        <a href="index.php" class="btn btn-primary">Retour à l'accueil</a>
    </div>
</div>

<!-- Script pour le mode sombre -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeSwitch = document.getElementById('darkModeSwitch');

        // Appliquer le mode sombre si activé dans le localStorage
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            darkModeSwitch.checked = true;
        }

        // Gestion du changement de mode
        darkModeSwitch.addEventListener('change', function () {
            if (this.checked) {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                localStorage.setItem('darkMode', 'true');
            } else {
                document.documentElement.setAttribute('data-bs-theme', 'light');
                localStorage.setItem('darkMode', 'false');
            }
        });
    });
</script>
</body>
</html>