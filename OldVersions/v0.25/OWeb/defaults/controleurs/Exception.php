<?php

namespace controleur;



/**
 * @author Oliver
 */
class Exception extends \OWeb\Type\Controleur {

    protected function init(){

    }

    protected function afficher(){

        $erreures = \OWeb\gerer\Exception::getInstance();
		print_r($erreures->get_erreures());
		print_r($erreures->get_exceptions());
    }
}


?>
