<?php

namespace OWeb\gerer;

use OWeb\OWeb;
use OWeb\AutoLoader;

/**
 * Description of gerer_extensions
 *
 * @author De Cramer Oliver
 */
class Extensions {

	static private $instance = NULL;

	private $extensions = array();
	private $peutCharger = true;
	
	//Le autoaLoader
	private $autoLoader;


	public static function Init() {
		if (self::$instance == NULL)
			self::$instance = new self();
		return self::$instance;
	}

	public static function getInstance() {
		return self::$instance;
	}

	function __construct() {
		$this->autoLoader = \OWeb\autoLoader::Init();
		$evenment = \OWeb\Gerer\Evenments::Init();
		//$evenment->addEvenment('Init@OWeb', $this, 'init_extensions');
	}

	public function getExtension($ext) {
		$name = "Extension\\".$ext;

		if (isset($this->extensions[$name])) {
			return $this->extensions[$name];

		} elseif ($this->peutCharger) {
			return $this->chargerExtension($ext);
		}
		else {
			return false;
		}
	}

	private function enregistreExtension($ext, $name) {
		$name = "Extension\\".$name;
		if (!isset($this->extensions[$name])) {
			$this->extensions[$name] = $ext;
			$parent = get_parent_class($ext);
			
			while($parent != "" && $parent != "OWeb\type\Extension" ){
				$this->extensions[$parent] = $ext;
				$parent = get_parent_class($parent);
			}

			return true;
		} else {
			throw new \OWeb\Exception("L'Extension '$name' a deja ete initialiser");
		}
	}

	private function chargerExtension($name) {
		$vraiNom = 'Extension\\' . $name;

		if(!$file = $this->autoLoader->classExists($vraiNom))
			throw new \OWeb\Exception("L'Extension '$vraiNom' demande n'existe pas");

		$extension = new $vraiNom($file);

		if($extension instanceof \OWeb\type\Extension){
			$this->enregistreExtension($extension, $name);
			return $extension;
		}else
			throw new \OWeb\Exception("L'Extension '$vraiNom' n'est pas une instance de : \OWeb\type\Extension");
	}

	public function goApi($extension){
		$ext = $this->getExtension($extension);
		if($ext){
			$ext->goApi();
		}
	}
	
	public function afficherListeExtension(){
		
		foreach ($this->extensions as $key => $value) {
			echo $key."\n";
		}
		
	}

}

?>
