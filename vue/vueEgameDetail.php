<?php $title = "Détails Escape Game"; ?>

<div class="egame-detail-container">
    <?php if (isset($egame)): ?>
        <div class="egame-detail">
            <h1 class="translated-title"
                data-fr="<?= htmlspecialchars($egame['nom']['fr']) ?>"
                data-en="<?= htmlspecialchars($egame['nom']['en']) ?>"
                data-de="<?= htmlspecialchars($egame['nom']['de']) ?>">
                <?= htmlspecialchars($egame['nom']['fr']) ?>
            </h1>

            <div class="egame-info">
                <p>
                    <strong><span data-translate="duree">Durée</span></strong>: 
                    <?= htmlspecialchars($egame['duree']) ?> 
                    <span data-translate="heures">heures</span>
                </p>

                <p>
                    <strong><span data-translate="description">Description</span></strong>:
                    <span class="translated-description"
                        data-fr="<?= htmlspecialchars($egame['description']['fr']) ?>"
                        data-en="<?= htmlspecialchars($egame['description']['en']) ?>"
                        data-de="<?= htmlspecialchars($egame['description']['de']) ?>">
                        <?= htmlspecialchars($egame['description']['fr']) ?>
                    </span>
                </p>

                <p>
                    <strong><span data-translate="lieu">Lieu</span></strong>: 
                    <?= htmlspecialchars($egame['lieu']) ?>
                </p>

                <!-- Ajoutez ici d'autres informations détaillées spécifiques à l'escape game -->
            </div>

            <a href="index.php?action=egames" class="back-button" data-translate="retour">Retour à la liste</a>
        </div>
    <?php else: ?>
        <div class="error-message" data-translate="egame_not_found">
            Escape game non trouvé
        </div>
        <a href="index.php?action=egames" class="back-button" data-translate="retour">Retour à la liste</a>
    <?php endif; ?>
</div>

<script>
// Fonction pour mettre à jour les textes traduits
function updateTranslatedTexts(lang) {
    // Mettre à jour les descriptions
    document.querySelectorAll('.translated-description').forEach(desc => {
        desc.textContent = desc.getAttribute('data-' + lang) || desc.getAttribute('data-fr');
    });
    
    // Mettre à jour les titres
    document.querySelectorAll('.translated-title').forEach(title => {
        title.textContent = title.getAttribute('data-' + lang) || title.getAttribute('data-fr');
    });
}

// Observer les changements de langue
document.addEventListener('DOMContentLoaded', () => {
    const langSelect = document.getElementById('langSelect');
    if (langSelect) {
        langSelect.addEventListener('change', (e) => {
            updateTranslatedTexts(e.target.value);
        });
        // Appliquer la traduction initiale
        const savedLang = localStorage.getItem('selectedLang') || 'fr';
        updateTranslatedTexts(savedLang);
    }
});
</script>
