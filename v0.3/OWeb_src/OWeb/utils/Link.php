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
namespace OWeb\utils;

/**
 * Description of Link
 *
 * @author De Cramer Oliver
 */
class Link {
	
	private static $currentLink = null;
	
	
	private $generator = null;
	private $params = array();
	
	function __construct($params=array(), \OWeb\utils\link\Generator $generator=null) {
		$this->params = $params;
		if($generator == null)
			$this->generator = new \OWeb\utils\link\Default_generator();
		else
			$this->generator = $generator;
	}

	public function removeParam($paramName){
		if(isset($this->params[$paramName]))
			unset($this->params[$paramName]);
		return $this;
	}
	
	public function addParam($paramName, $value){
		$this->params[$paramName] = $value;
		return $this;
	}
	
	public function __toString() {
		return $this->generator->generate_LinkString($this->params);
	}
	
	public static function getCurrentLink($generator=null){
		if(self::$currentLink != null)
			return self::$currentLink;
		else{
			return new Link(\OWeb\OWeb::getInstance()->get_get(), $generator);
		}
	}
}

?>
