<?php
require_once 'modele/database.class.php';
require_once 'modele/TimeSlot.class.php';

class Reservation extends database {
    private $id;
    private $user_id;
    private $egame_id;
    private $start_time;
    private $end_time;
    private $date;


    public function __construct($user_id = null, $egame_id = null, $start_time = null, $end_time = null, $date = null) {
        $this->user_id = $user_id;
        $this->egame_id = $egame_id;
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->date = $date;
    }

    public function save() {
        try {
            $pdo = $this->connexionBDD();
            $pdo->beginTransaction();

            try {
                // Vérifier si le créneau est déjà réservé
                $checkQuery = "SELECT COUNT(*) FROM reservations 
                             WHERE egame_id = :egame_id 
                             AND date = :date 
                             AND start_time = :start_time 
                             AND end_time = :end_time";
                
                $stmt = $pdo->prepare($checkQuery);
                $stmt->execute([
                    'egame_id' => $this->egame_id,
                    'date' => $this->date,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time
                ]);
                
                if ($stmt->fetchColumn() > 0) {
                    throw new Exception("Ce créneau est déjà réservé");
                }

                // Insérer la réservation
                $query = "INSERT INTO reservations (user_id, egame_id, start_time, end_time, date) 
                         VALUES (:user_id, :egame_id, :start_time, :end_time, :date)";
                
                $stmt = $pdo->prepare($query);
                $success = $stmt->execute([
                    'user_id' => $this->user_id,
                    'egame_id' => $this->egame_id,
                    'start_time' => $this->start_time,
                    'end_time' => $this->end_time,
                    'date' => $this->date
                ]);

                if (!$success) {
                    throw new Exception("Erreur lors de l'enregistrement de la réservation");
                }
                
                $pdo->commit();
                return true;
            } catch (Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la réservation : " . $e->getMessage());
        }
    }

    public function getUserReservations($user_id) {
        try {
            $instance = new self();
            $query = "SELECT r.egame_id,r.date, r.start_time, r.end_time 
                     FROM reservations r
                     WHERE r.user_id = :user_id
                     ORDER BY r.date ASC, r.start_time ASC";
            
            $result = $instance->execReqPrep($query, ['user_id' => $user_id]);
            
            if ($result === false) {
                throw new Exception("Erreur lors de la récupération des réservations");
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public function updateStatus($status) {
        try {
            if (!$this->id) {
                throw new Exception("ID de réservation non défini");
            }
            
            $query = "UPDATE reservations SET status = :status WHERE id = :id";
            $result = $this->execReqPrep($query, [
                'status' => $status,
                'id' => $this->id
            ]);

            if ($result === false) {
                throw new Exception("Erreur lors de la mise à jour du statut");
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public function supprimerReservationsExpirees() {
        try {
            $instance = new self();
            $currentDateTime = date('Y-m-d H:i:s'); // Obtenir la date et l'heure actuelles
    
            // Préparer la requête de suppression
            $sql = "DELETE FROM reservations WHERE CONCAT(date, ' ', end_time) < ?";
            $deletedCount = $instance->execReqPrep($sql, [$currentDateTime]);

            return $deletedCount; // Retourner le nombre de lignes supprimées
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la suppression des réservations expirées : " . $e->getMessage());
        }
    }
}
