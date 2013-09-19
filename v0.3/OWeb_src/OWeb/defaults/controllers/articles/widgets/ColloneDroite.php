<?php

namespace Controller\articles\widgets;

/**
 * Description of colloneDroite
 *
 * @author De Cramer Oliver
 */
class ColloneDroite extends \OWeb\types\Controller {
	
	
	public function init() {
		
	}

	public function onDisplay() {
		$this->view->cats = $this->getParam("cats");
	}
}

?>
