<?php

namespace Controller\articles\widgets;

/**
 * Description of Article_Title
 *
 * @author De Cramer Oliver
 */
class Article_Title extends \OWeb\types\Controller{
	
	public function init() {
		$this->InitLanguageFile();
	}

	public function onDisplay() {
		$this->view->article = $this->getParam("article");
	}	
}

?>
