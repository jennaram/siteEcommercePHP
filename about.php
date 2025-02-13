<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>À propos de nous</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <style>
        /* Styles personnalisés (facultatif) */
        
    
    </style>
</head>
<body>

    <div class="promo-banner" id="promoBanner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h1 class="fw-bold">Qui sommes-nous ?</h1>
                    <p class="lead">Techpulse, votre destination en ligne pour les dernières innovations technologiques.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="container mt-5">

        <div class="row">
            <div class="col-md-8 mx-auto">
                <section class="mb-4">
                    <h3>Bienvenue chez TechPulse</h3>
                    <p>Votre destination en ligne pour les dernières innovations technologiques. Spécialisés dans la vente de <strong>smartphones</strong>, <strong>ordinateurs portables</strong> et <strong>tablettes</strong>, nous nous engageons à vous offrir une expérience d'achat simple, rapide et sécurisée.</p>
                </section>

                <section class="mb-4">
                    <h3>Notre mission</h3>
                    <p>Chez TechPulse, nous croyons que la technologie doit être accessible à tous. Notre mission est de vous proposer des produits de haute qualité, aux prix compétitifs, tout en vous accompagnant dans chaque étape de votre achat. Que vous soyez un passionné de technologie ou un utilisateur occasionnel, nous avons ce qu'il vous faut.</p>
                </section>

                <section class="mb-4">
                    <h3>Notre histoire</h3>
                    <p>TechPulse a été fondé en 2023 par une équipe de passionnés de technologie, déterminés à révolutionner l'expérience d'achat en ligne. Depuis nos débuts, nous avons construit une relation de confiance avec nos clients en leur offrant des produits innovants, un service client exceptionnel et une livraison rapide.</p>
                </section>

                <section class="mb-4">
                    <h3>Pourquoi choisir TechPulse ?</h3>
                    
                        <li><strong>Large sélection de produits</strong> : Découvrez les dernières marques et modèles de smartphones, ordinateurs portables et tablettes.</li>
                        <li><strong>Prix compétitifs</strong> : Profitez de promotions exclusives et de prix imbattables.</li>
                        <li><strong>Service client dédié</strong> : Notre équipe est à votre écoute pour répondre à toutes vos questions.</li>
                        <li><strong>Livraison rapide et sécurisée</strong> : Recevez vos produits en un temps record, où que vous soyez.</li>
                        <li><strong>Garantie et SAV</strong> : Bénéficiez d'une garantie sur tous nos produits et d'un service après-vente réactif.</li>
                    
                </section>

                <section class="mb-4">
                    <h3>Notre engagement</h3>
                    <p>Chez TechPulse, nous nous engageons à :</p>
                   
                        <li><strong>Respecter vos données</strong> : Votre vie privée est notre priorité. Nous utilisons les dernières technologies pour protéger vos informations personnelles.</li>
                        <li><strong>Promouvoir l'innovation</strong> : Nous sélectionnons soigneusement nos produits pour vous offrir le meilleur de la technologie.</li>
                        <li><strong>Contribuer à un avenir durable</strong> : Nous nous efforçons de réduire notre impact environnemental en optimisant nos emballages et en encourageant le recyclage des appareils électroniques.</li>
                  
                </section>

                <section class="mb-4">
                    <h3>Rejoignez la communauté TechPulse</h3>
                    <p>Suivez-nous sur les réseaux sociaux pour ne rien manquer de nos actualités, promotions et conseils technologiques. Ensemble, faisons battre le pouls de la technologie !</p>
                </section>

                <hr>

                <section class="mb-4">
                    <h3>Notre équipe</h3>
                    <p>Derrière TechPulse se cache une équipe dynamique et passionnée, prête à vous accompagner dans vos achats. Nous sommes fiers de vous offrir une expérience client exceptionnelle et de vous aider à trouver le produit qui correspond parfaitement à vos besoins.</p>
                </section>
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
       document.addEventListener("DOMContentLoaded", function () {
    const darkModeSwitch = document.getElementById('darkModeSwitch');
    const navbar = document.getElementById('navbar');

    // Appliquer le bon thème au chargement
    if (localStorage.getItem('darkMode') === 'true') {
        document.documentElement.setAttribute('data-bs-theme', 'dark');
        navbar.classList.replace('navbar-light', 'navbar-dark');
        navbar.classList.replace('bg-light', 'bg-dark');
        darkModeSwitch.checked = true;
    }

    // Gestion du changement de mode
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