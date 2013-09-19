<?php

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
		ob_start();

		try{
			//Including The template
			include OWEB_DIR_TEMPLATES."/".$tmp.".php";
			$foo = ob_get_contents();
			//Clean
			ob_end_clean();
			echo $foo;
		}catch(\Exception $ex){
			//Clean
			ob_end_clean();
			
			if($tmp == 'main'){
				$ctr = \OWeb\manage\Controller::getInstance()->loadException($e);
				$ctr->Init();
				$ctr->addParams("exception",$ex);
				\OWeb\manage\Controller::getInstance()->display();
			}else{
				new Template();
			}
		}		
	}
	
	private function prepareDisplay(){
		
		//We save the content so that if there is an error we don't show half displayed codes
		ob_start();
		try{
			\OWeb\manage\Controller::getInstance()->display();
			
		}catch(\Exception $e){
			ob_end_clean();
			ob_start();
			$ctr = \OWeb\manage\Controller::getInstance()->loadException($e);
			$ctr->Init();
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
