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

namespace Controller\OWeb\widgets\jquery_ui;

use \Controller\OWeb\widgets\jquery\CodeGenerator as JQueryGen;

/**
 * Allows the creation of a jqueryui Accordion.
 * Demo : http://jqueryui.com/accordion/
 * Doc : http://api.jqueryui.com/accordion/
 *
 * @author De Cramer Oliver
 */
class Accordion extends JQueryGen{

	private $sections = array();
	
	public function init() {
		parent::init();
		$this->applyTemplateController(new \Controller\demo\Template());
		
		$this->setFunction('accordion');
		$this->addOption('active', 0);
		$this->addOption('animate', '');
		$this->addOption('collapsible', 'false');
		$this->addOption('disabled', 'false');
		$this->addOption('event', '"click"');
		$this->addOption('header', '"> li > :first-child,> :not(li):even"');
		$this->addOption('heightStyle', '"auto"');
		$this->addOption('icons', '"header": "ui-icon-triangle-1-e", "activeHeader": "ui-icon-triangle-1-s" ');
	}

	public function addSection($title, $content){
		$this->sections[$title] = $content;
	}
	
	public function onDisplay() {
		if(empty($this->sections))
			return false;
		
		$this->view->sections = $this->sections;
		parent::onDisplay();
	}
	
}

?>
