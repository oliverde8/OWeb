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

/**
 * Description of View
 *
 * @author De Cramer Oliver
 */
class View {
	
	private $__name;
	private $__language;
	private $__dependence;
	
	private $__path;
	
	function __construct($name, $path, $language) {
		$this->__name = $name;
		
		$this->__path = $path;
		 
		 $this->__language = $language;
	}
	
	protected function getLangString($name){
		return $this->__language->get($name);
	}
	
	protected function l($name){
		return $this->__language->get($name);
	}
	
	public function setDependences($dependences){
		$this->__dependence == $dependences;
	}
	
	public function __call($name, $arguments){		
        for($this->__dependence->rewind(); $this->__dependence->valid(); $this->__dependence->next()){
			$current = $this->__dependence->current();
			$alias = $current->getAlias($name);
			if($alias != null){
				$current->$alias($arguments);
				return;
			}
		}
		throw new \OWeb\Exception("The function: " . $name." doesen't exist and couldn't be find in any extension to whom the plugin depends",0);
    }
	
	protected function getLang(){
		return $this->__language->getLang();
	}
	
	public function display(){
		include $this->__path;
	}
	
	public function addHeader($code, $type){
		\OWeb\manage\Headers::getInstance()->addHeader($code, $type);
	}
}

?>
