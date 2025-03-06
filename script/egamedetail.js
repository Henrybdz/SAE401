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

function calculatePrice(participants) {
    const pricePerPerson = {
        2: 30,
        3: 25,
        4: 22,
        5: 20,
        6: 18
    };
    return participants * pricePerPerson[participants];
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

    window.addEventListener('scroll', function () {
        const scrollPosition = window.scrollY;

        // Éléments à animer
        const mountains = document.querySelector('.ed-bg-mountains');
        const title = document.querySelector('.ed-hero-title');
        const cloud = document.querySelector('.ed-bg-cloud');
        const cloud1 = document.querySelector('.ed-bg-cloud-1');

        // Vitesses différentes pour chaque élément (effet parallaxe)
        mountains.style.transform = `translateY(${scrollPosition * 0.1}px)`;
        title.style.transform = `translate(-50%, -50%) translateY(${scrollPosition * 0.2}px)`;
        cloud.style.transform = `translateY(${-scrollPosition * 0.7}px)`;
        cloud1.style.transform = `translateY(${-scrollPosition * 0.7}px)`;
    });

    // Ajout des gestionnaires pour la navigation entre les étapes
    document.getElementById('change-date').addEventListener('click', () => {
        document.getElementById('calendar-section').style.display = 'block';
        document.getElementById('time-slots-section').style.display = 'none';
        document.getElementById('reservation-form').style.display = 'none';
    });

    document.getElementById('change-time').addEventListener('click', () => {
        document.getElementById('time-slots-section').style.display = 'block';
        document.getElementById('reservation-form').style.display = 'none';
    });
});

// Configuration du calendrier avec Flatpickr
flatpickr('#date-picker', {
    dateFormat: 'Y-m-d',
    minDate: new Date().fp_incr(1),
    inline: true, // Calendrier toujours visible
    showMonths: 1,
    altFormat: "F Y",
    altInput: true,
    monthSelectorType: "static",
    onChange: function (selectedDates, dateStr) {
        console.log('Date sélectionnée:', dateStr);
        if (selectedDates[0]) {
            // Remplacer le calendrier par les créneaux horaires
            document.getElementById('calendar-section').style.display = 'none';
            document.getElementById('time-slots-section').style.display = 'block';
            fetchTimeSlots(dateStr);

            const dateSelected = document.getElementById('displayed-date1');
            const dateSelected2 = document.getElementById('displayed-date2');
            if (dateSelected) {
                dateSelected.textContent = dateStr;
                dateSelected2.textContent = dateStr;
            } else {
                console.error('L\'élément avec l\'ID "displayed-date" n\'existe pas.');
            }
        }
    }
});

// Fonction pour récupérer les créneaux horaires disponibles
function fetchTimeSlots(date) {
    const egameId = new URLSearchParams(window.location.search).get('id');
    const container = document.getElementById('time-slots-list');

    container.innerHTML = '<p>Chargement des créneaux...</p>';

    fetch(`index.php?action=getTimeSlots&date=${date}&egame_id=${egameId}`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest'
        }
    })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.error) {
                throw new Error(data.error);
            }
            displayTimeSlots(data.timeSlots || []);
        })
        .catch(error => {
            container.innerHTML = `<p class="error-message">Une erreur est survenue: ${error.message}</p>`;
        });
}

