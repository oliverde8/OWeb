<?php

namespace OWeb;

use OWeb\gerer\Evenments;
use OWeb\gerer\Controleur;
use OWeb\gerer\enTete;
/**
 *
 * @author De Cramer Oliver
 */
class Template {

    private $gereur_erreurs;


    public function __construct($tmp, OWeb $OWeb, 
                                Gerer\Erreur $err){

        $this->gereur_controleurs = $ctr;
        $this->gereur_extensions = $ext;
        $this->gereur_reglages = $reg;
        $this->gereur_erreurs = $err;

        include OWEB_DIR_TEMPLATES."/".$tmp.".php";
    }

    /**
     * Permet d'afficher le contenu de la page
     */
    public function afficher(){
        Evenments::envoyerEvenment("AffciherContenu_Debut@OWeb");
        Controleur::afficher();
        Evenments::envoyerEvenment("AffciherContenu_Fin@OWeb");
    }

    public function enTete(){
        Evenments::envoyerEvenment("AffciherEnTete@OWeb");
        enTete::afficher();
    }

    private function ajoutEnTete($type, $code){
        enTete::ajoutEnTete($type, $code);
    }
}
?>
