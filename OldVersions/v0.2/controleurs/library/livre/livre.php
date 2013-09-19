<?php

namespace controleur\library\livre;

use OWeb\Type\Controleur;
use OWeb\lib\variables\enTete;

/**
 * @author Oliver
 */
class livre extends Controleur {

    protected function init(){
       $this->add_EnTete(new enTete(enTete::$Css, "livre.css"));
    }

    protected function afficher(){

    }
}


?>