// Fonction pour afficher les créneaux horaires
function displayTimeSlots(timeSlots) {

    const noSlots = document.getElementById('no-slots');
    const container = document.getElementById('time-slots-list');
    const timeSlotsContainer = document.getElementById('time-slots-container');
    const reservationForm = document.getElementById('reservation-form');

    container.innerHTML = '';

    timeSlotsContainer.style.display = 'block';
    reservationForm.style.display = 'none';

    if (!Array.isArray(timeSlots) || timeSlots.length === 0) {
        noSlots.style.display = 'block';
        container.innerHTML = '';
        return;
    }

    noSlots.style.display = 'none';
    container.innerHTML = '';

    timeSlots.forEach(slot => {

        const slotElement = document.createElement('div');
        slotElement.className = 'time-slot';

        const buttonClass = slot.is_available ? 'slot-button available' : 'slot-button reserved';
        const buttonStyle = slot.is_available ? '' : 'style="background-color: #ff4444 !important; cursor: not-allowed !important;"';

        slotElement.innerHTML = `
            <button class="${buttonClass}" 
                    data-slot-id="${slot.id}" 
                    ${buttonStyle}
                    ${!slot.is_available ? 'disabled' : ''}>
                ${slot.start_time} - ${slot.end_time}
                ${!slot.is_available ? '' : ''}
            </button>
        `;

        if (slot.is_available) {
            const button = slotElement.querySelector('button');
            button.addEventListener('click', () => {
                selectTimeSlot(slot);
            });
        }

        container.appendChild(slotElement);
    });
}

// Fonction pour sélectionner un créneau horaire
function selectTimeSlot(slot) {
    const timeSelected = document.getElementById('selected-time');
    const timeSlotsSection = document.getElementById('time-slots-section');
    const reservationForm = document.getElementById('reservation-form');

    window.selectedSlot = slot;
    timeSelected.textContent = `${slot.start_time} - ${slot.end_time}`;

    // Remplacer la section des créneaux par le formulaire de réservation
    timeSlotsSection.style.display = 'none';
    reservationForm.style.display = 'block';

    const participantsSelect = document.getElementById('nb-participants');
    const totalPriceSpan = document.getElementById('total-price');

    participantsSelect.addEventListener('change', function () {
        const participants = parseInt(this.value);
        const totalPrice = calculatePrice(participants);
        totalPriceSpan.textContent = `${totalPrice}€`;
    });
    // Un seul gestionnaire d'événements pour le bouton de confirmation
    document.getElementById('confirm-reservation').addEventListener('click', function () {
        // Sauvegarder les détails de la réservation
        const reservationDetails = {
            /*egameName: document.querySelector('.egame-detail h2').textContent,*/
            date: document.getElementById('date-picker').value,
            time: `${slot.start_time} - ${slot.end_time}`,
            /*duration: document.querySelector('.egame-info p:first-child').textContent,*/
            egame_id: new URLSearchParams(window.location.search).get('id'),
            start_time: slot.start_time,
            end_time: slot.end_time,
            participants: parseInt(document.getElementById('nb-participants').value),
            totalPrice: calculatePrice(parseInt(document.getElementById('nb-participants').value))
        };
        localStorage.setItem('reservationDetails', JSON.stringify(reservationDetails));

        // Rediriger vers la page de paiement
        window.location.href = 'index.php?action=paiement';
    });
}

// Fonction pour confirmer la réservation
function confirmReservation(slot) {
    const date = document.getElementById('date-picker').value;
    const egameId = new URLSearchParams(window.location.search).get('id');

    if (!date || !slot || !egameId) {
        alert('Données de réservation manquantes');
        return;
    }

    console.log('Détails de la réservation:', {
        date: date,
        start_time: slot.start_time,
        end_time: slot.end_time,
        egame_id: egameId
    });

    fetch('index.php?action=createReservation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-Requested-With': 'XMLHttpRequest'
        },
        body: JSON.stringify({
            date: date,
            start_time: slot.start_time,
            end_time: slot.end_time,
            egame_id: egameId
        })
    })
        .then(response => {
            console.log('Réponse de l\'API:', response);
            return response.json();
        })
        .then(data => {
            console.log('Données de l\'API:', data);
            if (data.message === 'auth_required') {
                // Rediriger vers la page de connexion avec l'URL de retour
                const currentUrl = encodeURIComponent(window.location.href);
                window.location.href = `index.php?action=login&redirect=${currentUrl}`;
                return;
            }

            if (data.success) {
                alert('Réservation confirmée !');
                // Recharger les créneaux disponibles
                fetchTimeSlots(date);
            } else {
                alert(data.message || 'Une erreur est survenue lors de la réservation');
            }
        })
        .catch(error => {
            alert('Une erreur est survenue lors de la réservation');
        });
}