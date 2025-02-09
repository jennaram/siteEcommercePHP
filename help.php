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
<div class="promo-banner" id="promoBanner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h1 class="fw-bold">Besoin d'aide ?</h1>
                    <p class="lead">Connectez-vous pour obtenir de l'assistance sur votre commande</p>
                    <a href="user.php" class="btn btn-lg" style="background-color: #FDD835; border-color: #FDD835; color: black;">
                    Espace client
                </a>
                </div>
            </div>
        </div>
    </div>

<div class="container my-5">
   
    <!-- Accordéon Bootstrap -->
    <div class="accordion" id="helpAccordion">
        <!-- Section Aide & Assistance -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingOne">
                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                    Aide & Assistance
                </button>
            </h2>
            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#helpAccordion">
                <div class="accordion-body">
                    <p>
                        Notre équipe d'assistance est disponible pour répondre à toutes vos questions. Que vous ayez besoin d'aide pour choisir un produit, configurer un appareil ou résoudre un problème technique, nous sommes là pour vous aider. Contactez-nous par téléphone au <strong>01 23 45 67 89</strong> ou via <a href="contact.php">notre formulaire de contact en ligne</a>.
                    </p>
                </div>
            </div>
        </div>

        <!-- Section Livraison -->
        <div class="accordion-item">
            <h2 class="accordion-header" id="headingTwo">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                    Livraison
                </button>
            </h2>
            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#helpAccordion">
                <div class="accordion-body">
                    <p>
                        Nous proposons une livraison rapide et sécurisée pour tous vos produits. La plupart des commandes sont expédiées dans les 24 heures et livrées en 2 à 3 jours ouvrés. Vous pouvez suivre votre commande en temps réel grâce à notre système de suivi en ligne. Pour en savoir plus sur nos options de livraison, consultez notre <a href="livraison.php">page dédiée</a>.
                    </p>
                </div>
            </div>
        </div>

       <!-- Section Retours et remboursements -->
       <div class="accordion-item">
            <h2 class="accordion-header" id="headingThree">
                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                    Retours et remboursements
                </button>
            </h2>
            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#helpAccordion">
                <div class="accordion-body">
                    <p>
                        Si vous n'êtes pas entièrement satisfait de votre achat, vous pouvez retourner votre produit dans un délai de 30 jours pour un remboursement ou un échange. Assurez-vous que le produit est dans son emballage d'origine et en parfait état. Pour initier un retour, contactez notre service client ou suivez les instructions sur notre <a href="livraison.php">page de retours.</a> 
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<?php include 'footer.php'; ?>
