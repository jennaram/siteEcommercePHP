<?php
// Activer l'affichage des erreurs pour le débogage
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrer la session
session_start();

// Inclure le fichier de connexion à la base de données
include 'db.php';

// Vérifier si l'utilisateur est déjà connecté
if (isset($_SESSION['id_users'])) {
    // Vérifier la réception du paramètre redirect
    if (isset($_GET['redirect'])) {
        // Rediriger vers la page de redirection si elle est spécifiée
        header("Location: " . htmlspecialchars($_GET['redirect']));
        exit;
    } else {
        // Rediriger vers la page d'accueil par défaut
        header("Location: index.php");
        exit;
    }
}

// Traitement du formulaire de connexion
$erreur = '';
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['login'])) {
        // Connexion
        $email = $_POST['email'] ?? '';
        $mot_de_passe = $_POST['mot_de_passe'] ?? '';

        // Valider les informations de connexion
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute([':email' => $email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($mot_de_passe, $user['mot_de_passe'])) {
            // Connexion réussie
            $_SESSION['id_users'] = $user['id_users'];
            $_SESSION['nom'] = $user['nom'];
            $_SESSION['prenom'] = $user['prenom'];
            $_SESSION['admin'] = $user['admin']; // Ajouter le statut admin à la session

            // Vérifier la redirection après connexion
            if (isset($_GET['redirect'])) {
                header("Location: " . htmlspecialchars($_GET['redirect']));
                exit;
            } else {
                // Sinon, rediriger vers la page d'accueil par défaut
                header("Location: index.php");
                exit;
            }
        } else {
            // Échec de la connexion
            $erreur = "Email ou mot de passe incorrect.";
        }
    } elseif (isset($_POST['register'])) {
        // Inscription
        $email = $_POST['email_register'] ?? '';
        $mot_de_passe = $_POST['mot_de_passe_register'] ?? '';
        $nom = $_POST['nom'] ?? '';
        $prenom = $_POST['prenom'] ?? '';

        // Valider les données
        if (empty($email) || empty($mot_de_passe) || empty($nom) || empty($prenom)) {
            $erreur = "Tous les champs sont obligatoires.";
        } else {
            // Vérifier si l'email est déjà utilisé
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
            $stmt->execute([':email' => $email]);
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($user) {
                // Si l'utilisateur existe déjà, on le connecte directement
                $_SESSION['id_users'] = $user['id_users'];
                $_SESSION['nom'] = $user['nom'];
                $_SESSION['prenom'] = $user['prenom'];
                $_SESSION['admin'] = $user['admin'];

                // Message de validation
                $_SESSION['message'] = "Vous êtes déjà inscrit. Bienvenue, " . $user['prenom'] . " !";
                header("Location: index.php");
                exit;
            } else {
                // Hasher le mot de passe
                $mot_de_passe_hash = password_hash($mot_de_passe, PASSWORD_DEFAULT);

                // Insérer le nouvel utilisateur dans la base de données
                $stmt = $pdo->prepare("
                    INSERT INTO users (email, mot_de_passe, nom, prenom, telephone, adresse, code_postal, ville, identifiant, admin)
                    VALUES (:email, :mot_de_passe, :nom, :prenom, '', '', '', '', '', 0)
                ");
                $stmt->execute([
                    ':email' => $email,
                    ':mot_de_passe' => $mot_de_passe_hash,
                    ':nom' => $nom,
                    ':prenom' => $prenom
                ]);

                // Récupérer l'ID de l'utilisateur nouvellement créé
                $id_users = $pdo->lastInsertId();

                // Créer la session pour l'utilisateur
                $_SESSION['id_users'] = $id_users;
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['admin'] = 0; // Par défaut, l'utilisateur n'est pas admin

                // Message de validation
                $_SESSION['message'] = "Compte créé avec succès ! Bienvenue, " . $prenom . ".";

                // Vérifier la redirection après inscription
                if (isset($_GET['redirect'])) {
                    header("Location: " . htmlspecialchars($_GET['redirect']));
                    exit;
                } else {
                    // Sinon, rediriger vers la page d'accueil par défaut
                    header("Location: index.php");
                    exit;
                }
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion / Inscription</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Connexion / Inscription</h1>

    <!-- Onglets -->
    <ul class="nav nav-tabs justify-content-center mb-4" id="myTab" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab" aria-controls="login" aria-selected="true">Connexion</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab" aria-controls="register" aria-selected="false">Créer un compte</button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="myTabContent">
        <!-- Onglet Connexion -->
        <div class="tab-pane fade show active" id="login" role="tabpanel" aria-labelledby="login-tab">
            <div class="form-container">
                <?php if (isset($erreur)) : ?>
                    <div class="alert alert-danger"><?= $erreur ?></div>
                <?php endif; ?>
                <form method="POST" action="user.php<?= isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>">
                    <input type="hidden" name="login" value="1">
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mot_de_passe" class="form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Se connecter</button>
                </form>
            </div>
        </div>

        <!-- Onglet Inscription -->
        <div class="tab-pane fade" id="register" role="tabpanel" aria-labelledby="register-tab">
            <div class="form-container">
                <?php if (isset($erreur)) : ?>
                    <div class="alert alert-danger"><?= $erreur ?></div>
                <?php endif; ?>
                <form method="POST" action="user.php<?= isset($_GET['redirect']) ? '?redirect=' . urlencode($_GET['redirect']) : '' ?>">
                    <input type="hidden" name="register" value="1">
                    <div class="mb-3">
                        <label for="email_register" class="form-label">Email</label>
                        <input type="email" name="email_register" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="mot_de_passe_register" class="form-label">Mot de passe</label>
                        <input type="password" name="mot_de_passe_register" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nom" class="form-label">Nom</label>
                        <input type="text" name="nom" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="prenom" class="form-label">Prénom</label>
                        <input type="text" name="prenom" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>

    <!-- Déconnexion -->
    <?php if (isset($_SESSION['id_users'])) : ?>
        <form action="logout.php" method="POST">
            <button type="submit" class="btn btn-danger w-100 mt-4">Déconnexion</button>
        </form>
    <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
