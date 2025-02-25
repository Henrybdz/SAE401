<?php
require_once 'modele/TimeSlot.class.php';
require_once 'modele/Reservation.class.php';
require_once 'modele/database.class.php';

class ReservationController extends database {
    private function sendJsonResponse($data, $statusCode = 200) {
        http_response_code($statusCode);
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }

    private function checkAuth() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['user']) || !isset($_SESSION['user']['id'])) {
            $this->sendJsonResponse([
                'success' => false,
                'message' => 'auth_required'
            ], 401);
        }
        return $_SESSION['user']['id'];
    }

    public function getTimeSlots() {
        try {
            if (!isset($_GET['date']) || !isset($_GET['egame_id'])) {
                $this->sendJsonResponse(
                    ['error' => 'Paramètres manquants'], 
                    400
                );
            }

            $date = $_GET['date'];
            $egame_id = $_GET['egame_id'];

            $timeSlots = TimeSlot::getAvailableTimeSlots($date, $egame_id);
            
            if (empty($timeSlots)) {
                $this->sendJsonResponse([
                    'timeSlots' => [],
                    'message' => 'Aucun créneau disponible pour cette date'
                ]);
            } else {
                $this->sendJsonResponse([
                    'timeSlots' => $timeSlots
                ]);
            }
        } catch (Exception $e) {
            $this->sendJsonResponse([
                'error' => 'Erreur serveur: ' . $e->getMessage()
            ], 500);
        }
    }

    public function createReservation() {
        try {
            // Vérifier si l'utilisateur est connecté
            $user_id = $this->checkAuth();

            $jsonData = file_get_contents('php://input');
            if (!$jsonData) {
                $this->sendJsonResponse([
                    'success' => false,
                    'message' => 'Données JSON manquantes'
                ], 400);
            }

            $data = json_decode($jsonData, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                $this->sendJsonResponse([
                    'success' => false,
                    'message' => 'JSON invalide: ' . json_last_error_msg()
                ], 400);
            }

            if (!isset($data['egame_id']) || !isset($data['start_time']) || !isset($data['end_time']) || !isset($data['date'])) {
                $this->sendJsonResponse([
                    'success' => false,
                    'message' => 'Paramètres manquants'
                ], 400);
            }

            // Vérifier si le créneau est toujours disponible
            $query = "SELECT COUNT(*) as count FROM reservations 
                     WHERE egame_id = :egame_id 
                     AND date = :date 
                     AND start_time = :start_time 
                     AND end_time = :end_time";
            
            $result = $this->execReqPrep($query, [
                'egame_id' => $data['egame_id'],
                'date' => $data['date'],
                'start_time' => $data['start_time'],
                'end_time' => $data['end_time']
            ]);

            if ($result[0]['count'] > 0) {
                $this->sendJsonResponse([
                    'success' => false,
                    'message' => 'Ce créneau n\'est plus disponible'
                ], 409);
            }

            $reservation = new Reservation(
                $user_id,
                $data['egame_id'],
                $data['start_time'],
                $data['end_time'],
                $data['date']
            );

            if ($reservation->save()) {
                $this->sendJsonResponse([
                    'success' => true,
                    'message' => 'Réservation créée avec succès'
                ]);
            } else {
                $this->sendJsonResponse([
                    'success' => false,
                    'message' => 'Erreur lors de la création de la réservation'
                ], 500);
            }
        } catch (Exception $e) {
            $this->sendJsonResponse([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}
