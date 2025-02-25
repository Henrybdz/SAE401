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

    public function egameDetail($id = null) {
        if ($id === null && isset($_GET['id'])) {
            $id = $_GET['id'];
        }

        if ($id === null) {
            header('Location: index.php?action=egames');
            exit();
        }

        $egame = $this->egames->getEgameById($id);
        if (!$egame) {
            header('Location: index.php?action=egames');
            exit();
        }

        $vue = new Vue('EgameDetail');
        $vue->afficher(array("egame" => $egame));
    }
}
