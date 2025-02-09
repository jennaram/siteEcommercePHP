<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Se connecter</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Styles de base */
        .form-container {
            max-width: 600px;
            margin: auto;
            padding: 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link {
            color: #495057;
            transition: all 0.3s ease;
        }

        .nav-tabs .nav-link.active {
            font-weight: bold;
        }

        /* Styles pour le mode sombre */
        [data-bs-theme="dark"] {
            background-color: #212529;
            color: white;
        }

        [data-bs-theme="dark"] .form-control {
            background-color: #343a40;
            color: white;
            border-color: #6c757d;
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: #bbb;
        }

        [data-bs-theme="dark"] .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }

        [data-bs-theme="dark"] .btn-primary:hover {
            background-color: #0b5ed7;
            border-color: #0b5ed7;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link {
            color: #fff;
        }

        [data-bs-theme="dark"] .nav-tabs .nav-link.active {
            background-color: #343a40;
            color: white;
            border-color: #6c757d;
        }
    </style>
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Espace client</h1>
    
    <!-- Onglets -->
    <ul class="nav nav-tabs justify-content-center mb-4" id="clientTabs" role="tablist">
        <li class="nav-item" role="presentation">
            <button class="nav-link active" id="login-tab" data-bs-toggle="tab" data-bs-target="#login" type="button" role="tab">Se connecter</button>
        </li>
        <li class="nav-item" role="presentation">
            <button class="nav-link" id="register-tab" data-bs-toggle="tab" data-bs-target="#register" type="button" role="tab">Créer un compte</button>
        </li>
    </ul>

    <!-- Contenu des onglets -->
    <div class="tab-content" id="clientTabsContent">
        <!-- Onglet Connexion -->
        <div class="tab-pane fade show active" id="login" role="tabpanel">
            <div class="form-container">
                <form action="submit_login.php" method="POST">
                    <div class="mb-3">
                        <label for="username" class="form-label">Identifiant</label>
                        <input type="text" class="form-control" id="username" name="username" required>
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mot de passe</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Se connecter</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Onglet Inscription -->
        <div class="tab-pane fade" id="register" role="tabpanel">
            <div class="form-container">
                <form action="submit_register.php" method="POST">
                    <!-- Informations personnelles -->
                    <h4 class="mb-3">Informations personnelles</h4>
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="firstname" class="form-label">Prénom</label>
                            <input type="text" class="form-control" id="firstname" name="firstname" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="lastname" class="form-label">Nom</label>
                            <input type="text" class="form-control" id="lastname" name="lastname" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="phone" class="form-label">Téléphone</label>
                        <input type="tel" class="form-control" id="phone" name="phone" required>
                    </div>

                    <!-- Adresse -->
                    <h4 class="mb-3">Adresse</h4>
                    <div class="mb-3">
                        <label for="address" class="form-label">Rue</label>
                        <input type="text" class="form-control" id="address" name="address" required>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="postal_code" class="form-label">Code postal</label>
                            <input type="text" class="form-control" id="postal_code" name="postal_code" required>
                        </div>
                        <div class="col-md-8 mb-3">
                            <label for="city" class="form-label">Ville</label>
                            <input type="text" class="form-control" id="city" name="city" required>
                        </div>
                    </div>

                    <!-- Informations de connexion -->
                    <h4 class="mb-3">Informations de connexion</h4>
                    <div class="mb-3">
                        <label for="new_username" class="form-label">Identifiant</label>
                        <input type="text" class="form-control" id="new_username" name="new_username" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="new_password" class="form-label">Mot de passe</label>
                            <input type="password" class="form-control" id="new_password" name="new_password" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirm_password" class="form-label">Confirmer le mot de passe</label>
                            <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
                        </div>
                    </div>

                    <div class="mb-3 form-check">
                        <input type="checkbox" class="form-check-input" id="terms" name="terms" required>
                        <label class="form-check-label" for="terms">J'accepte les conditions générales d'utilisation</label>
                    </div>

                    <div class="text-center">
                        <button type="submit" class="btn btn-primary">Créer mon compte</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour le mode sombre -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeSwitch = document.getElementById('darkModeSwitch');

        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            darkModeSwitch.checked = true;
        }

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
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Script pour le mode sombre -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeSwitch = document.getElementById('darkModeSwitch');

        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            darkModeSwitch.checked = true;
        }

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

<!-- Script pour les validations JavaScript -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        // Sélection des éléments du formulaire
        const newPassword = document.getElementById('new_password');
        const confirmPassword = document.getElementById('confirm_password');
        const passwordError = document.createElement('div');
        passwordError.className = 'invalid-feedback';
        newPassword.parentNode.appendChild(passwordError);

        const confirmPasswordError = document.createElement('div');
        confirmPasswordError.className = 'invalid-feedback';
        confirmPassword.parentNode.appendChild(confirmPasswordError);

        // Fonction pour vérifier la complexité du mot de passe
        function validatePassword(password) {
            const regex = /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/;
            return regex.test(password);
        }

        // Écouteur d'événement pour le champ "Mot de passe"
        newPassword.addEventListener('input', function () {
            if (!validatePassword(newPassword.value)) {
                newPassword.classList.add('is-invalid');
                passwordError.textContent = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
            } else {
                newPassword.classList.remove('is-invalid');
                passwordError.textContent = "";
            }
        });

        // Écouteur d'événement pour le champ "Confirmer le mot de passe"
        confirmPassword.addEventListener('input', function () {
            if (confirmPassword.value !== newPassword.value) {
                confirmPassword.classList.add('is-invalid');
                confirmPasswordError.textContent = "Les mots de passe ne correspondent pas.";
            } else {
                confirmPassword.classList.remove('is-invalid');
                confirmPasswordError.textContent = "";
            }
        });

        // Validation du formulaire avant soumission
        const registerForm = document.querySelector('form[action="submit_register.php"]');
        registerForm.addEventListener('submit', function (event) {
            if (!validatePassword(newPassword.value)) {
                event.preventDefault();
                newPassword.classList.add('is-invalid');
                passwordError.textContent = "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial.";
            }

            if (confirmPassword.value !== newPassword.value) {
                event.preventDefault();
                confirmPassword.classList.add('is-invalid');
                confirmPasswordError.textContent = "Les mots de passe ne correspondent pas.";
            }
        });
    });
</script>


<?php include 'footer.php'; ?>
</body>
</html>