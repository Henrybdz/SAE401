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

// Configuration du calendrier avec Flatpickr
flatpickr('#date-picker', {
    dateFormat: 'Y-m-d',
    minDate: new Date().fp_incr(1),
    onChange: function(selectedDates, dateStr) {
        fetchTimeSlots(dateStr);
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
                ${!slot.is_available ? ' (Réservé)' : ''}
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
    const reservationForm = document.getElementById('reservation-form');
    const dateSelected = document.getElementById('selected-date');
    const timeSelected = document.getElementById('selected-time');

    // Stocker le créneau complet
    window.selectedSlot = slot;

    reservationForm.style.display = 'block';

    dateSelected.innerHTML = `<p>${document.getElementById('date-picker').value}</p>`;
    timeSelected.innerHTML = `<p>${slot.start_time} - ${slot.end_time}</p>`;

    // Définissons le gestionnaire d'événements avec une fonction nommée pour le debug
    const handleConfirmClick = () => {
        confirmReservation(window.selectedSlot);
    };
    
    document.getElementById('confirm-reservation').onclick = handleConfirmClick;
}

// Fonction pour confirmer la réservation
function confirmReservation(slot) {
    const date = document.getElementById('date-picker').value;
    const egameId = new URLSearchParams(window.location.search).get('id');

    if (!date || !slot || !egameId) {
        alert('Données de réservation manquantes');
        return;
    }

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
    .then(response => response.json())
    .then(data => {
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
