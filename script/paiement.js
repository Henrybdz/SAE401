document.addEventListener('DOMContentLoaded', function () {
    // Récupérer les détails de la réservation depuis localStorage
    const reservationDetails = JSON.parse(localStorage.getItem('reservationDetails') || '{}');

    // Remplir les détails de la réservation
    document.getElementById('egame-name').textContent = reservationDetails.egameName || '';
    document.getElementById('reservation-date').textContent = reservationDetails.date || '';
    document.getElementById('reservation-time').textContent = reservationDetails.time || '';
    document.getElementById('selected-participants').textContent = reservationDetails.participants;
    document.getElementById('selected-price').textContent = reservationDetails.totalPrice;

    // Formater le numéro de carte
    const cardNumber = document.getElementById('card-number');
    cardNumber.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\s/g, '').replace(/[^0-9]/gi, '');
        let formattedValue = value.match(/.{1,4}/g)?.join(' ') || value;
        e.target.value = formattedValue.substring(0, 19);
    });

    // Formater la date d'expiration
    const expiryDate = document.getElementById('expiry-date');
    expiryDate.addEventListener('input', function (e) {
        let value = e.target.value.replace(/\D/g, '');
        if (value.length >= 2) {
            value = value.substring(0, 2) + '/' + value.substring(2);
        }
        e.target.value = value.substring(0, 5);
    });

    // Gérer le retour
    document.getElementById('back-button').addEventListener('click', function () {
        window.history.back();
    });

    // Gérer la soumission du formulaire
    document.getElementById('payment-form').addEventListener('submit', function (e) {
        e.preventDefault();

        // Récupérer les détails de la réservation
        const reservationDetails = JSON.parse(localStorage.getItem('reservationDetails') || '{}');

        // Créer la réservation
        fetch('index.php?action=createReservation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                date: reservationDetails.date,
                start_time: reservationDetails.start_time,
                end_time: reservationDetails.end_time,
                egame_id: reservationDetails.egame_id,
                participants: reservationDetails.participants,
                total_price: reservationDetails.totalPrice
            })
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    // Nettoyer le localStorage
                    localStorage.removeItem('reservationDetails');
                    // Rediriger vers la page d'accueil ou une page de confirmation
                    window.location.href = 'index.php?action=profile';
                    alert('Paiement et réservation effectués avec succès !');
                } else {
                    alert(data.message || 'Une erreur est survenue lors de la réservation');
                    sendEmail();
                }
            })
            .catch(error => {
                alert('Une erreur est survenue lors de la réservation');
            });
    });
});
