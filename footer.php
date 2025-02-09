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
      height: 100vh;
      margin: 0;
      display: flex;
      flex-direction: column;
    }

    .content {
      flex: 1;
      margin-bottom: 20px;
    }

    .footer {
      background-color: #A6C8D1;
      color: #fff;
      padding: 20px 0;
      width: 100%;
      display: flex;
      flex-direction: column;
      align-items: center;
      min-height: 300px;
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
      text-align: center;
      margin-bottom: 20px;
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
      justify-content: flex-end;
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
      margin-top: 0 auto;
    }

    @media (max-width: 768px) {
      .footer-main-content {
        flex-direction: column;
        align-items: center;
        text-align: center;
      }
      .linkedin-container {
        justify-content: center;
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

        <div class="footer-section">
          <a href="https://www.codingfactory.fr" target="_blank">
            <img src="images/logo-coding.png" alt="Logo CodingFactory" class="codingfactory-logo">
          </a>
        </div>

        <div class="footer-section">
          <h5>Suivez-nous</h5>
          <div class="linkedin-container">
            <div class="linkedin-item">
              <a href="https://www.linkedin.com/in/jennabenufferamia/" target="_blank">
                <i class="bi bi-linkedin linkedin-icon"></i>
              </a>
              <span>Jenna</span>
            </div>
            <div class="linkedin-item">
              <a href="https://www.linkedin.com/in/alexandre-fourquin-5ba470187/" target="_blank">
                <i class="bi bi-linkedin linkedin-icon"></i>
              </a>
              <span>Alexandre</span>
            </div>
          </div>
        </div>
      </div>
      <div class="footer-2025">
        <h5>© 2025 TechPulse</h5>
      </div>
    </div>
  </footer>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
