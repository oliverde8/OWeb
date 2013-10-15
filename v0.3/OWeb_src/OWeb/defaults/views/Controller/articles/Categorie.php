<?php

	$this->addHeader('articles.css',\OWeb\manage\Headers::css); 

if(!isset($this->showCatHeader) || $this->showCatHeader)
	\OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\Category_Description')
		->addParams('categories', $this->cats)
		->addParams('catId', $this->mcat->getId())
		->display();

	// Articles -->
$nbArticle = 0;
if(is_array($this->articles)){
	foreach($this->articles as $article){
		\OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\Article_Title')
				->addParams('article', $article)
				->display();
		\OWeb\manage\SubViews::getInstance()->getSubView('Controller\articles\widgets\show_article\Def')
				->addParams('short', true)
				->addParams('image_level', 1)
				->addParams('article', $article)
				->display();
		$nbArticle++;
	}
}
$nbArticleShown = $nbArticle + $this->cpage*$this->nbElementPage;
?>
				<div class="pageNb">
<?php

	\OWeb\manage\SubViews::getInstance()->getSubView('\Controller\OWeb\widgets\MultiPage')
				->addParams('link',\OWeb\utils\Link::getCurrentLink())
				->addParams('cpage',$this->cpage)
				->addParams('pname','npage')
				->addParams('lpage',$this->nbArticle/$this->nbElementPage)
				->display();


	/*if($this->cpage>0){
		echo '<a href="'.\OWeb\utils\Link::getCurrentLink()->addParam("npage", $this->cpage).'"> << Previous</a>';
	}
	
	if($nbArticleShown < $this->nbArticle){
		echo '<a href="'.\OWeb\utils\Link::getCurrentLink()->addParam("npage", $this->cpage+2).'"> Next</a>';
	}*/
?>
</div>