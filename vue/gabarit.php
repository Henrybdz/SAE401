<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/translation.css">
    <link rel="stylesheet" href="style/profil.css">
    <link rel="stylesheet" href="style/reservation.css">
    <script src="script/traduction.js" defer></script>
</head>

<body>
    <header>
        <nav>
            <a href='index.php' data-translate='accueil'>Accueil</a>
            <a href='index.php?action=egames' data-translate='egames'>Escape Games</a>
            <a href='index.php?action=contact' data-translate='contact'>Contact</a>
        </nav>
        <div class="compte">
            <?php if(isset($_SESSION['user'])): ?>
                <div class="profile-container">
                    <div class="profile-image-wrapper">
                        <img src="images/profils/<?= htmlspecialchars($_SESSION['user']['photo_profil']) ?>" alt="Photo de profil" class="profile-image">
                        <div class="profile-hover">
                            <span class="username"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                            <a href="index.php?action=profile" class="profile-link" data-translate='voirprofil'>Voir le profil</a>
                        </div>
                    </div>
                    <a href="index.php?action=logout" class="logout-btn" data-translate='deconnexion'>Déconnexion</a>
                </div>
            <?php else: ?>
                <div class="auth-buttons">
                    <a href="index.php?action=login" class="login-btn" data-translate='connexion'>Connexion</a>
                    <a href="index.php?action=register" class="register-btn" data-translate='inscription'>Inscription</a>
                </div>
            <?php endif; ?>
        </div>
        <div class="language-selector">
            <div class="custom-select">
                <div class="selected-option">
                    <img src="images/flags/fr.svg" alt="Drapeau français" class="flag-icon">
                    <span>Français</span>
                </div>
                <div class="options">
                    <div class="option" data-value="fr">
                        <img src="images/flags/fr.svg" alt="Drapeau français" class="flag-icon">
                        <span data-translate="lang_fr">Français</span>
                    </div>
                    <div class="option" data-value="en">
                        <img src="images/flags/en.svg" alt="Drapeau anglais" class="flag-icon">
                        <span data-translate="lang_en">English</span>
                    </div>
                    <div class="option" data-value="de">
                        <img src="images/flags/de.svg" alt="Drapeau allemand" class="flag-icon">
                        <span data-translate="lang_de">Deutsch</span>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <main>
        <?= $contenu ?>
    </main>
    <footer>
        <?= $footer ?>
    </footer>
</body>

</html>