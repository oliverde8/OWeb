<?php

namespace Controller\articles;

/**
 * Description of Categories
 *
 * @author De Cramer Oliver
 */
class Categorie extends \OWeb\types\Controller{
	
	private $nbElementPage = 10;
	
	private $categories;
	private $articles;
	
	public function init() {
		\OWeb\manage\Extensions::getInstance()->getExtension('bbcode\JBBCode');
		$this->categories = new \Model\articles\Categories();
		$this->articles = new \Model\articles\Artciles($this->categories);
	}

	public function onDisplay() {
		$this->view->cats = $this->categories;
		$this->view->mcat = $this->categories->getElement($this->getParam("catId"));
		
		$page = $this->getParam('npage');
		if(empty($page))
			$page = 0;
		else 
			$page--;
		
		$this->view->articles = $this->articles->getCategoryArticles($this->view->mcat, $this->nbElementPage*$page, $this->nbElementPage);
		$this->view->nbArticle = $this->articles->getNbCategoryArticles($this->view->mcat);
		$this->view->cpage = $page;
		$this->view->nbElementPage = $this->nbElementPage;
	}
	
}

?>
