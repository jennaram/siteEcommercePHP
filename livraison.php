<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Livraison</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Styles personnalisés (facultatif) */
        body {
            font-family: sans-serif;
        }
        .container {
            max-width: 960px; /* Ajuster la largeur maximale du conteneur */
        }
        .lead {
            font-size: 1.2rem;
            font-weight: 300;
        }
        .list-style-icon li {
            position: relative;
            padding-left: 25px; /* Espacement pour l'icône */
        }
        .list-style-icon li::before {
            content: "\2022"; /* Utiliser un caractère de puce (vous pouvez le remplacer par une icône Bootstrap) */
            position: absolute;
            left: 0;
        }

        .promo-banner {
            background-color: #A6C8D1;
            color: black;
            padding: 2rem 0; /* Augmenter le padding vertical */
        }

        .promo-banner h1 {
            font-size: 2.5rem; /* Augmenter la taille du titre */
            font-weight: bold;
            margin-bottom: 0.5rem; /* Ajouter un peu d'espace en dessous du titre */
        }

        .promo-banner p.lead {
            font-size: 1.25rem; /* Augmenter la taille du slogan */
        }

        /* Styles pour le mode sombre */
        [data-bs-theme="dark"] {
            background-color: #212529; /* Couleur de fond sombre pour la page */
            color: white; /* Couleur de texte claire pour la page */
        }

        [data-bs-theme="dark"] .promo-banner {
            background-color: #343a40; /* Couleur de fond sombre pour le promo-banner */
            color: white; /* Couleur de texte claire pour le promo-banner */
        }

        [data-bs-theme="dark"] .container {
            background-color: #343a40; /* Couleur de fond sombre pour le container */
        }

        [data-bs-theme="dark"] footer {
            background-color: #343a40; /* Couleur de fond sombre pour le footer */
        }
    </style>
</head>
<body>

    <!-- Bandeau promotionnel -->
    <div class="promo-banner" id="promoBanner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h1 class="fw-bold">Livraison</h1>
                    <p class="lead">Découvrez nos options de livraison rapide et sécurisée.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">
                <!-- Section Options de livraison -->
                <section class="mb-4">
                    <h3>Options de livraison</h3>
                    <p>
                        Chez TechPulse, nous proposons plusieurs options de livraison pour répondre à vos besoins. Que vous soyez pressé ou que vous préfériez une option économique, nous avons ce qu'il vous faut.
                    </p>
                    
                        <li><strong>Livraison standard</strong> : Livraison en 3 à 5 jours ouvrés. Gratuite pour les commandes de plus de 50 €.</li>
                        <li><strong>Livraison express</strong> : Livraison en 1 à 2 jours ouvrés. Des frais supplémentaires peuvent s'appliquer.</li>
                        <li><strong>Livraison en point relais</strong> : Réceptionnez votre colis dans l'un de nos points relais partenaires.</li>
                    
                </section>

                <!-- Section Délais de livraison -->
                <section class="mb-4">
                    <h3>Délais de livraison</h3>
                    <p>
                        Nous faisons de notre mieux pour expédier vos commandes dans les plus brefs délais. Voici ce que vous devez savoir :
                    </p>
                   
                        <li>Les commandes passées avant 14h sont expédiées le jour même (hors week-ends et jours fériés).</li>
                        <li>Les délais de livraison commencent à compter de la date d'expédition.</li>
                        <li>Vous recevrez un e-mail de confirmation avec un numéro de suivi dès que votre commande sera expédiée.</li>
                 
                </section>

                <!-- Section Frais de livraison -->
                <section class="mb-4">
                    <h3>Frais de livraison</h3>
                    <p>
                        Les frais de livraison dépendent de l'option choisie et du montant de votre commande :
                    </p>
                   
                        <li><strong>Livraison standard</strong> : 4,99 € (gratuite pour les commandes de plus de 50 €).</li>
                        <li><strong>Livraison express</strong> : 9,99 €.</li>
                        <li><strong>Livraison en point relais</strong> : 2,99 €.</li>
                  
                </section>

                <!-- Section Suivi de commande -->
                <section class="mb-4">
                    <h3>Suivi de commande</h3>
                    <p>
                        Une fois votre commande expédiée, vous recevrez un e-mail contenant un numéro de suivi. Vous pouvez suivre l'état de votre livraison en temps réel en cliquant sur le lien fourni dans l'e-mail ou en vous rendant sur notre page de <a href="user.php">suivi de commande</a>.
                    </p>
                </section>

                <!-- Section Questions fréquentes -->
                <section class="mb-4">
                    <h3>Questions fréquentes</h3>
                    <p>
                        Vous avez des questions sur la livraison ? Contactez notre service client pour obtenir de l'aide.
                    </p>
                </section>

                <!-- Section Contact -->
                <section class="mb-4">
                    <h3>Besoin d'aide ?</h3>
                    <p>
                        Si vous avez des questions ou des préoccupations concernant votre livraison, n'hésitez pas à nous contacter via notre <a href="contact.php">formulaire de contact</a> ou par téléphone au <strong>01 23 45 67 89</strong>.
                    </p>
                </section>
            </div>
        </div>
    </div>

    <!-- Scripts Bootstrap -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const darkModeSwitch = document.getElementById('darkModeSwitch');

            if (localStorage.getItem('darkMode') === 'true') {
                document.documentElement.setAttribute('data-bs-theme', 'dark');
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
</body>
</html>
<?php include 'footer.php'; ?>