<?php

namespace OWeb\gerer;
/**
 * Description of gerer_reglages
 *
 * @author oliver
 */
class Reglages {

	private static $instance = NULL;

    private $reglages;


	public static function Init(){
		if(self::$instance == NULL)
			self::$instance = new self();
		
		return self::$instance;
	}

	public static function getInstance(){
		return self::$instance;
	}

    /**
     *
     * @param <type> $fichier Le nom u fichier qu'Ã„Â°l faut charger
     * @param <type> $demendeur Celui qui demande le chargement du fichier
     * @return les reglages. Si le fichier n'est pas trouver ou contient une erreur retourn faux
     */
     public function chargerReglage($demendeur="", $fichier=null){

        if($fichier == null)
            $fichier = OWEB_DIR_CONFIG;

        if(!isset($this->reglages[$fichier]))
            self::chargerFichier($fichier);

        if(!\is_string($demendeur))
            $demendeur = \get_class($demendeur);

        if(isset($this->reglages[$fichier][$demendeur])){
            return $this->reglages[$fichier][$demendeur];
        }else
            return false;
    }


    private function chargerFichier($fichier=""){

        if(empty($fichier))$fichier=OWEB_DIR_CONFIG;

        if(!isset($this->reglages[$fichier])){
            $f = parse_ini_file($fichier, true);
            $this->reglages[$fichier] = $f;

        }
    }


    /**
     *
     * @param <type> $reglage_de Les reglages de qu'elle classe est ce que on recherche
     * @return les reglages. Si cette classe n'a pas de reglages retourne faux
     */
    private function getReglages($reglage_de){
        if(isset($this->reglages[get_class($reglage_de)]))return $this->reglages[get_class($demendeur)];
        else return false;
    }
}
?>
