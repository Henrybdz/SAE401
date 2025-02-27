<?php
require_once "controleur/ReservationController.class.php";
?>

<div class="profile-page">
    <div class="profile-header">
        <div class="profile-image-container">
            <img src="images/profils/<?= htmlspecialchars($user['photo_profil']) ?>" alt="Photo de profil" class="profile-image-large">
            <form action="index.php?action=update-profile-picture" method="POST" enctype="multipart/form-data" class="profile-picture-form">
                <label for="photo" class="custom-file-upload" data-translate='changerphoto'>Changer la photo</label>
                <input type="file" id="photo" name="photo" accept="image/*" onchange="this.form.submit()" style="display: none;">
            </form>
        </div>
        <div class="profile-info">
            <h2><?= htmlspecialchars($user['username']) ?></h2>
            <div class="email-container">
                <p class="email" data-translate='emailprofil'>Email :</p>
                <p><?= htmlspecialchars($user['email']) ?></p>
            </div>
            <div class="date-container">
                <p class="member-since" data-translate='membre'>Membre depuis le :</p>
                <p><?= (new DateTime($user['date_inscription']))->format('d/m/Y') ?></p>
            </div>
            <div class="info-reservation">
                <h3 data-translate='mesreservations'>Mes reservations</h3>
                <?php 
                foreach ($reservationinfo as $reservation) {
                    foreach ($reservation as $key => $value) {
                        var_dump($key);
                        var_dump($value);
                    }
                }
                ?>
            </div>
        </div>
        
    </div>

    <?php if (isset($error)): ?>
        <div class="error-message"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
</div>