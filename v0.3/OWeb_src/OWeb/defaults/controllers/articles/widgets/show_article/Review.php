<?php

namespace Controller\articles\widgets\show_article;

/**
 * Description of Def
 *
 * @author De Cramer Oliver
 */
class Review extends \OWeb\types\Controller{
	
	private $ext_bbCode;
	
	public function init() {
		$this->ext_bbCode = \OWeb\manage\Extensions::getInstance()->getExtension('bbcode\JBBCode');
		$this->InitLanguageFile();
	}

	public function onDisplay() {
		
		if($this->getParam('short')=="" || !is_bool($this->getParam('short')))
			$this->view->short = false;
		else 
			$this->view->short = $this->getParam('short');
		
		if($this->getParam('image_level')=="" || !is_numeric($this->getParam('image_level'))){
			$this->view->image_level = 2;
		}else{
			$this->view->image_level = $this->getParam('image_level');
		}
		
		$this->view->ext_bbCode = $this->ext_bbCode;
		$this->view->article = $this->getParam("article");
		
		
	}	
}

?>
