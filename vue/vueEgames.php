<div class="hero-section">
  <div class="e-background-images">
    <img src="images/img/Fond-EscapeGames.png" alt="Labirynth" class="e-bg-mountains">
    <h2 class="e-hero-title">ESCAPE GAMES</h2>
    <img src="images/img/cloud.png" alt="Nuage" class="e-bg-cloud">
    <img src="images/img/cloud.png" alt="Nuage" class="e-bg-cloud-1">
  </div>
</div>
<div class="content-section-2"></div>
<div class="e-content-section">
  <div class="egames-container">
    <?php
    if (isset($egames) && !empty($egames)) {
      echo '<div class="egames-grid">';
      foreach ($egames as $egame) {
        echo '<a href="index.php?action=egameDetail&id=' . htmlspecialchars($egame['id']) . '" class="egame-card">';
        // Titre traduit
        echo '<h2>' . htmlspecialchars($egame['nom']) . '</h2>';

        echo '<p><strong><span data-translate="duree">Durée</span></strong>: ' . htmlspecialchars($egame['duree']) . ' <span data-translate="heures">heures</span></p>';

        // Description traduite
        echo '<p><strong><span data-translate="description">Description</span></strong>: ' .
          '<span class="translated-description" ' .
          'data-fr="' . htmlspecialchars($egame['description']['fr']) . '" ' .
          'data-en="' . htmlspecialchars($egame['description']['en']) . '" ' .
          'data-de="' . htmlspecialchars($egame['description']['de']) . '">' .
          htmlspecialchars($egame['description']['fr']) . '</span></p>';

        echo '<p><strong><span data-translate="lieu">Lieu</span></strong>: ' . htmlspecialchars($egame['lieu']) . '</p>';
        echo '</a>';
      }
      echo '</div>';
    } else {
      echo "<div class='reponse' data-translate='aucunegame'>Aucun escape game n'est enregistré dans la liste</div>";
    }
    ?>
  </div>
</div>


<script src="script/egames.js"></script>