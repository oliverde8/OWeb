<?php

namespace OWeb;

use OWeb\Gerer\Evenments;
use OWeb\Gerer\Controleurs;
use OWeb\Gerer\enTete;
/**
 *
 * @author De Cramer Oliver
 */
class Template {

    private $gereur_evenment;


    public function __construct($tmp, $gerreurEvenment){

		$this->gereur_evenment = $gerreurEvenment;
        include OWEB_DIR_TEMPLATES."/".$tmp.".php";

    }

    /**
     * Permet d'afficher le contenu de la page
     */
    public function afficher(){
		$this->gereur_evenment->envoyerEvenment("AffciherContenu_Debut@OWeb");
		gerer\Controleurs::getInstance()->afficher();
        $this->gereur_evenment->envoyerEvenment("AffciherContenu_Fin@OWeb");
    }

	public function enTete(){
        $this->gereur_evenment->envoyerEvenment("AffciherEnTete@OWeb");
        enTete::afficher();
    }

    private function ajoutEnTete($type, $code){
        enTete::ajoutEnTete($type, $code);
    }
}
?>
