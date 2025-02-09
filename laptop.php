<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>index</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Styles de base */
        .promo-banner {
            background-color: #BEA6D1;
            color: black;
            transition: background-color 0.3s, color 0.3s;
        }

        .promo-button {
            background-color: #FDD835;
            border-color: #FDD835;
            color: black;
            transition: background-color 0.3s, color 0.3s;
        }

        .content-section-wrapper {
            transition: background-color 0.3s, color 0.3s;
            padding: 3rem 0;  /* Ajoute de l'espace vertical */
        }

        footer {
            transition: background-color 0.3s, color 0.3s;
        }

        /* Styles pour le mode sombre */
        [data-bs-theme="dark"] {
            background-color: #212529;
            color: white;
        }

        [data-bs-theme="dark"] .navbar {
            background-color: #343a40 !important;
        }

        [data-bs-theme="dark"] .nav-link {
            color: white !important;
        }

        [data-bs-theme="dark"] .form-control {
            background-color: #495057;
            color: white;
            border-color: #6c757d;
        }

        [data-bs-theme="dark"] .form-control::placeholder {
            color: #bbb;
        }

        [data-bs-theme="dark"] .btn-outline-secondary {
            border-color: white;
            color: white;
        }

        [data-bs-theme="dark"] .btn-outline-secondary:hover {
            background-color: white;
            color: black;
        }

        /* Styles spécifiques pour le bandeau promo en mode sombre */
        [data-bs-theme="dark"] .promo-banner {
            background-color: #3d322f;
            color: white;
        }

        [data-bs-theme="dark"] .promo-button {
            background-color: #b39b00;
            border-color: #b39b00;
            color: white;
        }

        /* Styles pour le contenu principal en mode sombre */
        [data-bs-theme="dark"] .content-section-wrapper {
            background-color: #343a40;
            color: white;
        }

        [data-bs-theme="dark"] .content-section h1,
        [data-bs-theme="dark"] .content-section p {
            color: white;
        }

        /* Styles pour le footer en mode sombre */
        [data-bs-theme="dark"] footer {
            background-color: #343a40;
            color: white;
        }

        [data-bs-theme="dark"] footer a {
            color: #fff;
        }

        [data-bs-theme="dark"] footer a:hover {
            color: #FDD835;
        }
    </style>
</head>
<body>
    <!-- Bandeau promotionnel -->
    <div class="promo-banner py-4">
        <div class="container">
            <div class="row align-items-center">
            <div class="col-md-6 text-start">
                <h1 class="fw-bold" style="font-size: 1.8rem; white-space: nowrap;">Découvrez nos PC & Macbook</h1>
                <p class="lead" style="font-size: 1.1rem; white-space: nowrap;">Profitez de nos offres exclusives sur une large sélection de produits.</p>
                <a href="promo.php" class="btn btn-lg" style="background-color: #FDD835; border-color: #FDD835; color: black;">
                    Découvrir nos offres
                </a>
                </div>
                <div class="col-md-6 text-end">
                    <img src="images/pc portables.png" alt="PC portables" class="img-fluid rounded" style="max-width: 40%; height: auto;">
                </div>
            </div>
        </div>
    </div>

    <!-- Paragraphe supplémentaire -->
    <div class="content-section-wrapper">
        <div class="container content-section">
            <h1>Nos PC & Macbook</h1>
            <p style="font-size: 1.1rem; text-align: center; justify;">
                Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent euismod, sapien ut vehicula dignissim, 
                ligula mi cursus quam, nec dictum mi libero eget arcu. Nullam auctor ex in lorem aliquet, at facilisis sapien pretium. 
                Integer nec sapien in nisl facilisis placerat a et orci. Aenean vitae augue at lacus ultrices sodales. 
            </p>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const darkModeSwitch = document.getElementById('darkModeSwitch');
            const navbar = document.getElementById('navbar');

            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
                navbar.classList.replace('navbar-light', 'navbar-dark');
                navbar.classList.replace('bg-light', 'bg-dark');
                darkModeSwitch.checked = true;
            }

            darkModeSwitch.addEventListener('change', function () {
                if (this.checked) {
                    document.documentElement.setAttribute('data-bs-theme', 'dark');
                    navbar.classList.replace('navbar-light', 'navbar-dark');
                    navbar.classList.replace('bg-light', 'bg-dark');
                    localStorage.setItem('darkMode', 'true');
                } else {
                    document.documentElement.setAttribute('data-bs-theme', 'light');
                    navbar.classList.replace('navbar-dark', 'navbar-light');
                    navbar.classList.replace('bg-dark', 'bg-light');
                    localStorage.setItem('darkMode', 'false');
                }
            });
        });
    </script>
</body>
</html>
<?php include 'footer.php'; ?>