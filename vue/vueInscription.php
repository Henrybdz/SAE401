<?php $title = "Inscription"; ?>

<div class="background-lines">
    <img src="images/img/background_rayure.png" alt="background">
</div>

<div class="auth-container">
    <h2 data-translate='inscription'>INSCRIPTION</h2>
    <?php if (isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form action="index.php?action=register" method="POST" class="auth-form">
        <div class="form-group">
            <label for="email" data-translate='email'>EMAIL</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="username" data-translate='nom'>NOM D'UTILISATEUR</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password" data-translate='mdp'>MOT DE PASSE</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" data-translate='sinscrire'>S'INSCRIRE</button>
    </form>
    <div class="auth-links">
        <span data-translate='inscrit?'>DÉJA INSCRIT ?</span>
        <a href="index.php?action=login" data-translate='connecter'>CONNECTEZ-VOUS</a>
    </div>
</div>