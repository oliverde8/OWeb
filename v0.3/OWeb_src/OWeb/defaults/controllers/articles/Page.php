<?php

namespace Controller\articles;

/**
 * Description of Page
 *
 * @author De Cramer Oliver
 */
class Page extends \OWeb\types\Controller{
	
	private $categories;
	private $articles;
	
	
	public function init() {
		\OWeb\manage\Extensions::getInstance()->getExtension('bbcode\JBBCode');
		$this->InitLanguageFile();
		$this->categories = new \Model\articles\Categories();
		$this->articles = new \Model\articles\Artciles($this->categories);
	}

	public function onDisplay() {
		$cats = explode('.',  $this->getParam("name"));
		
		$article_title = $cats[sizeof($cats)-1];
		unset($cats[sizeof($cats)-1]);
		
		//Searching for the article
		
		//Firsty lets find the Root Element for pages.
		$childs = $this->categories->getAllRoot();
		$found = false;
		$i = 0;
		$cat = null;
		while($i < sizeof($childs) && !$found){
			
			if($childs[$i]->getName() == 'Page'){
				$found = true;
				$cat = $childs[$i];
				$childs = $childs[$i]->getChildrens();
			}
			$i++;
		}
		
		//Now lets find THe category tree
		foreach($cats as $num => $name){
			$i = 0;
			$cat = null;
			$found = false;
			while($i < sizeof($childs) && !$found){
				if($childs[$i]->getName() == $name){
					$found = true;
					$cat = $childs[$i];
					$childs = $childs[$i]->getChildrens();
				}
				$i++;
			}
		}
		
		$this->view->cats = $this->categories;
		$this->view->content = null;
		//Now the article of this category Finally.
		if($cat != null)
			$this->view->content = $this->articles->getArticleByNameCategory($article_title, $cat);
		
		
	}
}

?>
