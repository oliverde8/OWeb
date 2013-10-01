<?php

$this->addHeader('2Collone.css', \OWeb\manage\Headers::css);
$this->addHeader('articles.css', \OWeb\manage\Headers::css);
$this->addHeader('onprogress.css', \OWeb\manage\Headers::css);
$this->addHeader('programs.css', \OWeb\manage\Headers::css);
//$this->addHeader('pages/programs.js', \OWeb\manage\Headers::javascript);
$this->addHeader('<script type="text/javascript" src="http://127.0.0.1/oliverde8/oliverde8/OWeb/v0.3/www_oliverde8_files/web/sources/js/pages/programs.js"></script>', \OWeb\manage\Headers::code);

?>

<div id="twoCollone">
	<div>
		<div class="ColloneGauche">
			<div>
				<h1>Whats new?, Whats going On?</h1>

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
		<?php
		$catTree = \OWeb\manage\SubViews::getInstance()->getSubView('\Controller\programs\widgets\ColloneDroite');
		$catTree->addParams('cats', $this->cats)
				->display();
		?>
		<div class="ColloneClean"></div>
	</div>
</div>

