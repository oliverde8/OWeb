<?php

namespace OWeb\types;

use OWeb\manage\Extensions;
use OWeb\types\extension\Depandence;

/**
 * Description of Extension
 *
 * @author De Cramer Oliver
 */
abstract class Extension extends \OWeb\utils\Singleton{

	private $actions;
	private $evenments;
	private $dependence;
	
	abstract protected function init();
	
	public function OWeb_Init() {

		if (!empty($this->dependence)) {
			foreach ($this->dependence as $dep) {

				try{
					$ext = Extensions::getInstance()->getExtension($dep->name);
					if (!$ext) {
						throw new \OWeb\Exception("");
					}else {
						$name2 = \str_replace('\\', '_', $dep->name);
						$name = "ext_" . $name2;
						$this->$name = $ext;
					}
				}catch (\OWeb\Exception $exception){
					throw new \OWeb\Exception("Impossible de charger l'extension : " . $dep->name.". L'extention " . get_class($this) . " en a basoin pour fonctionner",0, $exception);
				}
			}
		}
		$this->init();
	}
	
	public function add_Event($Nomevent, $fonction) {
		\OWeb\manage\Events::getInstance()->registerEvent($Nomevent, $this, $fonction);
	}
	
	protected function loadSettings($fichier = "") {
		$reglage = \OWeb\manage\Settings::getInstance();
		return $reglage->getSetting($this, $fichier);
	}
	
	protected function addDependance($plugin_name) {
		$dep = new Depandence($plugin_name);
		$this->dependence[] = $dep;
	}
}

?>
