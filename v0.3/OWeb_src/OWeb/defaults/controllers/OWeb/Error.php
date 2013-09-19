<?php

namespace Controller\OWeb;

/**
 * Description of Error
 *
 * @author De Cramer Oliver
 */
class Error extends \OWeb\types\Controller{
	
	public function init(){
		$this->InitLanguageFile();
	}
	
	public	function onDisplay() {
		$this->view->title = $this->getParam("Title");
		$this->view->desc = $this->getParam("Description");
		$this->view->img = $this->getParam("img");
		
	}
}

?>
