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

namespace Controller\OWeb\Helpers\Form;

/**
 * Description of Form
 *
 * @author De Cramer Oliver
 */
abstract class Form extends \Controller\OWeb\Helpers\HtmlElement{
	
	private $_displayElements;
	private $_elements;
	private $_isValid;
	
	public function init() {
		$this->registerElements();
	}
	
	
	protected function validateElements(){
		$this->_isValid = true;
		foreach ($this->_elements as $element) {
			$this->_isValid = $this->_isValid && $element->validate();
		}
	}
	
	public function addDisplayElement(\OWeb\types\Controller $element){
		$this->_displayElements[] = $element;
		if($element instanceof Controller\OWeb\Helpers\Elements\Elements)
			$this->_elements[] = $element;
		$element->init();
	}
	
	abstract protected function registerElements();

	
	public function isValid(){
		return $this->_isValid;
	}
	
	public function onDisplay() {
		$this->view->htmlIdentifier = $this->generateHtmlIdentifier();
		$this->view->elements = $this->_displayElements;
	}	
}

?>
