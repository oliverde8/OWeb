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
 * Description of AccordionForm
 *
 * @author De Cramer Oliver
 */
class AccordionForm extends \Controller\OWeb\Helpers\Form\Form{
	//put your code here
	
	protected function registerElements() {
		$this->action_mode = self::ACTION_POST;
		
		$jsString = new \OWeb\utils\inputManagement\validators\JsString();
		
		$this->setAction('refresh');
		
		$active = new \Controller\OWeb\Helpers\Form\Elements\Text();
		$active->setName('active');
		$active->setTitle('Active');
		$active->setDescription("Which panel is currently open.");
		$active->addValidator(new \OWeb\utils\inputManagement\validators\Integer());
		$active->setVal(0);
		$this->addDisplayElement($active);
		
		$animate = new \Controller\OWeb\Helpers\Form\Elements\Text();
		$animate->setName('animate');
		$animate->setTitle('Animate');
		$animate->setVal('Animate');
		$animate->addValidator($jsString);
		$animate->setDescription("If and how to animate changing panels.");
		//$this->addDisplayElement($animate);
		
		$collapsible = new \Controller\OWeb\Helpers\Form\Elements\Radio();
		$collapsible->setName('collapsible');
		$collapsible->setTitle('Collapsible');
		$collapsible->add("true", "true");
		$collapsible->add("false", "false");
		//$collapsible->addValidator($jsString);
		$collapsible->setVal('true');
		$collapsible->setDescription("hether all the sections can be closed at once. Allows collapsing the active section");
		$this->addDisplayElement($collapsible);
		
		$disabled = new \Controller\OWeb\Helpers\Form\Elements\Radio();
		$disabled->setName('disabled');
		$disabled->setTitle('Disabled');
		$disabled->add("true", "true");
		$disabled->add("false", "false");
		//$disabled->addValidator($jsString);
		$disabled->setVal('false');
		$disabled->setDescription("Disables the accordion if set to true.");
		$this->addDisplayElement($disabled);
		
		$event = new \Controller\OWeb\Helpers\Form\Elements\Text();
		$event->setName('event');
		$event->setTitle('Event');
		$event->setVal('click');
		$event->addValidator($jsString);
		$event->setDescription("The event that accordion headers will react to in order to activate the associated panel. Multiple events can be specified, separated by a space.");
		$this->addDisplayElement($event);
		
		$heightStyle = new \Controller\OWeb\Helpers\Form\Elements\Select();
		$heightStyle->setName('heightStyle');
		$heightStyle->setTitle('Height Style');
		$heightStyle->add("Auto", "auto");
		$heightStyle->add("Fill", "fill");
		$heightStyle->add("Content", "content");
		$heightStyle->addValidator($jsString);
		$heightStyle->setVal('auto');
		$heightStyle->setDescription("Controls the height of the accordion and each panel.");
		$this->addDisplayElement($heightStyle);
		
		$submit = new \Controller\OWeb\Helpers\Form\Elements\Submit();
		$submit->setVal("Refresh");
		$this->addDisplayElement($submit);
	}	
}

?>
