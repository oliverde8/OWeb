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
namespace OWeb\manage\events;

/**
 * Description of Event
 *
 * @author De Cramer Oliver
 */
class Event {
	
	protected $object;
	protected $function;
	
	function __construct($object, $function) {
		$this->object = $object;
		$this->function = $function;
	}
	
	public function setObject($object) {
		$this->object = $object;
	}

	public function setFunction($function) {
		$this->function = $function;
	}

	public function getObject() {
		return $this->object;
	}

	public function getFunction() {
		return $this->function;
	}
	
	public function doEvent($params){
		call_user_func_array(array($this->object,$this->function),$params);
	}
	
}

?>
