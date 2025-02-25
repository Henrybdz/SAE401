<!-- Ajout des dépendances pour le calendrier -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

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

            <!-- Section pour le calendrier -->
            <div id="calendar-container">
                <input type="text" id="date-picker" placeholder="Choisissez une date" />
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

<script src="script/egamedetail.js"></script>
