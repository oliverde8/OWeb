<?php

namespace Controller\articles;

/**
 * Description of home
 *
 * @author De Cramer Oliver
 */
class home extends Categorie{
	
	private $categories;
	private $articles;
	
	public function init() {
		$this->addParams("catId", 1);
		parent::init();
	}
	
	public function onDisplay() {
		$this->view->showCatHeader = false;
		parent::onDisplay();
	}
}

?>
