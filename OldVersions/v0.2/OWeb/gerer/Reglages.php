<?php

namespace OWeb\Gerer;
/**
 * Description of gerer_reglages
 *
 * @author oliver
 */
class Reglages {


    static private $reglages;

    /**
     *
     * @param <type> $fichier Le nom u fichier qu'İl faut charger
     * @param <type> $demendeur Celui qui demande le chargement du fichier
     * @return les reglages. Si le fichier n'est pas trouver ou contient une erreur retourn faux
     */
    static public function chargerReglage($demendeur="", $fichier=null){

        if($fichier == null)
            $fichier = OWEB_DIR_CONFIG;

        if(!isset(self::$reglages[$fichier]))
            self::chargerFichier($fichier);

        if(!\is_string($demendeur))
            $demendeur = \get_class($demendeur);

        if(isset(self::$reglages[$fichier][$demendeur])){
            return self::$reglages[$fichier][$demendeur];
        }else
            return false;
    }

    
    static function chargerFichier($fichier=""){

        if(empty($fichier))$fichier=OWEB_DIR_CONFIG;

        if(!isset(self::$reglages[$fichier])){
            $f = parse_ini_file($fichier, true);
            self::$reglages[$fichier] = $f;

        }
    }


    /**
     *
     * @param <type> $reglage_de Les reglages de qu'elle classe est ce que on recherche
     * @return les reglages. Si cette classe n'a pas de reglages retourne faux
     */
    static function getReglages($reglage_de){
        if(isset(self::$reglages[get_class($reglage_de)]))return self::$reglages[get_class($demendeur)];
        else return false;
    }

    static function getReglage(){
        return self::$reglages["OWeb"];
    }
}
?>
