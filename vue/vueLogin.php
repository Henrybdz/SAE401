<?php
$title = "Connexion";
$error = isset($error) ? $error : null;
$redirect = isset($redirect) ? $redirect : 'index.php';
?>

<div class="login-container">
    <h2>Connexion</h2>
    
    <?php if ($error): ?>
        <div class="error-message"><?php echo htmlspecialchars($error); ?></div>
    <?php endif; ?>

    <form method="POST" action="index.php?action=login" class="login-form">
        <input type="hidden" name="redirect" value="<?php echo htmlspecialchars($redirect); ?>">
        
        <div class="form-group">
            <label for="email">Email:</label>
            <input type="email" id="email" name="email" required>
        </div>

        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>

        <button type="submit" class="btn-submit">Se connecter</button>
    </form>

    <p class="register-link">
        Pas encore de compte ? <a href="index.php?action=register">S'inscrire</a>
    </p>
</div>

<style>
.login-container {
    max-width: 400px;
    margin: 2rem auto;
    padding: 2rem;
    background: #fff;
    border-radius: 8px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.login-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.form-group {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
}

.form-group label {
    font-weight: 500;
}

.form-group input {
    padding: 0.5rem;
    border: 1px solid #ddd;
    border-radius: 4px;
    font-size: 1rem;
}

.btn-submit {
    background-color: #4CAF50;
    color: white;
    padding: 0.75rem;
    border: none;
    border-radius: 4px;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
}

.btn-submit:hover {
    background-color: #45a049;
}

.error-message {
    background-color: #ffebee;
    color: #c62828;
    padding: 0.75rem;
    border-radius: 4px;
    margin-bottom: 1rem;
}

.register-link {
    text-align: center;
    margin-top: 1rem;
}

.register-link a {
    color: #2196F3;
    text-decoration: none;
}

.register-link a:hover {
    text-decoration: underline;
}
</style>
