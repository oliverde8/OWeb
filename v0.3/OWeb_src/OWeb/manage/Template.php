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
 * Will load the Template of the page. 
 * You may load multiple Template using a custom mode.
 *
 * @author De Cramer Oliver
 */
class Template {
	
	private $content;
	
	private $language;
	
	function __construct($tmp='main') {
		
		$this->language = new \OWeb\types\Language();
		
		//First we prepare the page
		$this->prepareDisplay();
		
		//Then display the template
		//ob_start();

		//try{
			//Including The template
			include OWEB_DIR_TEMPLATES."/".$tmp.".php";
			//$foo = ob_get_contents();
			//Clean
			//ob_end_clean();
			//echo $foo;
		/*}catch(\Exception $ex){
			//Clean
			ob_end_clean();
			
			if($tmp == 'main'){
				$ctr = \OWeb\manage\Controller::getInstance()->loadException($ex);
				$ctr->Init();
				$ctr->addParams("exception",$ex);
				\OWeb\manage\Controller::getInstance()->display();
			}else{
				new Template();
			}
		}		*/
	}
	
	private function prepareDisplay(){
		
		//We save the content so that if there is an error we don't show half displayed codes
		ob_start();
		try{/**/
			\OWeb\manage\Controller::getInstance()->display();
			
		}catch(\Exception $e){
			ob_end_clean();
			ob_start();
			$ctr = \OWeb\manage\Controller::getInstance()->loadException($e);
			$ctr->addParams("exception",$e);
			\OWeb\manage\Controller::getInstance()->display();
		}
		
		$this->content = ob_get_contents();
		ob_end_clean();
	}
	
	/**
	 * Will display all the headers
	 */
	public function headers(){
		\OWeb\manage\Headers::getInstance()->display();
	}
	
	/**
	 * Will display the main controller/page 
	 */
	public function display(){
		\OWeb\manage\Events::getInstance()->sendEvent('DisplayContent_Start@OWeb\manage\Template');
		echo $this->content;
		\OWeb\manage\Events::getInstance()->sendEvent('DisplayContent_End@OWeb\manage\Template');
	}
	
	/**
	 * Adding a Header to the Page
	 * @param type $code The url, or code if the header.
	 * @param type $type The type of the header. 
	 */
	public function addHeader($code, $type){
		\OWeb\manage\Headers::getInstance()->addHeader($code, $type);
	}
	
	protected function getLangString($name){
		return $this->language->get($name);
	}
	
	protected function l($name){
		return $this->language->get($name);
	}
	
	protected function getLang(){
		return $this->language->getLang();
	}
	
	protected function InitLanguageFile(){
		$this->language->initNo();
	}
	
}

?>
