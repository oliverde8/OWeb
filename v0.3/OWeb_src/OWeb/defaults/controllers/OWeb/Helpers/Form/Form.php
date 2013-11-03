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
	
	private $_formId;
	private $_displayElements = array();
	private $_elements = array();
	
	private $_isValid;
	private $_action = null;
	
	public function init() {
		parent::init();
		$this->registerElements();
		$this->addHtmlClass('OWebForm_input');
	}
	
	
	public function validateElements(){
		$this->_isValid = true;
		foreach ($this->_elements as $element) {
			$element->setVal($this->getParam($element->getName()));
			
			$valid = $element->validate();			
			$this->_isValid = $this->_isValid && $valid;
		}
	}
	
	public function addDisplayElement(\OWeb\types\Controller $element){
		$this->_displayElements[] = $element;
		if($element instanceof \Controller\OWeb\Helpers\Form\Elements\Elements){
			$this->_elements[] = $element;
		}
		$element->init();
	}
	
	abstract protected function registerElements();

	
	public function isValid(){
		return $this->_isValid;
	}
	
	public function setFormId($id){

	}
	
	public function setAction($actionName){
		$this->_action = new Elements\Hidden();
		$this->_action->setName('action');
		$this->_action->setVal($actionName);
		$this->_action->init();
	}
	
	public function onDisplay() {
		$this->view->htmlIdentifier = $this->getIdentifier();
		$this->view->elements = $this->_displayElements;
		$this->view->actionMode = $this->action_mode;
		$this->view->action = $this->_action;
	}
	
	public function getElements(){
		return $this->_elements;
	}
}

?>
