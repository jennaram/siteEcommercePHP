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
    // Rediriger vers la page de redirection si elle est spécifiée
    if (isset($_GET['redirect'])) {
        header("Location: " . $_GET['redirect']);
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

            // Redirection vers la page admin si l'utilisateur est un admin
            if ($_SESSION['admin'] == 1) {
                header("Location: admin.php");
                exit;
            }

            // Sinon, rediriger vers la page d'accueil par défaut
            header("Location: index.php");
            exit;
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
        $telephone = $_POST['telephone'] ?? '';
        $adresse = $_POST['adresse'] ?? '';
        $code_postal = $_POST['code_postal'] ?? '';
        $ville = $_POST['ville'] ?? '';
        $identifiant = $_POST['identifiant'] ?? '';

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

                // Insérer le nouvel utilisateur dans la base de données avec les informations supplémentaires
                $stmt = $pdo->prepare("
                    INSERT INTO users (email, mot_de_passe, nom, prenom, telephone, adresse, code_postal, ville, identifiant, admin)
                    VALUES (:email, :mot_de_passe, :nom, :prenom, :telephone, :adresse, :code_postal, :ville, :identifiant, 0)
                ");
                $stmt->execute([
                    ':email' => $email,
                    ':mot_de_passe' => $mot_de_passe_hash,
                    ':nom' => $nom,
                    ':prenom' => $prenom,
                    ':telephone' => $telephone,
                    ':adresse' => $adresse,
                    ':code_postal' => $code_postal,
                    ':ville' => $ville,
                    ':identifiant' => $identifiant
                ]);

                // Vérifier si l'insertion a réussi
                if ($stmt->rowCount() > 0) {
                    echo "Utilisateur inséré avec succès dans la table users.<br>";
                } else {
                    echo "Erreur lors de l'insertion dans la table users.<br>";
                }

                // Récupérer l'ID de l'utilisateur nouvellement créé
                $id_users = $pdo->lastInsertId();

                if ($id_users) {
                    echo "ID utilisateur généré : " . $id_users . "<br>";
                } else {
                    echo "Erreur : Impossible de récupérer l'ID utilisateur.<br>";
                }

                // Insérer l'id_users dans les autres tables où il est nécessaire
                try {
                    // Exemple pour une table 'user_profiles'
                    $stmt = $pdo->prepare("
                        INSERT INTO user_profiles (id_users, bio, avatar)
                        VALUES (:id_users, :bio, :avatar)
                    ");
                    $stmt->execute([
                        ':id_users' => $id_users,
                        ':bio' => '', // Valeur par défaut ou récupérée du formulaire
                        ':avatar' => '' // Valeur par défaut ou récupérée du formulaire
                    ]);

                    if ($stmt->rowCount() > 0) {
                        echo "Insertion réussie dans la table user_profiles.<br>";
                    } else {
                        echo "Erreur lors de l'insertion dans la table user_profiles.<br>";
                    }

                    // Exemple pour une table 'user_settings'
                    $stmt = $pdo->prepare("
                        INSERT INTO user_settings (id_users, notification_preference, theme)
                        VALUES (:id_users, :notification_preference, :theme)
                    ");
                    $stmt->execute([
                        ':id_users' => $id_users,
                        ':notification_preference' => 1, // Valeur par défaut
                        ':theme' => 'light' // Valeur par défaut
                    ]);

                    if ($stmt->rowCount() > 0) {
                        echo "Insertion réussie dans la table user_settings.<br>";
                    } else {
                        echo "Erreur lors de l'insertion dans la table user_settings.<br>";
                    }

                } catch (PDOException $e) {
                    // Gérer les erreurs d'insertion
                    $erreur = "Erreur lors de la création des enregistrements supplémentaires : " . $e->getMessage();
                    echo $erreur . "<br>";
                }

                // Créer la session pour l'utilisateur
                $_SESSION['id_users'] = $id_users;
                $_SESSION['nom'] = $nom;
                $_SESSION['prenom'] = $prenom;
                $_SESSION['admin'] = 0; // Par défaut, l'utilisateur n'est pas admin

                // Message de validation
                $_SESSION['message'] = "Compte créé avec succès ! Bienvenue, " . $prenom . ".";
                header("Location: index.php");
                exit;
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
                <form method="POST" action="user.php">
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
                <form method="POST" action="user.php">
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
                    <!-- Champs supplémentaires -->
                    <div class="mb-3">
                        <label for="telephone" class="form-label">Téléphone</label>
                        <input type="text" name="telephone" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="adresse" class="form-label">Adresse</label>
                        <input type="text" name="adresse" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="code_postal" class="form-label">Code Postal</label>
                        <input type="text" name="code_postal" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="ville" class="form-label">Ville</label>
                        <input type="text" name="ville" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label for="identifiant" class="form-label">Identifiant</label>
                        <input type="text" name="identifiant" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary w-100">S'inscrire</button>
                </form>
            </div>
        </div>
    </div>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>