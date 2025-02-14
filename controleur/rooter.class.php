<?php
require "controleur/ctlegames.class.php";
require "controleur/ctlpages.class.php";

class Rooter{
    private $ctlEgames;
    private $ctlPage;

    public function __construct(){ 
        $this->ctlEgames = new ctlEgames();
        $this->ctlPage = new ctlPage();
    }

    public function rooterRequete(){
        try {
            if (isset($_GET["action"])) {
              switch ($_GET["action"]) {
                case "egames":
                    $this->ctlEgames->egames();                                                            // Affichage de la liste des clients
                    break;
                case "contact";
                    $this->ctlPage->contact();  
                    break;
                default:
                  throw new Exception("Action non valide");
              }
            } else
              $this->ctlPage->accueil();
          } catch (Exception $e) {                                                      // Page d'erreur
            $this->ctlPage->erreur($e->getMessage());
          }
    }
}