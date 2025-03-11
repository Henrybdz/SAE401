<?php
$title = "Connexion";
require_once 'includes/formulaire.class.php';
?>

<div class="background-lines">
    <img src="images/img/background_rayure.png" alt="background">
</div>

<div class="auth-container">
    <h2 data-translate="connexion">Connexion</h2>
    <?php if (isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?action=login" method="post" class="auth-form">
        <?php $form = new Formulaire($_POST); ?>
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect ?? ''); ?>">
        <?php
        echo $form->inputMailconnection('email', 'Email', 'email');
        echo $form->inputMDPconnection('password', 'Mot de passe', 'mdp');
        echo $form->submitconnection('login');
        ?>
    </form>
    <div class="auth-links">
        <span data-translate='compte?'>Pas encore de compte ?</span>
        <a href="index.php?action=register" data-translate='inscrire'>Inscrivez-vous</a>
    </div>
</div>