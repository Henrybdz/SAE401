<!-- Ajout des dépendances pour le calendrier -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="style/egamedetail.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="hero-section">
  <div class="ed-background-images">
    <img src="<?=htmlspecialchars($egame['image'])?>" alt="<?=htmlspecialchars($egame['nom'])?>" class="ed-bg-mountains">
    <h2 class="ed-hero-title"><?= htmlspecialchars($egame['nom']) ?></h2>
    <img src="images/img/cloud.png" alt="Nuage" class="ed-bg-cloud">
    <img src="images/img/cloud.png" alt="Nuage" class="ed-bg-cloud-1">
  </div>
</div>
<div class="content-section-2"></div>


<div class="egame-detail-container">
    <?php if (isset($egame)): ?>
        <div class="egame-detail">
            <h2><?= htmlspecialchars($egame['nom']) ?></h2>

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
                    <div id="date-picker"></div>
                </div>

                <div id="time-slots-container" style="display: none;">
                    <h3 data-translate="creneaux">Créneaux disponibles</h3>
                    <div id="time-slots-list"></div>
                    <p id="no-slots" class="no-slots" data-translate="no_slots">Aucun créneau disponible pour cette date</p>
                </div>

                <div id="reservation-form" style="display: none;">
                    <h3 data-translate="reservation_details">Détails de la réservation</h3>
                    <div id="reservation-summary">
                        <div class="reservation-summary-date">
                            <p data-translate="selected_date">Date sélectionnée : </p>
                            <p id="selected-date"></p>
                        </div>
                        <div class="reservation-summary-time">
                            <p data-translate="selected_time">Horaire sélectionné : </p>
                            <p id="selected-time"></p>
                        </div>
                    </div>
                    <div class="participants-selector">
                        <h4 data-translate="nb_participants">Nombre de participants</h4>
                        <select id="nb-participants" class="form-control">
                            <option value="2" data-translate="deuxpersonnes">2 personnes - 30€/pers</option>
                            <option value="3" data-translate="troispersonnes">3 personnes - 25€/pers</option>
                            <option value="4" data-translate="quatrepersonnes">4 personnes - 22€/pers</option>
                            <option value="5" data-translate="cinqpersonnes">5 personnes - 20€/pers</option>
                            <option value="6" data-translate="sixpersonnes">6 personnes - 18€/pers</option>
                        </select>
                        <p class="total-price">
                            <span data-translate="total_price">Prix total :</span>
                            <span id="total-price">60€</span>
                        </p>
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