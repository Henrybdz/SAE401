<?php
require_once "database.class.php";
class Egames extends database {

    public function getAllEgames() {
        $req = "SELECT * FROM egames";
        $egames = $this->execReq($req);
        return $egames;
    }
}