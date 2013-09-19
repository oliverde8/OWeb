<?php

namespace OWeb\types;

/**
 * Description of View
 *
 * @author De Cramer Oliver
 */
class View {
	
	private $__name;
	private $__language;
	
	private $__path;
	
	function __construct($name, $path, $language) {
		$this->__name = $name;
		
		$this->__path = $path;
		 
		 $this->__language = $language;
	}
	
	protected function getLangString($name){
		return $this->__language->get($name);
	}
	
	protected function l($name){
		return $this->__language->get($name);
	}
	
	protected function getLang(){
		return $this->__language->getLang();
	}
	
	public function display(){
		include $this->__path;
	}
	
	public function addHeader($code, $type){
		\OWeb\manage\Headers::getInstance()->addHeader($code, $type);
	}
}

?>
