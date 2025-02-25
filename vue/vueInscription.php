<?php $title = "Inscription"; ?>

<div class="auth-container">
    <h2 data-translate = 'inscription'>Inscription</h2>
    <?php if(isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    
    <form action="index.php?action=register" method="POST" class="auth-form">
        <div class="form-group">
            <label for="email" data-translate='email'>Email</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="username" data-translate='nom'>Nom d'utilisateur</label>
            <input type="text" id="username" name="username" required>
        </div>
        <div class="form-group">
            <label for="password" data-translate='mdp'>Mot de passe</label>
            <input type="password" id="password" name="password" required>
        </div>
        <button type="submit" data-translate='sinscrire'>S'inscrire</button>
    </form>
    <div class="auth-links">
        <span data-translate='inscrit?'>Déja inscrit ?</span>
        <a href="index.php?action=login" data-translate='connecter'>Connectez-vous</a>
    </div>
</div>
