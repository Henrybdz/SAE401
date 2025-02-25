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
            $query = "SELECT id, start_time, end_time, date, is_available 
                     FROM time_slots 
                     WHERE egame_id = :egame_id 
                     AND date = :date 
                     AND is_available = true
                     ORDER BY start_time ASC";
            
            $result = $instance->execReqPrep($query, [
                'egame_id' => $egame_id,
                'date' => $date
            ]);

            if ($result === false) {
                throw new Exception("Erreur lors de la récupération des créneaux horaires");
            }

            return $result;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public function save() {
        try {
            $query = "INSERT INTO time_slots (start_time, end_time, egame_id, date, is_available) 
                     VALUES (:start_time, :end_time, :egame_id, :date, :is_available)";
            
            $result = $this->execReqPrep($query, [
                'start_time' => $this->start_time,
                'end_time' => $this->end_time,
                'egame_id' => $this->egame_id,
                'date' => $this->date,
                'is_available' => $this->is_available ? 1 : 0
            ]);

            if ($result === false) {
                throw new Exception("Erreur lors de l'enregistrement du créneau horaire");
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public static function markAsUnavailable($slot_id) {
        try {
            $instance = new self();
            $query = "UPDATE time_slots SET is_available = false WHERE id = :id";
            $result = $instance->execReqPrep($query, ['id' => $slot_id]);

            if ($result === false) {
                throw new Exception("Erreur lors de la mise à jour du créneau horaire");
            }

            return true;
        } catch (Exception $e) {
            throw new Exception("Erreur : " . $e->getMessage());
        }
    }

    public static function isSlotAvailable($slot_id) {
        try {
            $instance = new self();
            $query = "SELECT COUNT(*) as count FROM time_slots 
                     WHERE id = :id AND is_available = true";
            
            $result = $instance->execReqPrep($query, ['id' => $slot_id]);
            
            if ($result === false) {
                throw new Exception("Erreur lors de la vérification du créneau horaire");
            }

            return !empty($result) && $result[0]['count'] > 0;
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
