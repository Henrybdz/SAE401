<link rel="stylesheet" href="style/paiement.css">

<div class="payment-container">
    <div class="payment-details">
        <h2 data-translate="payment_title">Paiement de votre réservation</h2>

        <!-- Résumé de la réservation -->
        <div class="reservation-summary">
            <h3 data-translate="reservation_summary">Résumé de votre réservation</h3>
            <div class="summary-details">
                <p><strong data-translate="escape_game">Escape Game:</strong> <span id="egame-name"></span></p>
                <p><strong data-translate="date">Date:</strong> <span id="reservation-date"></span></p>
                <p><strong data-translate="time">Durée:</strong> <span id="reservation-time"></span></p>
                <div class="reservation-summary-participants">
                    <p>
                        <strong><span data-translate="nb_participants">Nombre de participants :</span></strong>
                        <span id="selected-participants"></span>
                        <span data-translate="personnes">personnes</span>
                    </p>
                </div>
                <div class="reservation-summary-price">
                    <p>
                        <strong><span data-translate="total_price">Prix total :</span></strong>
                        <span id="selected-price"></span>
                        <span data-translate="money">€</span>
                    </p>
                </div>
            </div>


        </div>

        <!-- Formulaire de paiement -->
        <div class="payment-form">
            <h3 data-translate="payment_info">Informations de paiement</h3>
            <form id="payment-form">
                <div class="form-group">
                    <label for="card-holder" data-translate="card_holder">Titulaire de la carte</label>
                    <input type="text" id="card-holder" required>
                </div>

                <div class="form-group">
                    <label for="card-number" data-translate="card_number">Numéro de carte</label>
                    <input type="text" id="card-number" maxlength="19" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="expiry-date" data-translate="expiration">Date d'expiration</label>
                        <input type="text" id="expiry-date" placeholder="MM/YY" maxlength="5" required>
                    </div>
                    <div class="form-group">
                        <label for="cvv" data-translate="cvv">CVC</label>
                        <input type="text" id="cvv" maxlength="3" required>
                    </div>
                </div>

                <div class="button-group">
                    <button type="button" id="back-button" class="btn-secondary" data-translate="back">Retour</button>
                    <button type="submit" class="btn-primary" data-translate="confirm_payment">Confirmer le paiement</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script src="script/paiement.js"></script>