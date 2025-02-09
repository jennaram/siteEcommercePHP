<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // Validation 
    if (empty($name) || empty($email) || empty($message)) {
        echo "Tous les champs sont requis.";
    } else {
        $to = "votre_adresse_email@example.com"; // Remplacez par votre adresse e-mail
        $subject = "Nouveau message de contact";
        $body = "Nom: " . $name . "\nE-mail: " . $email . "\nMessage: " . $message;
        $headers = "From: " . $email;

        if (mail($to, $subject, $body, $headers)) {
            echo "Votre message a été envoyé avec succès.";
        } else {
            echo "Une erreur s'est produite lors de l'envoi du message.";
        }
    }
}
?>

<div class="text-center mt-3">
    <a href="index.php" class="btn btn-secondary" target="_top">Retour à l'accueil</a>
</div>