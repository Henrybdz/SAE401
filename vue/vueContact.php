<?php require_once 'includes/formulaire.class.php';
$title = "Contact - WE ESCAPE";
?>
<div class="contact-container">
    <div class="background-lines2">
        <img src="images/img/background_rayure.webp" alt="background" loading="lazy">
    </div>
    <div class="contact-content">
        <h2 class="contact-title" data-translate="contacter">Contactez-nous</h2>
        <form class="contact-form" action="index.php?action=contact" method="POST">
            <?php $form = new Formulaire($_POST); ?>
            <div class="form-row">
                <?php
                echo $form->inputTextcontact('nom', 'NOM',   'nom-contact');
                echo $form->inputTextcontact('prenom', 'PRÉNOM', 'prenom-contact');
                ?>
            </div>
            <?php
            echo $form->inputTextcontact('mail', 'MAIL', 'mail-contact');
            echo $form->inputTextcontact('sujet', 'SUJET', 'sujet-contact');
            echo $form->inputTextAreacontact('message', 'VOTRE MESSAGE', 'message-contact');
            ?>
            <?php
            echo $form->submitcontact('submit', 'envoyer-contact');
            ?>
        </form>
    </div>
</div>

<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Capture form data
    $to = 'contact@alainda-ros.fr'; // Replace with your email address
    $subject = htmlspecialchars($_POST['sujet']);
    $message = 'Nom: ' . htmlspecialchars($_POST['nom']) . '\n';
    $message .= 'Prénom: ' . htmlspecialchars($_POST['prenom']) . '\n';
    $message .= 'Email: ' . htmlspecialchars($_POST['mail']) . '\n';
    $message .= 'Message: ' . htmlspecialchars($_POST['message']) . '\n';
    $headers = 'From: ' . htmlspecialchars($_POST['mail']);

    // Send email
    if (mail($to, $subject, $message, $headers)) {
        echo 'Email sent successfully!';
    } else {
        echo 'Email sending failed.';
    }
}
?>