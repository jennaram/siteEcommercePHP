<?php include 'header.php'; ?>
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Retours</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <!-- Bandeau promotionnel -->
    <div class="promo-banner" id="promoBanner">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-12 text-center">
                    <h1 class="fw-bold">Retours & Remboursements</h1>
                    <p class="lead">Consultez notre politique de retours et de remboursements.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Contenu principal -->
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 mx-auto">

                <section class="mb-4">
                    <h3>Politique de retours</h3>
                    <p>
                        Chez TechPulse, nous comprenons que vous puissiez changer d'avis. Vous disposez de 14 jours à compter de la réception de votre commande pour retourner un article.
                    </p>
                    <ul>
                        <li>Les articles doivent être retournés dans leur état d'origine, non utilisés et avec leur emballage d'origine.</li>
                        <li>Les frais de retour sont à votre charge, sauf en cas de produit défectueux ou d'erreur de notre part.</li>
                        <li>Certains articles ne sont pas éligibles aux retours (ex : produits personnalisés, logiciels, etc.).</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h3>Comment retourner un article ?</h3>
                    <p>
                        Pour retourner un article, veuillez suivre les étapes suivantes :
                    </p>
                    <ol>
                        <li>Contactez notre service client pour obtenir un numéro de retour.</li>
                        <li>Emballez soigneusement l'article dans son emballage d'origine.</li>
                        <li>Expédiez le colis à l'adresse indiquée par notre service client.</li>
                        <li>Une fois votre retour reçu et vérifié, nous procéderons au remboursement ou à l'échange.</li>
                    </ol>
                </section>

                <section class="mb-4">
                    <h3>Remboursements</h3>
                    <p>
                        Les remboursements sont effectués dans un délai de 14 jours à compter de la réception de votre retour. Le remboursement sera crédité sur le moyen de paiement utilisé lors de l'achat.
                    </p>
                    <ul>
                        <li>En cas de retour partiel, le remboursement sera пропорционаnel aux articles retournés.</li>
                        <li>Les frais de livraison initiaux ne sont pas remboursables, sauf en cas de produit défectueux ou d'erreur de notre part.</li>
                    </ul>
                </section>

                <section class="mb-4">
                    <h3>Échanges</h3>
                    <p>
                        Si vous souhaitez échanger un article, veuillez nous contacter. Nous vous indiquerons la procédure à suivre.
                    </p>
                    <ul>
                        <li>Les échanges sont possibles dans la limite des stocks disponibles.</li>
                        <li>Si l'article de remplacement est plus cher, vous devrez payer la différence.</li>
                        <li>Si l'article de remplacement est moins cher, nous vous rembourserons la différence.</li>
                    </ul>
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