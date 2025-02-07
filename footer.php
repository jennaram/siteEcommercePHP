<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Footer Marchand</title>
  <!-- Lien vers Bootstrap CSS -->
  <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
  <!-- Lien vers Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    /* Style de base pour le body et la page */
    html, body {
      height: 100%;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    /* Contenu principal de la page */
    .content {
      flex: 1; /* Cela pousse le footer vers le bas */
    }

    /* Style personnalisé pour le footer */
    .footer {
      background-color: #A6C8D1;
      color: #fff;
      padding: 20px 0; /* Espacement autour du footer */
      position: relative;
      bottom: 0;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center; /* Centrer tout le contenu horizontalement */
      min-height: 300px; /* Hauteur minimale du footer */
    }

    .footer a {
      color: #fff;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    /* Section Services */
    .footer .footer-section ul li {
      margin-bottom: 0.5rem; /* Très petite marge */
    }

    /* Section "Suivez-nous" et autres éléments centrés */
    .footer-section {
      text-align: center; /* Centrer les titres */
      margin-bottom: 20px; /* Espacement entre les sections */
    }

    /* Ajouter plus de marge sous le titre "Suivez-nous" */
    .footer-section h5 {
      margin-bottom: 20px; /* Augmenter l'espacement sous le titre "Suivez-nous" */
    }

    /* Pour le logo CodingFactory */
    .codingfactory-logo {
      width: 100px;
      height: 80px;
      margin-top: 5px;
      margin-bottom: 5px;
    }

    /* Style pour les icônes LinkedIn */
    .linkedin-icon {
      font-size: 30px; /* Réduction de la taille des icônes */
      color: #0077b5;
      margin: 10px;
    }

    .linkedin-icon:hover {
      color: #006097; /* Changer la couleur au survol */
    }

    /* Conteneur des icônes LinkedIn et prénoms */
    .linkedin-container {
      display: flex;
      justify-content: center; /* Aligner les icônes LinkedIn horizontalement */
      gap: 30px; /* Espacement entre les icônes */
    }

    /* Conteneur pour les éléments principaux (Services, Suivez-nous et logo) */
    .footer-main-content {
      display: flex;
      justify-content: space-between; /* Espacement égal entre les sections */
      width: 100%;
      max-width: 1000px;
      margin-bottom: 20px;
      flex-wrap: wrap;
    }

    /* Section pour "2025 TechPulse" en bas, centré horizontalement */
    .footer-2025 {
      text-align: center;
      width: 100%; /* Prendre toute la largeur disponible */
    }

    /* Responsive : ajustement pour les petits écrans */
    @media (max-width: 768px) {
      .footer-main-content {
        flex-direction: column; /* Empiler verticalement les éléments */
        align-items: center;
        text-align: center;
      }
    }
  </style>
</head>
<body>

  <!-- Contenu principal de la page -->
  <div class="content">
    <!-- Ton contenu ici -->
  </div>

  <!-- Footer -->
  <footer class="footer">
    <div class="container">
      <!-- Conteneur principal des sections -->
      <div class="footer-main-content">
        <!-- Section Services -->
        <div class="footer-section">
          <h5>Services</h5>
          <ul class="list-unstyled">
            <li class="mb-1"><a href="about.php">Qui sommes-nous ?</a></li>
            <li class="mb-1"><a href="help.php">Aide et assistance</a></li>
            <li class="mb-1"><a href="livraison.php">Livraison</a></li>
            <li class="mb-1"><a href="refund.php">Retours & remboursements</a></li>
            <li class="mb-1"><a href="contact.php">Contact</a></li>
          </ul>
        </div>

        <!-- Section Suivez-nous -->
        <div class="footer-section">
          <h5>Suivez-nous</h5>
          <!-- Icônes LinkedIn avec prénoms -->
          <div class="linkedin-container">
            <!-- Lien LinkedIn 1 avec prénom -->
            <div class="linkedin-item">
              <a href="https://www.linkedin.com/in/jennabenufferamia/" target="_blank">
                <i class="bi bi-linkedin linkedin-icon"></i>
              </a>
              <span>Jenna</span>
            </div>
            <!-- Lien LinkedIn 2 avec prénom -->
            <div class="linkedin-item">
              <a href="https://www.linkedin.com/in/alexandre-fourquin-5ba470187/" target="_blank">
                <i class="bi bi-linkedin linkedin-icon"></i>
              </a>
              <span>Alexandre</span>
            </div>
          </div>
        </div>

        <!-- Section pour le logo CodingFactory -->
        <div class="footer-section">
          <a href="https://www.codingfactory.fr" target="_blank">
            <img src="images/logo-coding.png" alt="Logo CodingFactory" class="codingfactory-logo">
          </a>
        </div>
      </div>

      <!-- Section 2025 TechPulse en bas -->
      <div class="footer-2025">
        <h5>© 2025 TechPulse</h5>
      </div>
    </div>
  </footer>

  <!-- Lien vers Bootstrap JS (facultatif mais conseillé pour certains composants interactifs) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
