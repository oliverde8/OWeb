<?php

$this->addHeader('2Collone.css', \OWeb\manage\Headers::css);
$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);

?>

<div id="twoCollone">
	<div>
		<div class="ColloneGauche">
			<div>
				<h1>Whats new?, Whats going On?</h1>
				
				
			</div>
		</div>
		<?php
		$catTree = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\programs\widgets\ColloneDroite');
		$catTree->addParams('cats', $this->cats)
				->display();
		?>
		<div class="ColloneClean"></div>
	</div>
</div>
?>
