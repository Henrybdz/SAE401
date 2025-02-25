<?php
require_once 'modele/database.class.php';

class TimeSlot extends database {
    private $id;
    private $start_time;
    private $end_time;
    private $is_available;
    private $egame_id;
    private $date;

    public function __construct($start_time = null, $end_time = null, $egame_id = null, $date = null, $is_available = true) {
        $this->start_time = $start_time;
        $this->end_time = $end_time;
        $this->egame_id = $egame_id;
        $this->date = $date;
        $this->is_available = $is_available;
    }

    public static function getAvailableTimeSlots($date, $egame_id) {
        try {
            $instance = new self();
            
            // Charger les créneaux horaires depuis le JSON
            $jsonPath = __DIR__ . '/../Donnees/default_time_slots.json';
            $defaultSlots = json_decode(file_get_contents($jsonPath), true)['time_slots'];

            // Récupérer les réservations pour la date et l'egame spécifiques
            $query = "SELECT * FROM reservations WHERE egame_id = :egame_id AND date = :date";
            
            try {
                $reservedSlots = $instance->execReqPrep($query, [
                    'egame_id' => $egame_id,
                    'date' => $date
                ]);
            } catch (Exception $e) {
                $reservedSlots = [];
            }

            // Convertir les créneaux réservés en tableau associatif
            $reservedSlotsMap = [];
            foreach ($reservedSlots as $slot) {
                // Retirer les secondes des heures pour la comparaison
                $startTime = substr($slot['start_time'], 0, 5); // "09:00:00" devient "09:00"
                $endTime = substr($slot['end_time'], 0, 5);     // "10:00:00" devient "10:00"
                $key = $startTime . '-' . $endTime;
                $reservedSlotsMap[$key] = true;
            }

            // Créer deux tableaux séparés pour les créneaux
            $availableSlots = [];
            $reservedSlotsArray = [];

            foreach ($defaultSlots as $slot) {
                $id = str_replace(':', '', $slot['start_time']);
                $key = $slot['start_time'] . '-' . $slot['end_time'];
                
                $slotData = [
                    'id' => $id,
                    'start_time' => $slot['start_time'],
                    'end_time' => $slot['end_time'],
                    'date' => $date
                ];

                if (isset($reservedSlotsMap[$key])) {
                    $slotData['is_available'] = false;
                    $reservedSlotsArray[] = $slotData;
                } else {
                    $slotData['is_available'] = true;
                    $availableSlots[] = $slotData;
                }
            }

            // Combiner les tableaux
            $allSlots = array_merge($availableSlots, $reservedSlotsArray);

            return $allSlots;

        } catch (Exception $e) {
            throw new Exception("Erreur lors de la récupération des créneaux : " . $e->getMessage());
        }
    }

    public function save() {
        try {
            $query = "INSERT INTO reservations (start_time, end_time, egame_id, date) 
                     VALUES (:start_time, :end_time, :egame_id, :date)";
            
            $stmt = $this->connexionBDD()->prepare($query);
            $result = $stmt->execute([
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'egame_id' => $this->egame_id,
                'date' => $this->date
            ]);

            if ($result === false) {
                throw new Exception("Erreur lors de l'enregistrement du créneau horaire");
            }

            $this->id = $this->connexionBDD()->lastInsertId();
            return $this->id;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public static function markAsUnavailable($slot_id) {
        // Cette méthode n'est plus nécessaire car nous gérons la disponibilité via les réservations
        return true;
    }

    public static function isSlotAvailable($slot_id) {
        try {
            $instance = new self();
            
            // Convertir l'ID en format heure (par exemple "0900" devient "09:00")
            $start_time = substr_replace($slot_id, ':', 2, 0);
            
            // Vérifier si ce créneau est déjà réservé
            $query = "SELECT COUNT(*) as count 
                     FROM reservations 
                     WHERE start_time = :start_time";
            
            $result = $instance->execReqPrep($query, [
                'start_time' => $start_time
            ]);

            return !empty($result) && $result[0]['count'] === 0;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public static function generateTimeSlotsForDays($egame_id, $days = 7, $start_hour = 10, $end_hour = 20, $duration_minutes = 90) {
        try {
            $instance = new self();
            $success = true;
            
            for ($day = 0; $day < $days; $day++) {
                $date = date('Y-m-d', strtotime("+$day days"));
                $current_time = $start_hour * 60; // Conversion en minutes
                $end_time = $end_hour * 60;
                
                while ($current_time + $duration_minutes <= $end_time) {
                    $start = sprintf("%02d:%02d:00", floor($current_time / 60), $current_time % 60);
                    $end = sprintf("%02d:%02d:00", floor(($current_time + $duration_minutes) / 60), ($current_time + $duration_minutes) % 60);
                    
                    $timeSlot = new TimeSlot($start, $end, $egame_id, $date);
                    if (!$timeSlot->save()) {
                        throw new Exception("Erreur lors de la création d'un créneau horaire");
                    }
                    
                    $current_time += $duration_minutes + 30; // 30 minutes de pause entre les sessions
                }
            }
            
            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }
}
