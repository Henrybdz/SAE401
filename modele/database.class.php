<?php
/*********************************************************
Classe permettant la communication avec la base de données
*********************************************************/
abstract class database {

  // Objet permettant la connexion à la BDD
  private $bdd;

  /*******************************************************
  Execution d'une requête simple 
    Entrée : 
      req [string] : Requête SQL
  
    Retour : 
      [array] : Tableau associatif contenant le résultat de la requête
  *******************************************************/
  protected function execReq($req) {
    try {
        $reponse = $this->connexionBDD()->query($req);
        if ($reponse === false) {
            throw new Exception("Erreur lors de l'exécution de la requête");
        }
        return $reponse->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw new Exception("Erreur d'exécution de la requête : " . $e->getMessage());
    }
  }

  /*******************************************************
  Execution d'une requête préparée 
    Entrée : 
      req [string] : Requête préparée
      data [array] : Tableau contenant les données utilisées par la requête préparée
  
    Retour : 
      [array] : Tableau associatif contenant le résultat de la requête
  *******************************************************/
  protected function execReqPrep($req, $data) {
    try {
        $reponse = $this->connexionBDD()->prepare($req);
        if ($reponse === false) {
            throw new Exception("Erreur lors de la préparation de la requête");
        }
        
        if (!$reponse->execute($data)) {
            throw new Exception("Erreur lors de l'exécution de la requête préparée");
        }
        
        return $reponse->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
        throw new Exception("Erreur d'exécution de la requête préparée : " . $e->getMessage());
    }
  }
  
  /*******************************************************
  Connexion à la BDD à partir des paramètres de configuration
    Entrée : 
      
    Retour : 
      [object] : Objet de type PDO
  *******************************************************/
  protected function connexionBDD() {
    global $Conf;
    if (!isset($this->bdd)) {    // Si la connexion à la BDD n'est pas encore établie
      try {  // Connexion à la base de données et initialisation de la propriété bdd
        $options = array(
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );
        $this->bdd = new PDO(
            'mysql:host='.$Conf->DBHOST.';dbname='.$Conf->DBNAME,
            $Conf->DBUSER,
            $Conf->DBPWD,
            $options
        );
      } catch(Exception $err) {   // Erreur lors de la connexion à la BDD
        throw new Exception("Erreur de connexion à la base de données : " . $err->getMessage());
      }
    }
    return $this->bdd;
  }
}