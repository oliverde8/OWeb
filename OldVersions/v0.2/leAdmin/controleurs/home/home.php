<?php
class controleur_home extends OWeb_Type_Controleur {

    protected function init(){
       $this->add_EnTete(new OWeb_variables_enTete(OWeb_variables_enTete::$Css, "articles.css"));
    }

    protected function afficher(){

    }
}
?>
