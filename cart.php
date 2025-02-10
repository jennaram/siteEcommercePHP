<?php include 'header.php'; ?> <!-- Inclure l'entête -->

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Lien vers le CSS Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <title>Panier - Site Marchand</title>
</head>
<body>

    <!-- Contenu principal du panier -->
    <div class="container my-5">
        <div class="row">
            <div class="col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-4">
                    <h1 class="h3">Panier</h1>
                    <button class="btn btn-outline-secondary">Sign in</button>
                </div>
                
                <!-- Article dans le panier -->
                <div class="card mb-4">
                    <div class="card-body">
                        <div class="row align-items-center">
                            <div class="col-md-3">
                                <img src="macbook-image.jpg" alt="MacBook Pro" class="img-fluid">
                            </div>
                            <div class="col-md-9">
                                <h5 class="card-title">MacBook Pro Touch Bar 16" Retina (2019) - Core i7</h5>
                                <p class="card-text mb-1">2.6 GHz 512 SSD - 16 Go</p>
                                <p class="card-text mb-3">AZERTY - Français</p>
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <p class="h4 mb-0">1399,99€</p>
                                        <small class="text-muted">Quantité : 1</small>
                                    </div>
                                    <a href="#" class="modify-link">Modifier / Supprimer</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Résumé de la commande -->
            <div class="col-lg-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title mb-4">TOTAL</h5>
                        <div class="d-flex justify-content-between mb-3">
                            <span>Sous-total</span>
                            <span>1399,99€</span>
                        </div>
                        <div class="d-flex justify-content-between mb-4">
                            <span>Livraison</span>
                            <span>FREE</span>
                        </div>
                        <button class="btn btn-success w-100 mb-3">Paiement</button>
                        <div class="text-center payment-icons">
                            <img src="images/visa.png" alt="Visa" style="height: 30px; margin: 0 5px;">
                            <img src="images/mastercard.png" alt="Mastercard" style="height: 30px; margin: 0 5px;">
                            <img src="images/paypal.png" alt="PayPal" style="height: 30px; margin: 0 5px;">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <?php include 'footer.php'; ?> <!-- Inclure le pied de page -->

    <!-- Lien vers le JavaScript Bootstrap (doit être placé avant la fermeture de la balise </body>) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
