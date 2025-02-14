<?php
  $header = "<nav>
    <a href='index.php' data-translate='accueil'>Accueil</a>
    <a href='index.php?action=egames' data-translate='egames'>Escape Games</a>
    <a href='index.php?action=contact' data-translate='contact'>Contact</a>
  </nav>";

  $contenu = "";
?>

<div class="egames-container">
  <?php
    if (isset($egames) && !empty($egames)) {
      echo '<div class="egames-grid">';
      foreach($egames as $egame) {
        echo '<div class="egame-card">';
        // Titre traduit
        echo '<h2 class="translated-title" ' .
             'data-fr="' . htmlspecialchars($egame['nom']['fr']) . '" ' .
             'data-en="' . htmlspecialchars($egame['nom']['en']) . '" ' .
             'data-de="' . htmlspecialchars($egame['nom']['de']) . '">' .
             htmlspecialchars($egame['nom']['fr']) . '</h2>';
        
        echo '<p><strong><span data-translate="duree">Durée</span></strong>: ' . htmlspecialchars($egame['duree']) . ' <span data-translate="heures">heures</span></p>';
        
        // Description traduite
        echo '<p><strong><span data-translate="description">Description</span></strong>: ' . 
             '<span class="translated-description" ' .
             'data-fr="' . htmlspecialchars($egame['description']['fr']) . '" ' .
             'data-en="' . htmlspecialchars($egame['description']['en']) . '" ' .
             'data-de="' . htmlspecialchars($egame['description']['de']) . '">' .
             htmlspecialchars($egame['description']['fr']) . '</span></p>';
        
        echo '<p><strong><span data-translate="lieu">Lieu</span></strong>: ' . htmlspecialchars($egame['lieu']) . '</p>';
        echo '</div>';
      }
      echo '</div>';
    }
    else {
      echo "<div class='reponse' data-translate='aucunegame'>Aucun escape game n'est enregistré dans la liste</div>";
    }
  ?>
</div>

<script>
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
</script>