<?php
$title =  $egame['nom'] . " - WE ESCAPE";
?>

<!-- Ajout des dépendances pour le calendrier -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
<link rel="stylesheet" href="style/egamedetail.css">
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

<div class="hero-section">
    <div class="ed-background-images">
        <img src="<?= htmlspecialchars($egame['image']) ?>" alt="<?= htmlspecialchars($egame['nom']) ?>" class="ed-bg-mountains" loading="lazy">
        <h2 class="ed-hero-title"><?= htmlspecialchars($egame['nom']) ?></h2>
        <img src="images/img/cloud.avif" alt="Nuage" class="ed-bg-cloud" loading="lazy">
        <img src="images/img/cloud.avif" alt="Nuage" class="ed-bg-cloud-1" loading="lazy">
    </div>
</div>
<div class="content-section-2"></div>

<!-- Indicateurs en haut -->
<div class="indicator-bar">
    <div class="indicator">
        <span data-translate="difficulte">Difficulté</span>
        <div class="bar"></div>
        <div class="progress-bar" style="width: <?= htmlspecialchars($egame['difficulte']) * 10 ?>%"></div>
    </div>
    <div class="indicator">
        <span data-translate="reflexion">Réflexion</span>
        <div class="bar"></div>
        <div class="progress-bar" style="width: <?= htmlspecialchars($egame['reflexion']) * 10 ?>%"></div>
    </div>
    <div class="indicator">
        <span data-translate="manipulation">Manipulation</span>
        <div class="bar"></div>
        <div class="progress-bar" style="width: <?= htmlspecialchars($egame['manipulation']) * 10 ?>%"></div>
    </div>
    <div class="indicator">
        <span data-translate="fouille">Fouille</span>
        <div class="bar"></div>
        <div class="progress-bar" style="width: <?= htmlspecialchars($egame['fouille']) * 10 ?>%"></div>
    </div>
</div>

<div class="egame-detail-container">
    <?php if (isset($egame)): ?>
        <div class="egame-content">
            <!-- Section centrale avec image principale et description -->
            <div class="main-content">
                <h2><?= htmlspecialchars($egame['nom']) ?></h2>
                <div class="main-image">
                    <img src="<?= htmlspecialchars($egame['image']) ?>" alt="<?= htmlspecialchars($egame['nom']) ?>" loading="lazy">
                </div>
                <div class="egame-info">
                    <div class="info-section">
                        <h3>
                            <span data-translate="histoire">Histoire - </span>
                            <span><?= htmlspecialchars($egame['nom']) ?></span>
                        </h3>
                        <p class="translated-description"
                            data-fr="<?= htmlspecialchars($egame['description']['fr']) ?>"
                            data-en="<?= htmlspecialchars($egame['description']['en']) ?>"
                            data-de="<?= htmlspecialchars($egame['description']['de']) ?>">
                            <?= htmlspecialchars($egame['description']['fr']) ?>
                        </p>
                    </div>
                    <div class="info-section">
                        <h3 data-translate="description" id="description-detaillee">Description</h3>
                        <div class="barrejaune"></div>
                        <p class="translated-description-detaillee"
                            data-fr="<?= htmlspecialchars($egame['description_detaillee']['fr']) ?>"
                            data-en="<?= htmlspecialchars($egame['description_detaillee']['en']) ?>"
                            data-de="<?= htmlspecialchars($egame['description_detaillee']['de']) ?>">
                            <?= htmlspecialchars($egame['description_detaillee']['fr']) ?>
                        </p>
                    </div>
                    <div class="info-section">
                        <h3 data-translate="informations">Informations</h3>
                        <p>
                            <span data-translate="duree">Durée</span> :
                            <span><?= htmlspecialchars($egame['duree']) ?></span>
                            <span data-translate="heures">heures</span>
                        </p>
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

        <div class="language-availability">
            <div class="language-flag">
                <img src="images/flags/de.svg" alt="Drapeau allemand" loading="lazy">
                <span data-translate="available1">AVENTURE DISPONIBLE EN</span>
                <span data-translate="available_de" class="langue">ALLEMAND</span>
            </div>
            <div class="language-flag">
                <img src="images/flags/en.svg" alt="Drapeau anglais" loading="lazy">
                <span data-translate="available2">AVENTURE EGALEMENT DISPONIBLE EN</span>
                <span data-translate="available_en" class="langue">ANGLAIS</span>
            </div>
        </div>
