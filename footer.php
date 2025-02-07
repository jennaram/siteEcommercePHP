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
      padding: 10px 0; /* Réduction de la hauteur du footer */
      position: relative;
      bottom: 0;
      width: 100%;
    }

    .footer a {
      color: #fff;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    /* Flexbox pour distribuer les sections également */
    .footer .footer-sections {
      display: flex;
      justify-content: space-between; /* Espacement égal entre les sections */
      align-items: center;
      flex-wrap: wrap; /* Pour la responsivité */
      padding: 0 15px; /* Espacement sur les bords */
    }

    .footer .footer-section {
      flex: 1; /* Chaque section prend une part égale de l'espace */
      text-align: center;
      margin: 10px;
    }

    .footer .footer-section h5 {
      font-size: 1.1rem;
      margin-bottom: 10px;
      font-weight: bold;
    }

    .footer .footer-section ul {
      list-style: none;
      padding: 0;
    }

    .footer .footer-section ul li {
      margin-bottom: 8px;
    }

    .footer .footer-section ul li a {
      color: #fff;
      text-decoration: none;
    }

    .footer .footer-section ul li a:hover {
      text-decoration: underline;
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

    .linkedin-item {
      display: flex;
      align-items: center;
      justify-content: center;
    }

    .linkedin-item span {
      margin-left: 10px;
      font-size: 16px;
      font-weight: 500;
    }

    /* Pour le logo CodingFactory */
    .codingfactory-logo {
      width: 100px;
      height: 80px;
      margin-top: 5px;
      margin-bottom: 5px;
    }

    .codingfactory-container {
      text-align: center;
      margin-top: 20px;
    }

    /* Responsive: Lorsque l'écran est plus petit, les sections s'empilent */
    @media (max-width: 768px) {
      .footer .footer-sections {
        flex-direction: column;
        align-items: center;
      }

      .footer .footer-section {
        margin: 15px 0;
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
    <div class="footer-sections">
      <!-- Section Copyright -->
      <div class="footer-section">
        <h5>© 2025 TechPulse</h5>
      </div>

      <!-- Section Services -->
      <div class="footer-section">
        <h5>Services</h5>
        <ul>
        <li><a href="about.php">Qui somme nous ?</a></li>
          <li><a href="help.php">Aide et assistance</a></li>
          <li><a href="livraison.php">Livraison</a></li>
          <li><a href="refund.php">Retours & remboursements</a></li>
          <li><a href="contact.php">Contact</a></li>
        </ul>
      </div>

      <!-- Section Icônes locales et LinkedIn -->
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

      <!-- Section Logo CodingFactory -->
      <div class="footer-section codingfactory-container">
        
        <!-- Logo CodingFactory -->
        <a href="https://www.codingfactory.fr" target="_blank">
          <img src="images/logo-coding.png" alt="Logo CodingFactory" class="codingfactory-logo">
        </a>
      </div>
    </div>
  </footer>

  <!-- Lien vers Bootstrap JS (facultatif mais conseillé pour certains composants interactifs) -->
  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
