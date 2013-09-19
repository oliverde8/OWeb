<?php

namespace Controller\articles\widgets;

/**
 * Description of colloneDroite
 *
 * @author De Cramer Oliver
 */
class Category_Description extends \OWeb\types\Controller {
	
	
	public function init() {
		
	}

	public function onDisplay() {
		$this->categories = $this->getParam("categories");
		$this->view->mcat = $this->categories->getElement($this->getParam("catId"));
	}
}

?>
