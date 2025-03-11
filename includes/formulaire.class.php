<?php

class Formulaire{
    private $values;

    public function __construct($data = array()) {
        $this->values = $data;
    }

    private function getValue($key) {
        return $this->values[$key] ?? "";
    }

    public function inputTextconnection($name, $label="", $translate="") {
        $value = $this->getValue($name);
        return "<div class='form-group'>
                    <label for='$name' data-translate='$translate'>$label</label>
                    <input type='text' id='$name' name='$name' value='$value' required>
                </div>";
    }
    public function inputMailconnection($name, $label="", $translate="") {
        $value = $this->getValue($name);
        return "<div class='form-group'>
                    <label for='$name' data-translate='$translate'>$label</label>
                    <input type='email' id='$name' name='$name' value='$value' required>
                </div>";
    }
    public function inputMDPconnection($name, $label="", $translate="") {
        $value = $this->getValue($name);
        return "<div class='form-group'>
                    <label for='$name' data-translate='$translate'>$label</label>
                    <input type='password' id='$name' name='$name' value='$value' required>
                </div>";
    }
    public function inputTextinscription($name, $label="", $translate="") {
        $value = $this->getValue($name);
        return "<div class='form-group'>
                    <label for='$name' data-translate='$translate'>$label</label>
                    <input type='text' id='$name' name='$name' value='$value' required>
                </div>";
    }
    public function inputTextcontact($name, $label="", $translate="") {
        $value = $this->getValue($name);
        return "<div class='form-group'>
                    <label for='$name' data-translate='$translate'>$label</label>
                    <input type='text' id='$name' name='$name' value='$value' required>
                </div>";
    }

    public function inputTextAreacontact($name, $label="", $translate="") {
        $value = $this->getValue($name);
        return "<div class='form-group'>
                    <label for='$name' data-translate='$translate'>$label</label>
                    <textarea id='$name' name='$name' value='$value' required></textarea>
                </div>";
    }

    public function submitconnection($name) {
        return "<button type='submit' name='$name' data-translate='seconnecter'>Se connecter</button>";
    }
    public function submitinscription($name) {
        return "<button type='submit' name='$name' data-translate='sinscrire'>S'inscrire</button>";
    }
    public function submitcontact($name, $translate="") {
        return "<button class='submit-btn' name='$name' data-translate='$translate'>Envoyer</button>";
    }
}