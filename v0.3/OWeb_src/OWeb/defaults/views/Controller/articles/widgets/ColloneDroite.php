
<div class="ColloneDroite">
	<div>
		<p>
			<h3>Categories</h3>
			<?php
			$catTree = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\OWeb\widgets\TreeList');
			$catTree->addParams('tree', $this->cats)
							->addParams('class','articles_category')
							->addParams('classes',array('articles_category_1'))
							->addParams('link',  new OWeb\utils\Link(array('page'=>'articles\Categorie', 'catId'=>'')));
							//->addParams('link', 'test'); 
			$catTree->display();
?>
	</p>
	</div>
</div>
