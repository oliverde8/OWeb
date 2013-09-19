<?php

namespace OWeb\type;

use OWeb\gerer\Extensions;
use OWeb\gerer\Reglages;
use OWeb\Gerer\Evenments;
/**
 * Description of extension
 *
 * @author De Cramer Oliver
 */
abstract class Extension extends \OWeb\utils\Singleton{

	protected $dir;
	//Carateristique de l'Extension
	private $_nom;
	private $_auteur;
	private $_version;
	private $_description;
	private $_website;
	//d
	private $actions;
	private $evenments;
	private $dependence;
	//Etapes
	private $OWeb_init = false;

	function __construct($dir) {

		$this->_nom = get_class($this);
		$this->_description = 'no Description';

		$this->dir = $dir;
		$evenment = \OWeb\Gerer\Evenments::getInstance();
		$evenment->addEvenment('Loaded@OWeb', $this, 'OWeb_Loaded');
		$this->init();
	}

	abstract protected function init();

	public function OWeb_Loaded() {

		if (!empty($this->dependence)) {
			foreach ($this->dependence as $dep) {

				try{
					$ext = Extensions::Init()->getExtension($dep->name);
					if (!$ext) {
						throw new \OWeb\Exception("");
					}else {
						$name2 = \str_replace('\\', '_', $dep->name);
						$name = "ext_" . $name2;
						$this->$name = $ext;
					}
				}catch (\OWeb\Exception $exception){
					print_r($exception);
					throw new \OWeb\Exception("Impossible de charger l'extension : " . $dep->name.". L'extention " . $this->_nom . " en a basoin pour fonctionner");
				}
			}
		}
	}

	/*	 * ********************************************
	  Les fonction Protected
	 * ******************************************* */

	protected function set_Auteur($auteur) {
		$this->_auteur = $auteur;
	}

	protected function set_Version($in_version) {
		$this->_version = $in_version;
	}

	protected function set_Description($desc) {
		$this->_description = $desc;
	}

	protected function set_Website($web) {
		$this->_website = $web;
	}

	public function add_Evenment($Nomevent, $fonction) {
		Evenments::addEvenment($Nomevent, $this, $fonction);
	}

	protected function chargerReglages($fichier = "") {
		$reglage = Reglages::Init();
		return $reglage->chargerReglage($this, $fichier);
	}

	protected function ajoutDepandence($plugin_name, $min_ver = null, $max_ver = null) {
		$dep = new Depandence($plugin_name, $min_ver, $max_ver);
		$this->dependence[] = $dep;
	}

	/*	 * ********************************************
	  Les fonction Public
	 * ******************************************* */

	public function get_Auteur() {
		return $this->_auteur;
	}

	public function get_Version() {
		return $this->_version;
	}

	public function get_Description() {
		return $this->_description;
	}

	public function get_WebSite() {
		return $this->_website;
	}

	public function goApi(){

	}

}
?>

