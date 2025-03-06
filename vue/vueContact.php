<?php
$header = "<nav>
    <a href='index.php'>Accueil</a>
    <a href='index.php?action=egames'>Escape Games</a>
    <a href='index.php?action=contact'>Contact</a>
</nav>";
?>

<div class="contact-container">
    <div class="background-lines">
        <img src="images/img/background_rayure.png" alt="background">
    </div>
    <div class="contact-content">
        <h1 class="contact-title">
            NOUS
            <span class="contact-title-span">CONTACTER</span>
        </h1>

        <form class="contact-form">
            <div class="form-row">
                <div class="form-group">
                    <label for="nom">NOM</label>
                    <input type="text" id="nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="prenom">PRÉNOM</label>
                    <input type="text" id="prenom" name="prenom" required>
                </div>
            </div>

            <div class="form-group">
                <label for="mail">MAIL</label>
                <input type="text" id="mail" name="mail" required>
            </div>
            <div class="form-group">
                <label for="sujet">SUJET</label>
                <input type="text" id="sujet" name="sujet" required>
            </div>

            <div class="form-group">
                <label for="message">VOTRE MESSAGE</label>
                <textarea id="message" name="message" required></textarea>
            </div>

            <button type="submit" class="submit-btn">Envoyer</button>
        </form>
    </div>
</div>