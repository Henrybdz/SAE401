<?php
class Egames {
    private $egamesData;

    public function __construct() {
        // Charger les données du fichier JSON
        $jsonContent = file_get_contents('Donnees/egames.json');
        $this->egamesData = json_decode($jsonContent, true);
    }

    public function getAllEgames() {
        return $this->egamesData['egames'];
    }

    public function getEgameById($id) {
        foreach ($this->egamesData['egames'] as $egame) {
            if ($egame['id'] == $id) {
                return $egame;
            }
        }
        return null;
    }
}
