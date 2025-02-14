<?php
require_once "modele/egames.class.php";
class ctlEgames{
    private $egames;

    public function __construct(){
        $this->egames = new Egames();
    }

    public function egames(){
        $egames = $this->egames->getAllEgames();
        $vue = new Vue('egames');
        $vue->afficher(array("egames" => $egames));
    }
}
