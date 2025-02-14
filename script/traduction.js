// Fonction pour charger les traductions
let translations = {};

async function loadTranslations() {
    try {
        const response = await fetch('Donnees/traduction.json');
        translations = await response.json();
    } catch (error) {
        console.error('Erreur lors du chargement des traductions:', error);
    }
}

// Fonction pour changer la langue
function changeLang(lang) {
    // Sauvegarder la langue sélectionnée dans localStorage
    localStorage.setItem('selectedLang', lang);
    
    // Traduire tous les éléments avec l'attribut data-translate
    document.querySelectorAll('[data-translate]').forEach(element => {
        const key = element.getAttribute('data-translate');
        if (translations[lang] && translations[lang][key]) {
            if (element.tagName.toLowerCase() === 'option') {
                // Pour les options du sélecteur, on met à jour le texte affiché
                element.text = translations[lang][key];
            } else {
                element.textContent = translations[lang][key];
            }
        }
    });
    
    // Mettre à jour le drapeau actif dans le sélecteur de langue
    const selector = document.querySelector('.language-selector');
    if (selector) {
        selector.setAttribute('data-current-lang', lang);
    }
}

// Initialisation
document.addEventListener('DOMContentLoaded', function() {
    // Initialiser le sélecteur de langue personnalisé
    initCustomSelect();
    
    // Charger les traductions
    fetch('Donnees/traduction.json')
        .then(response => response.json())
        .then(data => {
            // Stocker les traductions globalement
            window.translations = data;
            
            // Appliquer la langue sauvegardée ou par défaut
            const savedLang = localStorage.getItem('selectedLang') || 'fr';
            applyTranslation(savedLang);
            updateLanguageSelector(savedLang);
        });
});

function initCustomSelect() {
    const customSelect = document.querySelector('.custom-select');
    const selectedOption = customSelect.querySelector('.selected-option');
    const options = customSelect.querySelector('.options');
    
    // Ouvrir/fermer le menu au clic
    selectedOption.addEventListener('click', () => {
        customSelect.classList.toggle('open');
    });
    
    // Fermer le menu si on clique en dehors
    document.addEventListener('click', (e) => {
        if (!customSelect.contains(e.target)) {
            customSelect.classList.remove('open');
        }
    });
    
    // Gérer la sélection d'une option
    options.addEventListener('click', (e) => {
        const option = e.target.closest('.option');
        if (option) {
            const lang = option.dataset.value;
            
            // Fermer le menu
            customSelect.classList.remove('open');
            
            // Sauvegarder et appliquer la nouvelle langue
            localStorage.setItem('selectedLang', lang);
            applyTranslation(lang);
            updateLanguageSelector(lang);
        }
    });
    
    // Initialiser avec la langue sauvegardée
    const savedLang = localStorage.getItem('selectedLang') || 'fr';
    updateSelectedOption(savedLang);
}

function applyTranslation(lang) {
    const elements = document.querySelectorAll('[data-translate]');
    elements.forEach(element => {
        const key = element.getAttribute('data-translate');
        if (window.translations && window.translations[lang] && window.translations[lang][key]) {
            element.textContent = window.translations[lang][key];
        }
    });
    
    // Mettre à jour les textes traduits dynamiquement
    if (typeof updateTranslatedTexts === 'function') {
        updateTranslatedTexts(lang);
    }
    
    // Mettre à jour l'option sélectionnée après la traduction
    updateSelectedOption(lang);
}

function updateSelectedOption(lang) {
    const selectedOption = document.querySelector('.selected-option');
    const option = document.querySelector(`.option[data-value="${lang}"]`);
    if (selectedOption && option) {
        // Mettre à jour le drapeau
        const flagSrc = option.querySelector('.flag-icon').src;
        selectedOption.querySelector('.flag-icon').src = flagSrc;
        
        // Copier le texte traduit de l'option vers l'option sélectionnée
        const optionSpan = option.querySelector('span');
        selectedOption.querySelector('span').textContent = optionSpan.textContent;
    }
}

function updateLanguageSelector(lang) {
    const selector = document.querySelector('.language-selector');
    if (selector) {
        selector.setAttribute('data-current-lang', lang);
    }
}
