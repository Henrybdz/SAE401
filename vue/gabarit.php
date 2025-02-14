<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?></title>
    <link rel="stylesheet" href="style/style.css">
    <link rel="stylesheet" href="style/translation.css">
    <script src="script/traduction.js" defer></script>
</head>

<body>
    <header>
        <nav>
            <a href='index.php' data-translate='accueil'>Accueil</a>
            <a href='index.php?action=egames' data-translate='egames'>Escape Games</a>
            <a href='index.php?action=contact' data-translate='contact'>Contact</a>
        </nav>
        <div class="language-selector">
            <select id="langSelect">
                <option value="fr" data-translate="lang_fr">Français</option>
                <option value="en" data-translate="lang_en">English</option>
                <option value="de" data-translate="lang_de">Deutsch</option>
            </select>
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