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
            <!-- Section gauche avec images -->
            <div class="side-images">
                <img src="images/egames/detail1.jpg" alt="Detail 1" class="detail-image">
                <img src="images/egames/detail2.jpg" alt="Detail 2" class="detail-image">
                <img src="images/egames/detail3.jpg" alt="Detail 3" class="detail-image">
            </div>

            <!-- Section centrale avec image principale et description -->
            <div class="main-content">
                <h2><?= htmlspecialchars($egame['nom']) ?></h2>
                <div class="main-image">
                    <img src="<?=htmlspecialchars($egame['image'])?>" alt="<?=htmlspecialchars($egame['nom'])?>">
                </div>
                <div class="egame-info">
                    <div class="info-section">
                        <h3>Histoire - <?= htmlspecialchars($egame['nom']) ?></h3>
                        <p class="translated-description"
                            data-fr="<?= htmlspecialchars($egame['description']['fr']) ?>"
                            data-en="<?= htmlspecialchars($egame['description']['en']) ?>"
                            data-de="<?= htmlspecialchars($egame['description']['de']) ?>">
                            <?= htmlspecialchars($egame['description']['fr']) ?>
                        </p>
                    </div>
                    <div class="info-section">
                        <h3>Description</h3>
                        <p>Durée: <?= htmlspecialchars($egame['duree']) ?> heures</p>
                        <p>Lieu: <?= htmlspecialchars($egame['lieu']) ?></p>
                    </div>
                </div>
            </div>

            <!-- Section droite avec réservation -->
            <div class="reservation-section">
                <h3>Réservation</h3>
                
                <!-- Section du calendrier -->
                <div id="calendar-section">
                    <h4>1. Date</h4>
                    <div id="date-picker"></div>
                </div>

                <!-- Section des créneaux horaires -->
                <div id="time-slots-section" style="display: none;">
                <h4>2. Horaires</h4>
                <div class="barre"></div>
                    <div class="selected-date-display">
                        <p>Date sélectionnée :</p>
                        <p id="displayed-date1" class="date-value"></p>
                    </div>
                    
                    <div id="time-slots-container">
                        <div id="time-slots-list"></div>
                        <p id="no-slots" class="no-slots" style="display: none;">Aucun créneau disponible pour cette date</p>
                    </div>
                    <button id="change-date" class="btn-secondary">Changer la date</button>
                </div>

                <!-- Formulaire de réservation -->
                <div id="reservation-form" style="display: none;">
                <h4>3. Détails de la réservation</h4>
                <div class="barre"></div>
                    <div class="selected-date-display">
                        <p>Date sélectionnée :</p>
                        <p id="displayed-date2" class="date-value"></p>
                    </div>
                    <div class="reservation-summary">
                        <p>Horaire sélectionné : <span id="selected-time"></span></p>
                    </div>
                    <div class="participants-selector">
                        <label for="nb-participants">Nombre de participants</label>
                        <select id="nb-participants">
                            <option value="2">2 personnes - 30€/pers</option>
                            <option value="3">3 personnes - 25€/pers</option>
                            <option value="4">4 personnes - 22€/pers</option>
                            <option value="5">5 personnes - 20€/pers</option>
                            <option value="6">6 personnes - 18€/pers</option>
                        </select>
                        <div class="price-total">
                            <span>Total :</span>
                            <span id="total-price">60€</span>
                        </div>
                    </div>
                    <button id="change-time" class="btn-secondary">Changer l'horaire</button>
                    <button id="confirm-reservation" class="btn-primary">
                        Aller au paiement
                    </button>
                </div>
            </div>
        </div>

        <a href="index.php?action=egames" class="back-button">Retour à la liste</a>
    <?php else: ?>
        <div class="error-message">
            Escape game non trouvé
        </div>
        <a href="index.php?action=egames" class="back-button">Retour à la liste</a>
    <?php endif; ?>
</div>

<script src="script/egamedetail.js"></script>