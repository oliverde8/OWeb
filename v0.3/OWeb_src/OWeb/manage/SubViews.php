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

namespace OWeb\manage;

/**
 * Subviews are just controllers not used as pages. Any controller can be used as a SubView.
 * This class will allow you to load and use them easily. 
 * 
 * notes :
 *	* SubViews wont't be y default initialized. you need to do so by calling ->init() of the Controller returned by getSubView
 *	* The same way SubViews wan't be affected by actions, you need to call ->doAction($actionName) of the Controller
 *
 * @author De Cramer Oliver
 */
class SubViews extends \OWeb\utils\Singleton{
	
	private $subViews = array();
	
	function __construct() {
		$events = \OWeb\manage\Events::getInstance();
	}
	
	/**
	 * note : You may use multiple times the same controller as a SubView. 
	 * 
	 * @param type $name Name of the controller you want to use as a sub view.
	 * @return \Controller The controller that was asked.
	 * @throws \OWeb\manage\exceptions\Controller
	 */
	public function getSubView($name){
		try{
			$controller = new $name();

			if(! ($controller instanceof \OWeb\types\Controller))
				throw new \OWeb\manage\exceptions\Controller("A Controller needs to be an instance of \OWeb\Types\Controller");	
			
			$this->subViews[] = $controller;
			
			\OWeb\manage\Events::getInstance()->sendEvent('loaded@OWeb\manage\SubViews',$controller);
			$controller->init();
			return $controller;
			
		}catch(\Exception $ex){
			throw new \OWeb\manage\exceptions\Controller("The SubView couldn't be loaded due to Errors",0,$ex);
		}
	}
	
	
}

?>
