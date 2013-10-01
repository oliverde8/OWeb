<?php

$this->addHeader('2Collone.css', \OWeb\manage\Headers::css);
$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);
$this->addHeader('programs.css', \OWeb\manage\Headers::css);

?>

<div id="twoCollone">
	<div>
		<div class="ColloneGauche">
			<div>
				<h1>Whats new?, Whats going On?</h1>
                    <div  class="programs">
<?php

    $box = \OWeb\manage\SubViews::getInstance()->getSubView('Controller\OWeb\widgets\Box');
    $box->addParams('ctr', null)
        ->addParams('Html Class', 'programBox')
        ->display();
    $box->display();
    $box->display();
    $box->display();
    $box->display();
?>

                    </div>
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

