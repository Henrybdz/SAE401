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
}

// Initialisation
document.addEventListener('DOMContentLoaded', async () => {
    // Charger les traductions
    await loadTranslations();
    
    // Récupérer la langue sauvegardée ou utiliser le français par défaut
    const savedLang = localStorage.getItem('selectedLang') || 'fr';
    
    // Mettre à jour le sélecteur de langue
    const langSelect = document.getElementById('langSelect');
    if (langSelect) {
        langSelect.value = savedLang;
        // Ajouter l'écouteur d'événement pour le changement de langue
        langSelect.addEventListener('change', (e) => changeLang(e.target.value));
    }
    
    // Appliquer la traduction initiale
    changeLang(savedLang);
});
