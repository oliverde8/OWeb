<?php

namespace Controller\programs;

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Home
 *
 * @author oliverde8
 */
class Home extends \OWeb\types\Controller{
	
	
	private $categories;
	private $programs;
	
	public function init() {
		$this->InitLanguageFile();
		$this->categories = new \Model\programs\Categories();
		$this->programs = new \Model\programs\Programs($this->categories, new \Model\articles\Artciles(new \Model\articles\Categories()));
	}

	public function onDisplay() {
		$this->view->cats = $this->categories;
		
		$this->categories->getAll();
		
		$this->view->previews_title = array();
		$this->view->previews = array();
		
		$this->view->previews_title[] = '<img src="'.OWEB_HTML_URL_IMG.'/page/programing/tm-logo_small.jpg" /> 
					<img src="'.OWEB_HTML_URL_IMG.'/page/programing/mp-logo_small.png" />
					Related Projects';
		$this->view->previews[] =  $this->programs->getProgramArticles($this->categories->getElement(1), 0, 100);
		
		$this->view->previews_title[] = 'Some interesting University Projects';
		$this->view->previews[] =  $this->programs->getProgramArticles($this->categories->getElement(2), 0, 100);
		
		/*foreach($this->view->articles as $article){
			echo $article->getId().", ";
		}*/
	}
}

?>
