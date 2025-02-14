<?php
$header = "<nav>
    <a href='index.php'>Accueil</a>
    <a href='index.php?action=egames'>Escape Games</a>
    <a href='index.php?action=contact'>Contact</a>
</nav>";
?>

<div class="resultat">
  <?php
    if (count($egames)) {
      echo '<div class="egames-grid">';
      foreach($egames as $egame) {
        echo '<div class="egame-card">';
        echo '<h2>' . htmlspecialchars($egame['nom']) . '</h2>';
        echo '<p><strong>Durée</strong>: ' . htmlspecialchars($egame['duree']) . ' <span data-translate="heures">heures</span></p>';
        echo '<p><strong>Description</strong>: ' . htmlspecialchars($egame['description']) . '</p>';
        echo '<p><strong>Lieu</strong>: ' . htmlspecialchars($egame['lieu']) . '</p>';
        echo '</div>';
      }
      echo '</div>';
    }
    else {
      echo "<div class='reponse'>Aucun escape game n'est enregistré dans la liste</div>";
    }
  ?>
</div>