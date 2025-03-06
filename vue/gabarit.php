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
    <link rel="stylesheet" href="style/escapegames.css">
    <link rel="stylesheet" href="style/contact.css">
    <script src="script/traduction.js" defer></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Exa:wght@100..900&display=swap" rel="stylesheet">
</head>

<body>
    <header>
        <a href="index.php" class="logo"><img src="images/img/logo_footer.png" alt="Logo We Escape" class="header_title"></a>
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
                        <a href="index.php?action=logout" class="logout-btn"><svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 24 24" fill="none" stroke="#fff" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
        <div class="footer-container">
            <div class="footer-logo-section">
                <img src="images/img/logo_footer.png" alt="Logo We Escape" class="footer-logo">
                <div class="footer-tagline" data-translate="tagline">L'ÉPREUVE PAR ÉQUIPE POUR LE MEILLEUR MOMENT D'ÉQUIPE</div>

                <div class="footer-contact">
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path>
                        </svg>
                        <span>07 66 89 96 66 0</span>
                    </div>
                    <div class="footer-contact-item">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"></path>
                            <polyline points="22,6 12,13 2,6"></polyline>
                        </svg>
                        <span>BOOKING@WE-ESCAPE.DE</span>
                    </div>
                </div>

                <div class="footer-social">
                    <a href="https://www.facebook.com/weescapegmbh" aria-label="Facebook" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                        </svg>
                    </a>
                    <a href="https://www.instagram.com/we_escape_abenteuer/" aria-label="Instagram" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <rect x="2" y="2" width="20" height="20" rx="5" ry="5"></rect>
                            <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                            <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                        </svg>
                    </a>
                    <a href="https://www.youtube.com/@We-Escape" aria-label="YouTube" target="_blank">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#FF9900" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z"></path>
                            <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                        </svg>
                    </a>
                </div>
            </div>

            <div class="footer-links-section">
                <div class="footer-links-column">
                    <h3 class="footer-links-title" data-translate="suivre">POURSUIVRE</h3>
                    <div class="footer-links">
                        <a href="#" data-translate="apropos">À propos de nous</a>
                        <a href="#" data-translate="blog">Blog</a>
                        <a href="#" data-translate="contact">Contact</a>
                        <a href="#" data-translate="mentions">Mentions légales</a>
                        <a href="#" data-translate="confidentialite">Politique de confidentialité</a>
                        <a href="#" data-translate="conditions">Conditions générales</a>
                    </div>
                </div>

                <div class="footer-links-column">
                    <h3 class="footer-links-title" data-translate="informations">INFORMATIONS</h3>
                    <div class="footer-links">
                        <a href="#" data-translate="emplois">Emplois / Carrières</a>
                        <a href="#" data-translate="faq">FAQ</a>
                        <a href="#" data-translate="cadeaux">Bons cadeaux</a>
                        <a href="#" data-translate="team">Perfect Team Event & Team Building</a>
                        <a href="#" data-translate="escape">Escape Room en plein air</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <script src="script/general.js"></script>
</body>

</html>