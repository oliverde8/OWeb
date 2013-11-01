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

namespace Controller\OWeb\widgets\jquery;

/**
 * Allows easily to create a Jquery plugin widget maintaining the main features of it inside.
 *
 * @author De Cramer Oliver
 */
abstract class CodeGenerator extends OWeb\types\Controller{
	
	//List of all Default values
	private $defValues = array();
	
	//List of all values that must be put even throught they have a default value.
	private $necessary = array();
	
	private $id = null;
	
	private $function = null;
	
	/**
	 * Add an option that this code might have or must have 
	 * 
	 * @param String $name The name of the option
	 * @param String/int $defaultValue The default value this function has
	 * @param Boolean Does the code requires this option to work? 
	 */
	public function addOption($name, $defaultValue, $necessary=false){
		$this->defValues[$name] = $defaultValue;
		if($necessary)
			$this->necessary[$name] = true;
	}
	
	/**
	 * Th id or class of the field this Jquery function must be called on
	 * 
	 * @param String $id
	 */
	public function setId($id){
		$this->id = $id;
	}


	/**
	 * Generates the jquery code with default values as well
	 * 
	 * @param type $selector
	 * @param type $function
	 * @return string
	 */
	protected function generateJqueryCode($selector, $function){
	
		$code = '$( "'.$selector.'" ).'.$function.'(';
		$optionsShown = false;
		
		
		foreach($this->necessary as $pname => $v){		
			$pvalue = $this->getParam($pname);
			if($pvalue == null)
				$pvalue = $this->defValues[$pname];
			
			if(!$optionsShown){
				$code .= '{';
				$optionsShown = true;
			}else
				$code .=',';

			$code .= "\n $pname : \"$pvalue\"";

		}
		
		foreach($this->getParams() as $pname => $pvalue){
		
			if(!isset($this->necessary[$pname]) || $this->defValues[$pname] != $pvalue){
				
				if(!$optionsShown){
					$code .= '{';
					$optionsShown = true;
				}else
					$code .=',';
				
				unset($necessary[$pname]);
				
				$code .= "\n $pname : \"$pvalue\"";
			}
		}
		
		
		
		if($optionsShown)
			$code .= "\n}";
		
		$code .= ');';
		
		return $code;
	}

	public function onDisplay() {
		if($this->id == null)
			$this->id = ".".(String)(new OWeb\utils\IdGenerator ());
		
		if($this->function == null){
			$ex = new OWeb\Exception("When creating a Jquery Code Generator you need to call setCallFunction to set up the function that needs to be called");
			$ex = new OWeb\types\UserException($this->l("Function unset Error Title"), 0, $ex);
			$ex->setUserDescription($this->l("Function unset Error Desc"));
			throw $ex;
		}
		$this->view->jqueryCode = $this->generateJqueryCode($this->id, $function);
	}
	

}

?>
