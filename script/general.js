// Sélectionner l'image et la div profile-hover
const profileImage = document.querySelector('.profile-image-wrapper img');
const profileHover = document.querySelector('.profile-hover');

// Ajouter un écouteur d'événements pour le clic sur l'image
profileImage.addEventListener('click', () => {
    if (profileHover.style.display === 'flex') {
        profileHover.style.display = 'none'; // Cacher si déjà visible
    } else {
        profileHover.style.display = 'flex'; // Afficher
    }
});
