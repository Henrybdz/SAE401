<?php
require "includes/error_handler.php";
require "includes/default_config.php";
require "controleur/rooter.class.php";

$rooter = new Rooter();
$rooter->rooterRequete();


require_once 'modele/Reservation.class.php';

$lastExecutionFile = 'last_execution.txt';

// Vérifie si la suppression a déjà été effectuée aujourd'hui
if (!file_exists($lastExecutionFile) || date('Y-m-d') > file_get_contents($lastExecutionFile)) {
    
    $reservation = new Reservation();
    $reservation->supprimerReservationsExpirees();
    file_put_contents($lastExecutionFile, date('Y-m-d')); // Stocke la date d'exécution
}