<?php

namespace Controller\OWeb\widgets;

/**
 * Description of MultiPage
 *
 * @author oliverde8
 */
class MultiPage extends \OWeb\types\Controller{

	
	public function init() {
		$this->InitLanguageFile();
	}

	public function onDisplay() {
		
		$this->view->link = $this->getParam("link");
		$this->view->cpage = $this->getParam("cpage");
		$this->view->lpage = $this->getParam("lpage");
		$this->view->pname = $this->getParam("pname");
		
		$nbElement = $this->getParam("nbElement");
		
		if(empty($nbElement)){
			$nbElement = \OWeb\manage\Settings::getInstance ()->getDefSettingValue($this, "MultiPage_NbElements");
		
			if(!$nbElement)
				$nbElement = 7;
		}
		
		$this->view->nbElement = $nbElement;
	}	
}

?>
