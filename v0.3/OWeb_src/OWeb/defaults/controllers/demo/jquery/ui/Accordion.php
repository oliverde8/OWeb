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

namespace Controller\demo\jquery\ui;

/**
 * Description of Accordion
 *
 * @author De Cramer Oliver
 */

class Accordion extends \OWeb\types\Controller{
	
	private $form;
	private $accordion;
	
	public function init() {
		$this->applyTemplateController(new \Controller\demo\Template());
		$this->addAction('refresh', 'doRefresh');
		
		$this->form = new \Controller\demo\jquery\ui\AccordionForm();
		$this->form->init();
		$this->form->loadParams();
	
		
		$this->accordion = new \Controller\OWeb\widgets\jquery_ui\Accordion();
		$this->accordion->init();
	}
	
	public function doRefresh(){
		$this->form->validateElements();
		
		if($this->form->isValid()){
			foreach($this->form->getElements() as $element){
				$this->accordion->addParams($element->getName(), $element->getVal());
			}
		}
	}

	public function onDisplay() {
		
		$this->view->form = $this->form;
		
		$this->view->accordion = $this->accordion;
	}
}

?>
