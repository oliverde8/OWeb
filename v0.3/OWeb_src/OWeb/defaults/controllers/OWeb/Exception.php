<?php

namespace Controller\OWeb;

/**
 * Description of Exception
 *
 * @author De Cramer Oliver
 */
class Exception extends \OWeb\types\Controller{
	
	public function init(){
		$this->InitLanguageFile();
	}
	
	
	public	function onDisplay() {
		$exception = $this->getParam("exception");
		$this->view->messages = array();
		
		if($exception instanceof \Exception){
			$this->view->messages[]=$exception;
			while ($exception->getPrevious() != null){
				$exception = $exception->getPrevious();
				$this->view->messages[]=$exception;
			}
		}
	}

}

?>
