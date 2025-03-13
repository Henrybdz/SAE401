<?php
$title = "Inscription - WE ESCAPE";
require_once "includes/formulaire.class.php";
?>

<div class="background-lines">
    <img src="images/img/background_rayure.webp" alt="background" loading="lazy">
</div>

<div class="auth-container">
    <h2 data-translate='inscription'>INSCRIPTION</h2>
    <?php if (isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?action=register" method="POST" class="auth-form">
        <?php $form = new Formulaire($_POST); ?>
        <?php
        echo $form->inputMailconnection('email', 'Email', 'email');
        echo $form->inputTextconnection('username', 'Nom d\'utilisateur', 'nom');
        echo $form->inputMDPconnection('password', 'Mot de passe', 'mdp');
        echo $form->submitinscription('register');
        ?>
    </form>
    <div class="auth-links">
        <span data-translate='inscrit?'>DÉJA INSCRIT ?</span>
        <a href="index.php?action=login" data-translate='connecter'>CONNECTEZ-VOUS</a>
    </div>
</div>