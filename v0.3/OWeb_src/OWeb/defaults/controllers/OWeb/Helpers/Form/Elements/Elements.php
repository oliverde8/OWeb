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

namespace Controller\OWeb\Helpers\Form\Elements;

/**
 * Description of Elements
 *
 * @author De Cramer Oliver
 */
abstract class Elements extends \Controller\OWeb\Helpers\HtmlElement{
	
	private $_valid = true;
	private $_name;
	private $_title;
	private $_desc = null;
	private $_type;
	private $_val = null;
	private $_trueVal = null;
	
	private $_validators = array();
	
	private $_errMessages = array();
	private $_errDesriptions = array();

	
	public function init() {
		parent::init();
		$this->addHtmlClass('OWebForm_input');
	}
	
	public function setType($type){
		$this->_type = $type;
	}
	
	public function getType(){
		return $this->_type;
	}
	
	public function setName($name){
		$this->_name = $name;
	}
	
	public function getName(){
		return $this->_name;
	}
	
	public function setTitle($title){
		$this->_title = $title;
	}
	
	public function getTitle(){
		return $this->_title;
	}
	
	public function setDescription($desc){
		$this->_desc = $desc;
	}
	
	public function getDescription(){
		return $this->_desc;
	}
	
	public function addValidator(\OWeb\utils\inputManagement\Validators $validator){
		$this->_validators[] = $validator;
	}
	
	public function resetValidator(){
		$this->_validators[] = array();
	}
	
	public function validate(){
		
		if(empty($this->_validators)){
			$this->_valid = true;
			return true;
		}
		
		$valid = false;
		$newValue = null;
		foreach ($this->_validators as $validator) {
			try{
				$newGeneratedValue = $validator->valideteValue($this->getVal());
				if(!$valid)
					$newValue = $newGeneratedValue;
				$valid = true;
			} catch ( \OWeb\types\UserException $ex){
				$valid = $valid || false;
				$this->_errMessages[] = $ex->getMessage();
				$this->_errDesriptions[] = $ex->getUserDescription();
			}
		}
		
		if($valid)
			$this->_trueVal = $newValue;
		else 
			$this->_trueVal = null;
		
		$this->_valid = $valid;
		
		return $valid;
	}
	
	public function getVal(){
		return $this->_trueVal == null ? $this->_val : $this->_trueVal;
	}
	
	public function setVal($val){
		$this->_val = $val;
	}
	
	public function getErrMessage(){
		return $this->_errMessages;
	}
	
	public function setFormId($id, $nb){
		$this->addHtmlClass($id.'_'.$nb);
	}
	
	public function prepareDisplay(){
		
	}


	public final function onDisplay(){
		$this->prepareDisplay();
		$this->view->htmlIdentifier = $this->getIdentifier();
		$this->view->title = $this->_title;
		$this->view->type = $this->_type;
		$this->view->desc = $this->_desc;
		$this->view->name = $this->_name;
		$this->view->errMessages = $this->_errMessages;
		$this->view->errDescriptions = $this->_errDesriptions;
		$this->view->val = $this->_val;
		$this->view->valid = $this->_valid;
	}
}

?>
