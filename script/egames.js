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

    // Mettre à jour les régions
    document.querySelectorAll('.translated-region').forEach(region => {
        region.textContent = region.getAttribute('data-' + lang) || region.getAttribute('data-fr');
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


    window.addEventListener('scroll', function () {
        const scrollPosition = window.scrollY;

        // Éléments à animer
        const mountains = document.querySelector('.e-bg-mountains');
        const title = document.querySelector('.e-hero-title');
        const cloud = document.querySelector('.e-bg-cloud');
        const cloud1 = document.querySelector('.e-bg-cloud-1');

        // Vitesses différentes pour chaque élément (effet parallaxe)
        mountains.style.transform = `translateY(${scrollPosition * 0.1}px)`;
        title.style.transform = `translate(-50%, -50%) translateY(${scrollPosition * 0.2}px)`;
        cloud.style.transform = `translateY(${-scrollPosition * 0.7}px)`;
        cloud1.style.transform = `translateY(${-scrollPosition * 0.7}px)`;
    });
});

document.addEventListener('DOMContentLoaded', function() {
    const filterButtons = document.querySelectorAll('.filter-btn');
    const egameCards = document.querySelectorAll('.egame-card');

    filterButtons.forEach(button => {
        button.addEventListener('click', () => {
            const region = button.getAttribute('data-region');
            
            // Update active button
            filterButtons.forEach(btn => btn.classList.remove('active'));
            button.classList.add('active');
            
            // Filter cards
            egameCards.forEach(card => {
                if (region === 'TOUT' || card.getAttribute('data-region') === region) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    });
});