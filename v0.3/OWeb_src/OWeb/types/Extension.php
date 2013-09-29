<?php
/**
 * @author      Oliver de Cramer (oliverde8 at gmail.com)
 * @copyright    GNU GENERAL PUBLIC LICENSE
 *                     Version 3, 29 June 2007
 *
 * PHP version 5.3 and above
 *
 * LICENSE: This program is free software: you can redistribute it and/or modify
 *  it under the terms of the GNU General Public License as published by
 *  the Free Software Foundation, either version 3 of the License, or
 *  (at your option) any later version.
 *
 *  This program is distributed in the hope that it will be useful,
 *  but WITHOUT ANY WARRANTY; without even the implied warranty of
 *  MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 *  GNU General Public License for more details.
 *
 *  You should have received a copy of the GNU General Public License
 *  along with this program.  If not, see {http://www.gnu.org/licenses/}.
 */
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
