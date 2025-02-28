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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <p class="header_title">We Escape</p>
        <nav>
            <a href='index.php' data-translate='accueil'>Accueil</a>
            <a href='index.php?action=egames' data-translate='egames'>Escape Games</a>
            <a href='index.php?action=contact' data-translate='contact'>Contact</a>
        </nav>
        <div class="header-right">
            <div class="compte">
                <?php if (isset($_SESSION['user'])): ?>
                    <div class="profile-container">
                        <div class="profile-image-wrapper">
                            <img src="images/profils/<?= htmlspecialchars($_SESSION['user']['photo_profil']) ?>" alt="Photo de profil" class="profile-image">
                            <div class="profile-hover">
                                <span class="username"><?= htmlspecialchars($_SESSION['user']['username']) ?></span>
                                <a href="index.php?action=profile" class="profile-link" data-translate='voirprofil'>Voir le profil</a>
                            </div>
                        </div>
                        <a href="index.php?action=logout" class="logout-btn"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#d88200" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4M10 17l5-5-5-5M13.8 12H3" />
                            </svg></a>
                    </div>
                <?php else: ?>
                    <div class="auth-buttons">
                        <a href="index.php?action=register" class="register-btn" data-translate='inscription'>Inscription</a>
                    </div>
                <?php endif; ?>
            </div>
            <div class="language-selector">
                <div class="custom-select">
                    <div class="selected-option">
                        <img src="images/flags/fr.svg" alt="Drapeau français" class="flag-icon">
                        <span style="display: none;">Français</span>
                    </div>
                    <div class="options">
                        <div class="option" data-value="fr">
                            <img src="images/flags/fr.svg" alt="Drapeau français" class="flag-icon">
                            <span style="display: none;" data-translate="lang_fr">Français</span>
                        </div>
                        <div class="option" data-value="en">
                            <img src="images/flags/en.svg" alt="Drapeau anglais" class="flag-icon">
                            <span style="display: none;" data-translate="lang_en">English</span>
                        </div>
                        <div class="option" data-value="de">
                            <img src="images/flags/de.svg" alt="Drapeau allemand" class="flag-icon">
                            <span style="display: none;" data-translate="lang_de">Deutsch</span>
                        </div>
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
    <script src="script/general.js"></script>
</body>

</html>