<?php
require_once "vue/vue.class.php";
class ctlPage
{
    public function accueil()
    {
        $page = new vue("Accueil");
        $page->afficher(array());
    }

    public function erreur($message)
    {
        $page = new vue("Erreur");
        $page->afficher(array("message" => $message));
    }

    public function contact(){
        $page = new Vue("Contact");
        $page->afficher(array());
    }

}