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
   html, body {
      height: 100%; /* Utiliser 100% pour html et body */
      margin: 0;
    }

    body {
      display: flex;
      flex-direction: column;
      min-height: 100vh; /* S'assurer que le body couvre toute la hauteur de la vue */
    }

    .content {
      flex: 1 0 auto; /* Clé : Permettre au contenu de croître, mais pas de rétrécir en dessous de la taille du contenu */
    }

    .footer {
      background-color: #A6C8D1;
      color: #fff;
      padding: 20px 0;
      width: 100%;
      
    }

    .footer a {
      color: #fff;
      text-decoration: none;
    }

    .footer a:hover {
      text-decoration: underline;
    }

    .footer .footer-section ul li {
      margin-bottom: 0.5rem;
    }

    .footer-section {
  padding: 1.5rem 0;
  margin-bottom: 1rem;
}

    .footer-section h5 {
      margin-bottom: 20px;
    }

    .codingfactory-logo {
      width: 150px;
      height: auto;
      display: block;
      margin: 0 auto;
    }

    .linkedin-icon {
      font-size: 30px;
      color: #0077b5;
      margin: 10px;
    }

    .linkedin-icon:hover {
      color: #006097;
    }

    .linkedin-container {
      display: flex;
      justify-content: center;
      gap: 30px;
    }

    .footer-main-content {
      display: flex;
      justify-content: space-between;
      width: 100%;
      max-width: 1000px;
      margin-bottom: 10px;
      flex-wrap: wrap;
    }

    .footer-2025 {
    text-align: center; 
    width: 100%;
    padding: 1rem;
    margin-top: 20px;
}

    /* Styles pour les petits écrans */
    @media (max-width: 768px) 
      .footer-main-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }

      .footer-section {
        padding: 1rem 0;
      }

      .codingfactory-logo {
        width: 120px; /* Réduire la taille du logo */
      }

      .linkedin-container {
        flex-direction: column;
        gap: 10px;
      }

      .linkedin-icon {
        font-size: 24px; /* Réduire la taille des icônes */
      }

      @media (max-width: 768px) {
    .footer-2025 {
        margin-top: 15px;
        padding: 0.75rem;
    }
}

      @media (max-width: 576px) {
    .footer-2025 {
        margin-top: 10px;
        padding: 0.5rem;
        font-size: 0.9rem;
    }
}
  </style>
</head>
<body>
  <div class="content">
  </div>

  <footer class="footer">
    <div class="container">
      <div class="footer-main-content">
        <!-- Section Services -->
        <div class="footer-section">
          <h5>Services</h5>
          <ul class="list-unstyled">
            <li class="mb-1"><a href="about.php">Qui sommes-nous ?</a></li>
            <li class="mb-1"><a href="help.php">Aide et assistance</a></li>
            <li class="mb-1"><a href="contact.php">Contact</a></li>
          </ul>
        </div>

        <!-- Section Logo CodingFactory -->
        <div class="footer-section">
          <a href="https://www.codingfactory.fr" target="_blank">
            <img src="images/logo-coding.png" alt="Logo CodingFactory" class="codingfactory-logo">
          </a>
        </div>

        <!-- Section Suivez-nous -->
<div class="footer-section text-center">
  <h5 class="mb-3">Suivez-nous</h5>
  <div class="d-flex justify-content-center align-items-center flex-wrap gap-4">
    <div class="social-item">
      <a href="https://www.linkedin.com/in/jennabenufferamia/" target="_blank" 
         class="d-flex flex-column align-items-center text-decoration-none">
        <i class="bi bi-linkedin linkedin-icon mb-2"></i>
        <span>Jenna</span>
      </a>
    </div>
    <div class="social-item">
      <a href="https://www.linkedin.com/in/alexandre-fourquin-5ba470187/" target="_blank"
         class="d-flex flex-column align-items-center text-decoration-none">
        <i class="bi bi-linkedin linkedin-icon mb-2"></i>
        <span>Alexandre</span>
      </a>
    </div>
  </div>
</div>

      <!-- Section 2025 TechPulse -->
      <div class="footer-2025 w-100 text-center mt-4 py-3">
    <h5 class="mb-0">© 2025 TechPulse</h5>
</div>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>