<?php
namespace OWeb\Gerer;

use OWeb\OWeb;
use OWeb\AutoLoader;
/**
 * Description of gerer_extensions
 *
 * @author De Cramer Oliver
 */
class Extensions {

    static private $extensions = array();

    static private $peutCharger = true;

    //Etapes
    static private $OWeb_init = false;


    static public function init_extensions(){

        //On controle si il'y a des extension charger sinon on arrete
        if(empty(self::$extensions))return;

        //On init les extension
        foreach (self::$extensions as $ext) {
            $ext->OWeb_init();
        }
    }

    static public function getExtension($ext) {
        $name="Extension\\".$ext;

		\print_r(self::$extensions);

        if (isset(self::$extensions[$name])){
            return self::$extensions[$name];

        }elseif (self::$peutCharger){
            if(AutoLoader::extension($ext)){
                return self::$extensions[$name];
            }else return false;
        }
        else{
            return false;
        }
    }
    
    static public function enregistreExtension($ext,$name){

        if(!isset(self::$extensions[$name])){
            self::$extensions[$name]=$ext;
            return true;
        }else{
            trigger_error("l'extension ".$name." a deja ete initialiser", Erreur::NOTIFICATION);
        }
    }

    static public function chargerExtension($name){
         //Si OWeb a deja ete initialiser alors on ne peut plus charger des extension
        if(self::$OWeb_init){
            $msg = "Chargement de l'extension '".$name."' au mauvais moment. Les extension doivent etre charge avant l'initialisation";
            trigger_error($msg, Erreur::WARNING);
        }

        //On controle voir si l'extesnsion n'existe pas deja
        if(!isset(self::$extensions[$name])){
            //Charger l'extension
            AutoLoader::extension($name);
        }
    }
}

?>
