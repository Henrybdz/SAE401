<?php $title = "Connexion"; ?>

<div class="background-lines">
    <img src="images/img/background_rayure.png" alt="background">
</div>

<div class="auth-container">
    <h2 data-translate="connexion">Connexion</h2>
    <?php if(isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form action="index.php?action=login" method="post" class="auth-form">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect ?? ''); ?>">
        <div class="form-group">
            <label for="email" data-translate='email'>Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password" data-translate='mdp'>Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" data-translate='seconnecter'>Se connecter</button>
    </form>
    <div class="auth-links">
        <span data-translate='compte?'>Pas encore de compte ?</span>
        <a href="index.php?action=register" data-translate='inscrire'>Inscrivez-vous</a>
    </div>
</div>
