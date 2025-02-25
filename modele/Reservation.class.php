<?php
require_once 'modele/database.class.php';
require_once 'modele/TimeSlot.class.php';

class Reservation extends database {
    private $id;
    private $user_id;
    private $egame_id;
    private $time_slot_id;
    private $date;
    private $status;

    public function __construct($user_id = null, $egame_id = null, $time_slot_id = null, $date = null) {
        $this->user_id = $user_id;
        $this->egame_id = $egame_id;
        $this->time_slot_id = $time_slot_id;
        $this->date = $date;
        $this->status = 'pending';
    }

    public function save() {
        try {
            // Vérifier si le créneau est toujours disponible
            if (!TimeSlot::isSlotAvailable($this->time_slot_id)) {
                throw new Exception("Ce créneau n'est plus disponible");
            }

            $pdo = $this->connexionBDD();
            $pdo->beginTransaction();

            try {
                $query = "INSERT INTO reservations (user_id, egame_id, time_slot_id, date, status) 
                         VALUES (:user_id, :egame_id, :time_slot_id, :date, :status)";
                
                $stmt = $pdo->prepare($query);
                $success = $stmt->execute([
                    'user_id' => $this->user_id,
                    'egame_id' => $this->egame_id,
                    'time_slot_id' => $this->time_slot_id,
                    'date' => $this->date,
                    'status' => $this->status
                ]);

                if (!$success) {
                    throw new Exception("Erreur lors de la création de la réservation");
                }

                // Marquer le créneau horaire comme non disponible
                if (!TimeSlot::markAsUnavailable($this->time_slot_id)) {
                    throw new Exception("Erreur lors de la mise à jour du créneau horaire");
                }
                
                $pdo->commit();
                return true;
            } catch (Exception $e) {
                $pdo->rollBack();
                throw $e;
            }
        } catch (Exception $e) {
            throw new Exception("Erreur lors de la création de la réservation : " . $e->getMessage());
        }
    }

    public static function getUserReservations($user_id) {
        try {
            $instance = new self();
            $query = "SELECT r.*, e.nom as egame_name, ts.start_time, ts.end_time 
                     FROM reservations r
                     JOIN egames e ON r.egame_id = e.id
                     JOIN time_slots ts ON r.time_slot_id = ts.id
                     WHERE r.user_id = :user_id
                     ORDER BY r.date ASC, ts.start_time ASC";
            
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
}
