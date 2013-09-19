<?php

namespace OWeb\Gerer;

use OWeb\OWeb;

/**
 * Cette classe gere la totalite des controleurs qui lui sont enregistre.
 * Elle va envoyer les evenments au controleurs et elle va actioner les actionneurs des controleurs
 *
 * @author De Cramer Oliver
 */
class Controleur {

    static private $controleurs; //liste des controleurs

    static private $controleur_principale;


    /**
     * Va initier tous les controleurs. Apres cette etape on ne peut plus ajouter des controleurs
     *
     * @return <type>
     */
    static public function init_controleurs(){

        //On controle si il'y a des controleur charger sinon on arrete
        if(empty(self::$controleurs))return;

        //On init les controleurs
        foreach (self::$controleurs as $ext) {
            $ext->OWeb_init();
        }
    }

    /**
     * Permet d'ajouter des controleurs
     *
     * @param OWeb_Type_Controleur $ctr
     * @param <type> $main Speifie si le controleur principale est celui qui va faire l'affichage
     */
    static public function addControleur(OWeb_Type_Controleur &$ctr, $main=false){
       self::$controleurs[get_class($ctr)] = $ctr;
       if($main)self::$controleur_principale = $ctr;
    }

    /**
     * Permet de reuperer un controleur
     * @param Strring $ctrl
     * @return <type> Le controleur demandé si il n'existe pas alors faux
     */
    static public function getControleur(Strring $ctrl){
        if(!isset(self::$controleurs[$ctrl]))
                    return false;
        
        return self::$controleurs[$ctrl];
    }
    
    /**
     * Activation des actionneur POST
     * 
     * @param <type> Nom de l'action
     */
    static public function faire_PostAction($action){
        foreach (self::$controleurs as $ctrl) {
                    $ctrl->DoAction($action,true);
        }
    }
    
    /**
    * Activation des actionneur GET
    * 
    * @param <type> Nom de l'action
    */
    static public function faire_GetAction($action){
        foreach (self::$controleurs as $ctrl) {
                    $ctrl->DoAction($action,false);
        }
    }

    /**
     * Va afficher le vue du controleur
     */
    static public function afficher(){
        self::$controleur_principale->afficherPage();
    }

    static public function afficher_enTete(){
        foreach (self::$controleurs as $ctrl) {
            $hs = $ctrl->get_EnTetes();
            
            if($hs != false && !empty($hs)){
                foreach ($hs as $h) {
                    echo $h->getCode();
                }
            }            
        }
    }
}


?>
