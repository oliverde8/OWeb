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

namespace Controller\OWeb\Helpers;

/**
 * Description of HtmlElement
 *
 * @author De Cramer Oliver
 */
abstract class HtmlElement extends \OWeb\types\Controller{
	
	private $_htmlId = null;
	private $_htmlClass = null;
	
	public function setHtmlId($id){
		$this->_htmlId = $id;
	}
	
	public function getHtmlId(){
		return $this->_htmlId;
	}
	
	public function addHtmlClass($class){

		if($this->_htmlClass == null)
			$this->_htmlClass='';
		else
			$this->_htmlClass .= ' ';
		
		$this->_htmlClass .= $class;
	}
	
	public function generateHtmlIdentifier(){
		$identifier = '';
		if($this->_htmlId != null)
			$identifier .= 'id="'.$this->_htmlId.'" ';
		
		if($this->_htmlClass != null)
			$identifier .= 'class="'.$this->_htmlClass.'" ';
		
		return $identifier;
	}
	
}

?>
