document.addEventListener('DOMContentLoaded', function () {
    window.addEventListener('scroll', function () {
        const scrollPosition = window.scrollY;

        // Éléments à animer
        const mountains = document.querySelector('.bg-mountains');
        const title = document.querySelector('.hero-title');
        const forest = document.querySelector('.bg-forest');
        const cloud = document.querySelector('.bg-cloud');
        const cloud1 = document.querySelector('.bg-cloud-1');

        // Vitesses différentes pour chaque élément (effet parallaxe)
        mountains.style.transform = `translateY(${scrollPosition * 0.1}px)`;
        title.style.transform = `translate(-50%, -50%) translateY(${scrollPosition * 0.2}px)`;
        forest.style.transform = `translateY(${-scrollPosition * 0.4}px)`;
        cloud.style.transform = `translateY(${-scrollPosition * 0.7}px)`;
        cloud1.style.transform = `translateY(${-scrollPosition * 0.7}px)`;
    });
});

document.addEventListener('DOMContentLoaded', function () {
    // Données des régions avec leurs marqueurs
    const regions = {
        'FR-A': {
            name: 'Alsace',
            viewBox: '475 130 60 110',
            markers: [{
                x: 520,
                y: 165,
                name: 'Strasbourg',
                escapegameID: '1'
            },
            {
                x: 505,
                y: 190,
                name: 'Colmar',
                escapegameID: '3'
            },
            {
                x: 502,
                y: 215,
                name: 'Mulhouse',
                escapegameID: '2'
            },
            {
                x: 494,
                y: 185,
                name: 'Le Bonhomme',
                escapegameID: '5'
            },
            {
                x: 491,
                y: 198,
                name: 'Munster',
                escapegameID: '4'
            },
            {
                x: 497,
                y: 168,
                name: 'Schirmeck',
                escapegameID: '6'
            },
            {
                x: 504,
                y: 155,
                name: 'Saverne',
                escapegameID: '7'
            }
            ]
        },
        'FR-I': {
            name: 'Franche-Comté',
            viewBox: '420 190 60 120',
            markers: [{
                x: 445,
                y: 220,
                name: 'Besançon',
                escapegameID: '11'
            },
            {
                x: 435,
                y: 240,
                name: 'Dole',
                escapegameID: '12'
            },
            {
                x: 450,
                y: 260,
                name: 'Belfort',
                escapegameID: '13'
            }
            ]
        },
        'FR-M': {
            name: 'Lorraine',
            viewBox: '420 95 60 120',
            markers: [{
                x: 440,
                y: 130,
                name: 'Metz',
                escapegameID: '8'
            },
            {
                x: 450,
                y: 150,
                name: 'Nancy',
                escapegameID: '9'
            },
            {
                x: 430,
                y: 170,
                name: 'Épinal',
                escapegameID: '10'
            }
            ]
        }
    };



    // Sélectionner tous les chemins de région
    const regionPaths = document.querySelectorAll('.map path');
    const regionDetail = document.getElementById('region-detail');
    const regionName = document.getElementById('region-name');
    const regionSvg = document.getElementById('region-svg');
    const closeButton = document.getElementById('close-detail');

    // Ajouter des écouteurs d'événements pour chaque région
    regionPaths.forEach(path => {
        path.addEventListener('click', function () {
            const regionId = this.id;
            const region = regions[regionId];

            if (region) {
                // Afficher le nom de la région
                regionName.textContent = region.name;

                // Copier le chemin de la région
                regionSvg.innerHTML = '';
                const clonedPath = this.cloneNode(true);
                clonedPath.setAttribute('fill', 'white');
                regionSvg.appendChild(clonedPath);

                // Définir le viewBox pour zoomer sur la région
                regionSvg.setAttribute('viewBox', region.viewBox);

                // Ajouter les marqueurs
                region.markers.forEach(marker => {
                    // Créer un groupe pour le marqueur
                    const markerGroup = document.createElementNS('http://www.w3.org/2000/svg', 'g');

                    // Créer le cercle du marqueur
                    const circle = document.createElementNS('http://www.w3.org/2000/svg', 'circle');
                    circle.setAttribute('cx', marker.x);
                    circle.setAttribute('cy', marker.y);
                    circle.setAttribute('r', '2');
                    circle.setAttribute('fill', '#FF9900');
                    circle.setAttribute('stroke', 'black');
                    circle.setAttribute('stroke-width', '0.5');
                    circle.setAttribute('cursor', 'pointer');

                    // Créer le texte du marqueur (initialement invisible)
                    const text = document.createElementNS('http://www.w3.org/2000/svg', 'text');
                    text.setAttribute('x', marker.x + 3);
                    text.setAttribute('y', marker.y + 1);
                    text.setAttribute('font-size', '3');
                    text.setAttribute('fill', '#FF9900');
                    text.setAttribute('opacity', '0'); // Texte invisible par défaut
                    text.textContent = marker.name;

                    // Ajouter des événements de survol
                    circle.addEventListener('mouseenter', function () {
                        text.setAttribute('opacity', '1'); // Afficher le texte au survol
                    });

                    circle.addEventListener('mouseleave', function () {
                        text.setAttribute('opacity', '0'); // Cacher le texte quand la souris quitte
                    });

                    //Ajout redirection vers escape game
                    circle.addEventListener('click', () => {
                        redirigerVersEscapeGame(marker.escapegameID); 
                    });

                    function redirigerVersEscapeGame(escapeGameId) {
                        console.log(`Redirection vers l'escape game avec l'ID: ${marker.escapegameID}`);
                        window.location.href = `index.php?action=egameDetail&id=${marker.escapegameID}`;
                    }

                    // Ajouter le cercle et le texte au groupe
                    markerGroup.appendChild(circle);
                    markerGroup.appendChild(text);

                    // Ajouter le groupe au SVG
                    regionSvg.appendChild(markerGroup);
                });

                // Afficher le détail de la région
                regionDetail.classList.add('active');
            }
        });
    });

    // Fermer le détail de la région
    closeButton.addEventListener('click', function () {
        regionDetail.classList.remove('active');
    });
});

