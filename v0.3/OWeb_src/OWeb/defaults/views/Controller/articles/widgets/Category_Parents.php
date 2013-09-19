<?php

$cat = $this->mcat->getParent();
$cates_text = "";
while($cat != null){
	
	$link = new \OWeb\utils\Link();
	$link->addParam('page', 'articles\Categorie')
		->addParam('catId', $cat->getId());
	
	$cates_text = '<span class="CategoryParents"> 
						<a href='.$link.'>'
							.$cat->getName().' '
							.htmlspecialchars('>')
						.'</a>
					</span>'.$cates_text;

$cat = $cat->getParent();
}
echo $cates_text;
?>