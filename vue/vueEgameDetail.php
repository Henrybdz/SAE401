<!-- Ajout des dépendances pour le calendrier -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="style/reservation.css">
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

            <!-- Section pour le calendrier et les réservations -->
            <div id="reservation-container">
                <div id="calendar-container">
                    <input type="text" id="date-picker" placeholder="Choisissez une date" />
                </div>
                
                <div id="time-slots-container" style="display: none;">
                    <h3 data-translate="creneaux">Créneaux disponibles</h3>
                    <div id="time-slots-list"></div>
                    <p id="no-slots" class="no-slots" data-translate="no_slots">Aucun créneau disponible pour cette date</p>
                </div>

                <div id="reservation-form" style="display: none;">
                    <h3 data-translate="reservation_details">Détails de la réservation</h3>
                    <div id="reservation-summary">
                        <div class="reservation-summary-date"><p data-translate="selected_date">Date sélectionnée : </p> <p id="selected-date"></p></div>
                        <div class="reservation-summary-time"><p data-translate="selected_time">Horaire sélectionné : </p><p id="selected-time"></p></div>
                    </div>
                    <button id="confirm-reservation" class="btn-primary" data-translate="confirm_reservation">
                        Confirmer la réservation
                    </button>
                </div>
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
