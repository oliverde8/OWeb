<?php

namespace OWeb\gerer;

use OWeb\gerer\Evenments;

/**
 * @author De Cramer Oliver
 */
class Controleurs {
    
	private static $instance = NULL;

	private $controleur;

	private $controleurLoaded = false;
	private $controleurAffiche = false;
	
	public static function Init() {
		if (self::$instance == NULL)
			self::$instance = new self();
		return self::$instance;
	}

	public static function getInstance(){
		return self::$instance;
	}

	function __construct() {
		$evenment = \OWeb\Gerer\Evenments::Init();
		$evenment->addEvenment('Init@OWeb', $this, 'initControleurs');
		$evenment->addEvenment('Loaded@Controleur', $this, 'Controleur_Loaded');
	}

	public function initControleurs(){
		$oweb = \OWeb\OWeb::getInstance();
		$get = $oweb->getGet();
		$autoload = \OWeb\autoLoader::Init();
		
		if(isset($get['ctr'])){
			//Charger le Controleur Demande.
			if($autoload->classExists("Controleur\\".$get['ctr'])){
				$this->chargerControleur($get['ctr']);
				return;
			}elseif($autoload->classExists("Controleur\\".$get['ctr'].'\\'.\OWEB_DEFAULT_CONTROLEUR)){
				$this->chargerControleur($get['ctr'].'\\'.\OWEB_DEFAULT_CONTROLEUR);
				return;
			}

		}
		if($autoload->classExists("Controleur\\".\OWEB_DEFAULT_CONTROLEUR)){
			$this->chargerControleur(\OWEB_DEFAULT_CONTROLEUR);
		}
	}

	public function forcerControleur($ctr){
		$this->chargerControleur($ctr);
		if($this->controleurLoaded)$this->Controleur_Loaded();
		if($this->controleurAffiche)$this->afficher ();
	}

	public function forcerAffichage(){
		$this->afficher ();
	}

	private function chargerControleur($ctr){
		$className = "Controleur\\".$ctr;
		$this->controleur = new $className();
	}

	public function Controleur_Loaded(){
		//Une fois le controleur chargÃƒÂ© on peut comence a affectuer les action
		$this->controleurLoaded = true;

		$var = \OWeb\OWeb::getInstance()->getGet();
		$cpt = 0;
		while($cpt < 1){
			if(isset($var['action']))
				$this->controleur->faireAction($var['action'], false);

			$i = 1;
			foreach($var as $nom => $action){
				if(\preg_match('/^action[0-9]*/', $nom)){
					$this->controleur->faireAction($action, false);
				}
			}
			$cpt++;
		}
	}

	public function faireAction($nomAction){

	}

	public function afficher(){
		$this->controleurAffiche = true;
		$this->controleur->afficherPage();
	}
}
?>
