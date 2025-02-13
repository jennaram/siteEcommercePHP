<?php
session_start();

// À mettre au début de chaque page admin
function checkAdmin() {
    if (!isset($_SESSION['id_users']) || $_SESSION['admin'] != 1) {
        header("Location: index.php");
        exit;
    }
}

// Vérification si l'utilisateur est connecté et est admin
if (!isset($_SESSION['id_users']) || $_SESSION['admin'] != 1) {
    // Si non admin ou non connecté, redirection vers l'index
    header("Location: index.php");
    exit;
}

include 'header.php';
include 'db.php';

// Récupération de la connexion à la base de données
$pdo = getDBConnection();
?>

<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administration - TechPulse</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h2 class="mb-0">
                            <i class="bi bi-gear-fill me-2"></i>
                            Panneau d'administration
                        </h2>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <!-- Menu d'administration -->
                            <div class="col-md-3">
                                <div class="list-group">
                                    <a href="#" class="list-group-item list-group-item-action active">
                                        <i class="bi bi-speedometer2 me-2"></i>Tableau de bord
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-box-seam me-2"></i>Gestion des produits
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-people me-2"></i>Gestion des utilisateurs
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-cart4 me-2"></i>Gestion des commandes
                                    </a>
                                    <a href="#" class="list-group-item list-group-item-action">
                                        <i class="bi bi-tag me-2"></i>Gestion des promotions
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Contenu principal -->
                            <div class="col-md-9">
                                <div class="row">
                                    <!-- Statistiques rapides -->
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-primary text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="bi bi-cart-check me-2"></i>
                                                    Commandes du jour
                                                </h5>
                                                <h2 class="card-text">25</h2>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-success text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="bi bi-currency-euro me-2"></i>
                                                    Chiffre du jour
                                                </h5>
                                                <h2 class="card-text">2,450 €</h2>
                                            </div>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4 mb-4">
                                        <div class="card bg-info text-white">
                                            <div class="card-body">
                                                <h5 class="card-title">
                                                    <i class="bi bi-people-fill me-2"></i>
                                                    Nouveaux clients
                                                </h5>
                                                <h2 class="card-text">12</h2>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Dernières actions -->
                                <div class="card mb-4">
                                    <div class="card-header">
                                        <h5 class="mb-0">Dernières actions</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead>
                                                    <tr>
                                                        <th>Date</th>
                                                        <th>Action</th>
                                                        <th>Utilisateur</th>
                                                        <th>Détails</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>13/02/2025 14:30</td>
                                                        <td>Nouvelle commande</td>
                                                        <td>Jean Dupont</td>
                                                        <td>Commande #12345</td>
                                                    </tr>
                                                    <tr>
                                                        <td>13/02/2025 14:15</td>
                                                        <td>Modification produit</td>
                                                        <td>Admin</td>
                                                        <td>iPhone 15 Pro</td>
                                                    </tr>
                                                    <tr>
                                                        <td>13/02/2025 14:00</td>
                                                        <td>Nouveau client</td>
                                                        <td>Marie Martin</td>
                                                        <td>Inscription</td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

<?php include 'footer.php'; ?>