</div>
<div class="infos_payement">
    <div class="paiement_container">
        <div class="text_paiement">
            <div>
                <h4 data-translate="sansfrais">Pas de frais supplémentaires</h4>
                <p data-translate="fraisservice">Nous couvrons tous les frais de service.</p>
            </div>
            <div>
                <h4 data-translate="100%">100% de votre temps d'aventure</h4>
                <p data-translate="tpsreserve">Pendant le temps réservé, le terrain de jeu est à vous seul.</p>
            </div>
        </div>
        <div class="image_paiement">
            <img src="images/img/liste-paiement.avif" alt="Liste des moyens de paiement" loading="lazy">
        </div>

        <div class="text_paiement">
            <div>
                <h4 data-translate="pligne">PAIEMENT EN LIGNE</h4>
                <p data-translate="securise">100% sécurisé grâce au cryptage SSL. </p>
            </div>
            <div>
                <h4 data-translate="instant">Confirmation instantanée</h4>
                <p date-translate="billets">Les billets et les bons vous seront envoyés immédiatement par e-mail.</p>
            </div>
        </div>
    </div>

</div>
<div class="faq-section">
    <div class="faq-container">
        <h3 data-translate="questionsg">Questions générales</h3>
        <div class="faq-item">
            <div class="faq-question">
                <h4 data-translate="campagne">Campagnes d'hiver</h4>
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9.5" cy="9.5" r="9.5" fill="black" />
                    <line x1="9.5" y1="3" x2="9.5" y2="16" stroke="white" />
                    <line x1="16" y1="9.5" x2="3" y2="9.5" stroke="white" />
                </svg>
            </div>

            <div class="faq-answer">
                <p data-translate="campagne1">La Campagne d’hiver est un événement spécial proposé par We Escape pendant la saison hivernale.</p>
                <p data-translate="campagne2">Cette expérience unique vous plonge dans une aventure immersive adaptée aux mois froids, avec des scénarios inédits,
                    une ambiance hivernale et parfois même des défis supplémentaires liés à la saison.</p>
                <ul>
                    <li data-translate="campagne3">La Campagne d’hiver est proposée durant une période limitée, généralement de février à mars.</li>
                    <li data-translate="campagne4">Certains escape games sont revisités avec une atmosphère hivernale, et des énigmes exclusives peuvent être ajoutées.</li>
                    <li data-translate="campagne5">L’événement est ouvert à tous les joueurs, mais il est conseillé de réserver à l’avance en raison du nombre limité de sessions.</li>
                    <li data-translate="campagne6">Selon l’escape game choisi, il est utile de prévoir des vêtements adaptés au froid.</li>
                </ul>
                <p data-translate="campagne7">Ne manquez pas cette occasion unique de vivre une aventure immersive sous un nouveau jour ! Réservez dès maintenant votre session pour la Campagne d’hiver.</p>
            </div>

        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h4 data-translate="taille-groupe">Taille de groupe recommandée</h4>
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9.5" cy="9.5" r="9.5" fill="black" />
                    <line x1="9.5" y1="3" x2="9.5" y2="16" stroke="white" />
                    <line x1="16" y1="9.5" x2="3" y2="9.5" stroke="white" />
                </svg>
            </div>

            <div class="faq-answer">
                <p data-translate="taille-groupe1">Voici quelques conseils pour choisir la meilleure configuration :</p>
                <ul>
                    <li data-translate="taille-groupe2">Petits groupes (2-3 joueurs) : Idéal pour les amateurs de défis qui aiment résoudre les énigmes par eux-mêmes. L’expérience sera plus intense, mais aussi plus exigeante.</li>
                    <li data-translate="taille-groupe3">Groupes moyens (4-5 joueurs) : Le parfait équilibre entre réflexion, communication et gestion du temps. Chacun peut apporter sa contribution sans que le jeu ne devienne trop chaotique.</li>
                    <li data-translate="taille-groupe4">Grands groupes (6+ joueurs) : Une option conviviale et idéale pour les événements d’équipe ou les sorties entre amis, mais il faudra bien organiser la collaboration pour éviter que certains joueurs se sentent moins impliqués.</li>
                </ul>
                <p data-translate="taille-groupe5">Si vous hésitez sur la meilleure taille de groupe pour votre expérience, n’hésitez pas à nous contacter. Nous vous aiderons à choisir le format le plus adapté à votre équipe !</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h4 data-translate="chien">Pouvons-nous amener notre chien ?</h4>
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9.5" cy="9.5" r="9.5" fill="black" />
                    <line x1="9.5" y1="3" x2="9.5" y2="16" stroke="white" />
                    <line x1="16" y1="9.5" x2="3" y2="9.5" stroke="white" />
                </svg>
            </div>

            <div class="faq-answer">
                <p data-translate="chien1">Nous adorons les animaux, mais pour garantir la meilleure expérience de jeu possible à tous nos participants, les chiens et autres animaux de compagnie ne sont généralement pas autorisés dans nos escape games.</p>
                <ul>
                    <li data-translate="chien2">Certains joueurs peuvent être allergiques ou mal à l’aise en présence d’animaux.</li>
                    <li data-translate="chien3">Certains espaces ne sont pas adaptés à recevoir des animaux de compagnie.</li>
                </ul>
                <p data-translate="chien4">Cependant, si votre chien est un chien d’assistance, merci de nous contacter à l’avance afin que nous puissions organiser au mieux votre venue.</p>
            </div>
        </div>
        <div class="faq-item">
            <div class="faq-question">
                <h4 data-translate="tarif-enfant">Est-ce que les tarifs enfants coûtent moins cher ?</h4>
                <svg width="19" height="19" viewBox="0 0 19 19" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="9.5" cy="9.5" r="9.5" fill="black" />
                    <line x1="9.5" y1="3" x2="9.5" y2="16" stroke="white" />
                    <line x1="16" y1="9.5" x2="3" y2="9.5" stroke="white" />
                </svg>
            </div>

            <div class="faq-answer">
                <p data-translate="tarif-enfant1">Nos escape games sont conçus pour tous les âges, et nous proposons parfois un tarif réduit pour les enfants, en fonction du scénario et de l’âge des participants.</p>
                <ul>
                    <li data-translate="tarif-enfant2">Certains de nos jeux offrent un tarif préférentiel pour les enfants de moins de 12 ans.</li>
                    <li data-translate="tarif-enfant3">Nous recommandons certains scénarios pour les familles et les jeunes joueurs, avec des énigmes adaptées à leur niveau.</li>
                    <li data-translate="tarif-enfant4">Pour les groupes comprenant des enfants, la présence d’au moins un adulte est requise.</li>
                </ul>
                <p data-translate="tarif-enfant5">Pour connaître les détails des tarifs et les éventuelles réductions disponibles, contactez-nous directement.</p>
            </div>
        </div>
    </div>
</div>
<div class="retour">
    <a href="index.php?action=egames" class="back-button" data-translate="retour">Retour à la liste</a>
</div>


<?php else: ?>
    <div class="error-message">
        Escape game non trouvé
    </div>
    <a href="index.php?action=egames" class="back-button" data-translate="retour">Retour à la liste</a>
<?php endif; ?>
</div>

<script src="script/egamedetail.js"></script>