<?php

namespace Page\OWeb\errors\http;

/**
 * Description of NotFound
 *
 * @author De Cramer Oliver
 */
class NotFound extends \OWeb\types\Controller{

	public function init() {
		
	}

	public function onDisplay() {
		$this->view->page_name = $this->getParam("page_name");
	}
	
}

?>
