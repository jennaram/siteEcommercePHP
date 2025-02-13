<?php include 'header.php';?>
 
<!DOCTYPE html>
<html lang="fr" data-bs-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire contact</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="style.css">
        
</head>
<body>
<div class="container my-5">
    <h1 class="text-center mb-4">Contactez-nous</h1>
    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $nom = htmlspecialchars($_POST['nom']);
        $email_visiteur = filter_var($_POST['email_visiteur'], FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars($_POST['message']);
        $id_users = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : NULL; // Récupère l'id utilisateur s'il est connecté

        if (!empty($nom) && !empty($email_visiteur) && !empty($message)) {
            try {
                $stmt = $pdo->prepare("INSERT INTO contact (id_users, nom, email_visiteur, message) VALUES (:id_users, :nom, :email_visiteur, :message)");
                $stmt->execute([
                    'id_users' => $id_users,
                    'nom' => $nom,
                    'email_visiteur' => $email_visiteur,
                    'message' => $message
                ]);
                echo '<div class="alert alert-success text-center">Votre message a été envoyé avec succès.</div>';
            } catch (PDOException $e) {
                echo '<div class="alert alert-danger text-center">Erreur : ' . $e->getMessage() . '</div>';
            }
        } else {
            echo '<div class="alert alert-danger text-center">Veuillez remplir tous les champs.</div>';
        }
    }
    ?>

    <!-- Formulaire de contact -->
    <form id="contactForm" action="submit_contact.php" method="POST" class="mx-auto" style="max-width: 600px;">
    <!-- Champ Nom -->
    <div class="mb-3">
            <label for="nom" class="form-label">Nom</label>
            <input type="text" class="form-control" id="nom" name="nom" placeholder="Votre nom" required>
        </div>

        <!-- Champ E-mail -->
        <div class="mb-3">
            <label for="email" class="form-label">E-mail</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Votre e-mail" required>
        </div>

        <!-- Champ Message -->
        <div class="mb-3">
            <label for="message" class="form-label">Message</label>
            <textarea class="form-control" id="message" name="message" rows="5" placeholder="Votre message" required></textarea>
        </div>

        <!-- Bouton Envoyer -->
        <div class="text-center">
            <button type="submit" class="btn btn-primary">Envoyer</button>
        </div>
    </form>
</div>

<?php include 'footer.php'; ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- Script pour le mode sombre -->
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const darkModeSwitch = document.getElementById('darkModeSwitch');

        // Appliquer le mode sombre si activé dans le localStorage
        if (localStorage.getItem('darkMode') === 'true') {
            document.documentElement.setAttribute('data-bs-theme', 'dark');
            darkModeSwitch.checked = true;
        }

        // Gestion du changement de mode
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
<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();
    
    const formData = new FormData(this);
    
    fetch('submit_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        console.log('Réponse reçue:', data); // Pour déboguer
        if (data.includes('success')) { // Modification ici
            window.location.href = 'merci.php';
        } else {
            alert(data);
        }
    })
    .catch(error => {
        console.error('Erreur:', error);
        alert("Une erreur s'est produite lors de l'envoi du message.");
    });
});
</script>


</body>
</html>