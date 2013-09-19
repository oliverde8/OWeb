<?php
	$this->addHeader('2Collone.css',\OWeb\manage\Headers::css); 
	$this->addHeader('articles.css',\OWeb\manage\Headers::css); 
?>
<div id="twoCollone">
	<div>
		<div class="ColloneGauche">
			<div>
				<?php
if(is_array($this->articles)){
	foreach($this->articles as $article){
		\OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\Article_Title')
				->addParams('article', $article)
				->display();
		\OWeb\manage\SubViews::getInstance()->getSubView('Controller\articles\widgets\show_article\Def')
				->addParams('article', $article)
				->addParams('short', true)
				->addParams('image_level', 2)
				->display();

	}
}	?>
			</div>
		</div>
<?php
	$catTree = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\articles\widgets\ColloneDroite');
	$catTree->addParams('cats', $this->cats)
			->display();
?>
		<div class="ColloneClean"></div>
	</div>
</div>