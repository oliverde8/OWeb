<?php

namespace Controller\articles;

/**
 * Description of article
 *
 * @author De Cramer Oliver
 */
class Article extends \OWeb\types\Controller{
	
	private $categories;
	private $articles;
	
	public function init() {
		\OWeb\manage\Extensions::getInstance()->getExtension('bbcode\JBBCode');
		$this->categories = new \Model\articles\Categories();
		$this->articles = new \Model\articles\Artciles($this->categories);
	}

	public function onDisplay() {
		$this->view->cats = $this->categories;
		$this->view->article = $this->articles->getArticle($this->getParam("id"));
	}
}

?>
