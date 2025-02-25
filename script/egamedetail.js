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
        console.error('Erreur:', error);
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
        slotElement.innerHTML = `
            <button class="slot-button" data-slot-id="${slot.id}">
                ${slot.start_time} - ${slot.end_time}
            </button>
        `;
        
        slotElement.querySelector('button').addEventListener('click', () => selectTimeSlot(slot));
        container.appendChild(slotElement);
    });
}

// Fonction pour sélectionner un créneau horaire
function selectTimeSlot(slot) {
    const reservationForm = document.getElementById('reservation-form');
    const dateSelected = document.getElementById('selected-date');
    const timeSelected = document.getElementById('selected-time');

    reservationForm.style.display = 'block';

    dateSelected.innerHTML = `<p>${document.getElementById('date-picker').value}</p>`;
    timeSelected.innerHTML = `<p>${slot.start_time} - ${slot.end_time}</p>`;

    document.getElementById('confirm-reservation').onclick = () => confirmReservation(slot.id);
}

// Fonction pour confirmer la réservation
function confirmReservation(slotId) {
    const date = document.getElementById('date-picker').value;
    const egameId = new URLSearchParams(window.location.search).get('id');

    if (!date || !slotId || !egameId) {
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
            time_slot_id: slotId,
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
        console.error('Erreur:', error);
        alert('Une erreur est survenue lors de la réservation');
    });
}
