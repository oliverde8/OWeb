<?php

namespace Controller\programs;

/**
 * Description of Categorie
 *
 * @author oliverde8
 */
class Categorie  extends \OWeb\types\Controller{
	
	private $categories;
	
	public function init() {
		$this->InitLanguageFile();
		$this->categories = new \Model\programs\Categories();
	}

	public function onDisplay() {
		$this->view->cats = $this->categories;
		$this->view->categorie = $this->categories->getElement($this->getParam('catId'));
	}
	
}

?>
