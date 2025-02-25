<?php
require "controleur/ctlpages.class.php";
require "controleur/ctlauth.class.php";
require "controleur/ctlegames.class.php";
require "controleur/ReservationController.class.php";

class Rooter {
    private $ctlPage;
    private $ctlAuth;
    private $ctlEgames;
    private $ctlReservation;

    public function __construct() {
        $this->ctlEgames = new ctlEgames();
        $this->ctlPage = new CtlPage();
        $this->ctlAuth = new CtlAuth();
        $this->ctlReservation = new ReservationController();
    }

    private function handleJsonError($e) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode([
            'error' => $e->getMessage()
        ]);
        exit();
    }

    public function rooterRequete() {
        try {
            if (isset($_GET["action"])) {
                $action = $_GET["action"];
            } else {
                $action = "accueil";
            }

            switch($action) {
                case "accueil":
                    $this->ctlPage->accueil();
                    break;
                case "egames":
                    $this->ctlEgames->egames();
                    break;
                case "egameDetail":
                    $this->ctlEgames->egameDetail();
                    break;
                case "contact":
                    $this->ctlPage->contact();
                    break;
                case "getTimeSlots":
                case "createReservation":
                    try {
                        if ($action === "getTimeSlots") {
                            $this->ctlReservation->getTimeSlots();
                        } else {
                            $this->ctlReservation->createReservation();
                        }
                    } catch (Exception $e) {
                        $this->handleJsonError($e);
                    }
                    break;
                case "login":
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->ctlAuth->processLogin();
                    } else {
                        $this->ctlAuth->showLoginForm();
                    }
                    break;
                case "register":
                    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                        $this->ctlAuth->processRegister();
                    } else {
                        $this->ctlAuth->showRegisterForm();
                    }
                    break;
                case "logout":
                    $this->ctlAuth->logout();
                    break;
                case "profile":
                    $this->ctlAuth->showProfile();
                    break;
                case "update-profile-picture":
                    $this->ctlAuth->updateProfilePicture();
                    break;
                default:
                    throw new Exception("Action non valide");
            }
        } catch (Exception $e) {
            // Si c'est une requête AJAX, renvoyer une erreur JSON
            if (!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && 
                strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
                $this->handleJsonError($e);
            } else {
                $this->ctlPage->erreur($e->getMessage());
            }
        }
    }
}