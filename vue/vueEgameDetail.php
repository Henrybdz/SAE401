<!-- Ajout des dépendances pour le calendrier -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="style/egamedetail.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="hero-section">
    <div class="ed-background-images">
        <img src="<?= htmlspecialchars($egame['image']) ?>" alt="<?= htmlspecialchars($egame['nom']) ?>" class="ed-bg-mountains">
        <h2 class="ed-hero-title"><?= htmlspecialchars($egame['nom']) ?></h2>
        <img src="images/img/cloud.png" alt="Nuage" class="ed-bg-cloud">
        <img src="images/img/cloud.png" alt="Nuage" class="ed-bg-cloud-1">
    </div>
</div>
<div class="content-section-2"></div>

<!-- Indicateurs en haut -->
<div class="indicator-bar">
    <div class="indicator">
        <span>Difficulté</span>
        <div class="progress-bar" style="width: 70%"></div>
    </div>
    <div class="indicator">
        <span>Réflexion</span>
        <div class="progress-bar" style="width: 80%"></div>
    </div>
    <div class="indicator">
        <span>Manipulation</span>
        <div class="progress-bar" style="width: 60%"></div>
    </div>
    <div class="indicator">
        <span>Fouille</span>
        <div class="progress-bar" style="width: 70%"></div>
    </div>
</div>

<div class="egame-detail-container">
    <?php if (isset($egame)): ?>
        <div class="egame-content">
            <!-- Section gauche avec images 
            <div class="side-images">
                <img src="images/egames/detail1.jpg" alt="Detail 1" class="detail-image">
                <img src="images/egames/detail2.jpg" alt="Detail 2" class="detail-image">
                <img src="images/egames/detail3.jpg" alt="Detail 3" class="detail-image">
            </div>-->

            <!-- Section centrale avec image principale et description -->
            <div class="main-content">
                <h2><?= htmlspecialchars($egame['nom']) ?></h2>
                <div class="main-image">
                    <img src="<?= htmlspecialchars($egame['image']) ?>" alt="<?= htmlspecialchars($egame['nom']) ?>">
                </div>
                <div class="egame-info">
                    <div class="info-section">
                        <h3>
                            <span data-translate="histoire">Histoire - </span>
                            <span><?= htmlspecialchars($egame['nom']) ?></span></h3>
                        <p class="translated-description"
                            data-fr="<?= htmlspecialchars($egame['description']['fr']) ?>"
                            data-en="<?= htmlspecialchars($egame['description']['en']) ?>"
                            data-de="<?= htmlspecialchars($egame['description']['de']) ?>">
                            <?= htmlspecialchars($egame['description']['fr']) ?>
                        </p>
                    </div>
                    <div class="info-section">
                        <h3 data-translate="informations">Informations</h3>
                        <p>
                            <span data-translate="duree">Durée</span> :
                            <span><?= htmlspecialchars($egame['duree']) ?></span>  
                            <span data-translate="heures">heures</span></p>
                        <p>
                            <span data-translate="lieu">Lieu</span> :
                            <span><?= htmlspecialchars($egame['lieu']) ?></span>
                        </p>
                        <p>
                            <span data-translate="region">Région</span> :
                            <span class="translated-region" data-fr="<?= htmlspecialchars($egame['Region']['fr']) ?>" data-en="<?= htmlspecialchars($egame['Region']['en']) ?>" data-de="<?= htmlspecialchars($egame['Region']['de']) ?>"><?= htmlspecialchars($egame['Region']['fr']) ?></span>
                        </p>
                    </div>
                </div>
            </div>

            <!-- Section droite avec réservation -->
            <div class="reservation-section">
                <h3 data-translate="reservation">Réservation</h3>

                <!-- Section du calendrier -->
                <div id="calendar-section">
                    <h4 data-translate="date_info">1. Date</h4>
                    <div id="date-picker"></div>
                </div>

                <!-- Section des créneaux horaires -->
                <div id="time-slots-section" style="display: none;">
                    <h4 data-translate="horaire">2. Horaires</h4>
                    <div class="barre"></div>
                    <div class="selected-date-display">
                        <p data-translate="selected_date">Date sélectionnée :</p>
                        <p id="displayed-date1" class="date-value"></p>
                    </div>

                    <div id="time-slots-container">
                        <div id="time-slots-list"></div>
                        <p id="no-slots" class="no-slots" style="display: none;">Aucun créneau disponible pour cette date</p>
                    </div>
                    <button id="change-date" class="btn-secondary" data-translate="change_date">Changer la date</button>
                </div>

                <!-- Formulaire de réservation -->
                <div id="reservation-form" style="display: none;">
                    <h4>
                        <span>3. </span>
                        <span data-translate="reservation_details">Détails de la réservation</span>
                    </h4>
                    <div class="barre"></div>
                    <div class="selected-date-display">
                        <p data-translate="selected_date">Date sélectionnée :</p>
                        <p id="displayed-date2" class="date-value"></p>
                    </div>
                    <div class="reservation-summary">
                        <p data-translate="selected_time">Horaire sélectionné :</p>
                        <p id="selected-time" class="time-value"></p>
                    </div>
                    <div class="participants-selector">
                        <label for="nb-participants" data-translate="nb_participants">Nombre de participants</label>
                        <select id="nb-participants">
                            <option value="2" data-translate="deuxpersonnes">2 personnes - 30€/pers</option>
                            <option value="3" data-translate="troispersonnes">3 personnes - 25€/pers</option>
                            <option value="4" data-translate="quatrepersonnes">4 personnes - 22€/pers</option>
                            <option value="5" data-translate="cinqpersonnes">5 personnes - 20€/pers</option>
                            <option value="6" data-translate="sixpersonnes">6 personnes - 18€/pers</option>
                        </select>
                        <div class="price-total">
                            <span data-translate="total_price">Total :</span>
                            <span><span id="total-price">60</span>
                            <span data-translate="money">€</span></span>
                        </div>
                    </div>
                    <button id="change-time" class="btn-secondary" data-translate="change_time">Changer l'horaire</button>
                    <button id="confirm-reservation" class="btn-primary" data-translate="go_payment">
                        Aller au paiement
                    </button>
                </div>
            </div>
        </div>

        <a href="index.php?action=egames" class="back-button" data-translate="retour">Retour à la liste</a>
    <?php else: ?>
        <div class="error-message">
            Escape game non trouvé
        </div>
        <a href="index.php?action=egames" class="back-button">Retour à la liste</a>
    <?php endif; ?>
</div>

<script src="script/egamedetail.js"></script>