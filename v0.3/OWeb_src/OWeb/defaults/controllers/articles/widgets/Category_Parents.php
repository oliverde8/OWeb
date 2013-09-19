<?php

namespace Controller\articles\widgets;

/**
 * Description of Category_Parents
 *
 * @author De Cramer Oliver
 */
class Category_Parents extends \OWeb\types\Controller {
	
	public function init() {
		
	}

	public function onDisplay() {
		$this->view->mcat = $this->getParam("cat");
	}
	
}

?>
