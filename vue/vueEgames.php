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
  <h2 class="content-title">
    <span data-translate="decouvrer">Découvrez les différents </span><br>
    <span class="content-title-span" data-translate="egames">Escape games</span>
  </h2>
  <div class="region-filter">
    <button class="filter-btn active" data-region="TOUT">TOUT</button>
    <button class="filter-btn" data-region="ALSACE" data-translate="alsace">ALSACE</button>
    <button class="filter-btn" data-region="LORRAINE" data-translate="lorraine">LORRAINE</button>
    <button class="filter-btn" data-region="FRANCHE-COMTE" data-translate="franche-comte">FRANCHE-COMTÉ</button>
  </div>
  <div class="egames-container">
    <?php
    if (isset($egames) && !empty($egames)) {
      echo '<div class="egames-grid">';
      foreach ($egames as $egame) {
        echo '<div class="egame-card" data-region="' . htmlspecialchars(strtoupper($egame['Region']['fr'])) . '">';
        echo '<div class="egame-image">';
        echo '<img src="' . htmlspecialchars($egame['image']) . '" alt="' . htmlspecialchars($egame['nom']) . '">';
        echo '</div>';
        echo '<div class="egame-info">';
        echo '<h2>' . htmlspecialchars($egame['nom']) . '</h2>';
        echo '<div class="egame-details">';
        echo '<p class="egame-details-region"><span data-translate="region">Région</span>: ' .
          '<span class="translated-region" ' .
          'data-fr="' . htmlspecialchars($egame['Region']['fr']) . '" ' .
          'data-en="' . htmlspecialchars($egame['Region']['en']) . '" ' .
          'data-de="' . htmlspecialchars($egame['Region']['de']) . '">' .
          htmlspecialchars($egame['Region']['fr']) . '</span> <br>
          <span data-translate="lieu">Lieu</span></strong>: ' . htmlspecialchars($egame['lieu']) . '</p>';

        echo '<p class="egame-details-duree"><span data-translate="duree">Durée</span>: ' . htmlspecialchars($egame['duree']) . ' <span data-translate="heures">heures</span></p>';
        echo '</div>';
        echo '<a href="index.php?action=egameDetail&id=' . htmlspecialchars($egame['id']) . '" class="adventure-btn" data-translate="aventure">À L\'AVENTURE</a>';
        echo '</div>';
        echo '</div>';
      }
      echo '</div>';
    } else {
      echo "<div class='reponse' data-translate='aucunegame'>Aucun escape game n'est enregistré dans la liste</div>";
    }
    ?>
  </div>
</div>


<script src="script/egames.js"></script>