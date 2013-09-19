<?php

namespace Controller\articles\widgets;

/**
 * Description of Article_tree
 *
 * @author oliverde8
 */
class Article_tree extends \OWeb\types\Controller{
	
	public function init() {
		$this->InitLanguageFile();
	}

	public function onDisplay() {
		$this->view->values = $this->getParam("values");
	}		
}

?>
