<?php

namespace controleur;

use OWeb\Type\Controleur;
use OWeb\Gerer\enTete;

/**
 * @author Oliver
 */
class home extends Controleur {

    protected function init(){
       $this->addEnTete(enTete::css, "articles.css");
    }

    protected function afficher(){
        
    }
}


?>
